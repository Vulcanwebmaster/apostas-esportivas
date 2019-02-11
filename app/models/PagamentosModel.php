<?php
/**
 * Created by PhpStorm.
 * User: conta
 * Date: 09/06/2017
 * Time: 10:02
 */

namespace app\models;


use app\core\Model;
use app\vo\PagamentoVO;
use app\vo\UserVO;

class PagamentosModel extends Model
{

    const TYPE_CREDITO = 'credito';
    const TYPE_RECARGA = 'recarga';
    const TYPE_ADESAO = 'adesao';
    const TYPE_PRECADASTRO = 'precadastro';

    const STATUS_CANCELADO = 0;
    const STATUS_AGUARDANDO = 1;
    const STATUS_PAGO = 2;

    function __construct()
    {
        $this->table = 'sis_pagamentos';
        $this->valueObject = PagamentoVO::class;
    }

    /**
     * @param UserVO $user
     * @param string $type
     * @return PagamentoVO
     */
    public static function getEmAberto(UserVO $user, string $type = self::TYPE_RECARGA)
    {

        $termos = 'WHERE a.user = :user AND a.type = :type AND a.status = :status LIMIT 1';

        $places = [
            'status' => self::STATUS_AGUARDANDO,
            'user' => $user->getId(),
            'type' => $type,
        ];

        return current(self::lista($termos, $places));
    }

    /**
     * Cancela o pagamento
     * @param PagamentoVO $pagamento
     * @throws \Exception
     */
    public static function cancelar(PagamentoVO $pagamento)
    {

        if ($pagamento->getStatus() == self::STATUS_CANCELADO) {
            throw new \Exception('Pagamento já está cancelado');
        }

        $pagamento->setStatus(self::STATUS_CANCELADO);
        $pagamento->setDataStatus(date('Y-m-d'));
        $pagamento->save();

    }

    /**
     * Da baixa no pagamento
     * @param PagamentoVO $pagamento
     */
    public static function baixa(PagamentoVO $pagamento)
    {
        if ($pagamento->getStatus() == self::STATUS_PAGO) {
            throw new \Exception('Pagamento já recebeu baixa');
        }

        $user = $pagamento->voUser();
        $indicacao = IndicacoesModel::getIndicadorDireto($user);
        $indicador = $indicacao ? $indicacao->voIndicador() : null;

        $config = DadosModel::get();

        switch ($pagamento->getType()) {
            case self::TYPE_ADESAO:

                $user->setDataValidade(date('Y-m-d', strtotime('+1month')));
                $user->save();

                $valorPlano = DadosModel::getValorPlano($user, false);
                if ($valorPlano > 0) {
                    HistoricoBancarioModel::add($user, $valorPlano, "ADESÃO: Crédido de adesão", $user, "adesao");
                }

                if ($indicador and $indicacao) {

                    $comissao = DadosModel::getComissaoIndicacao($indicador, false);

                    if ($comissao > 0) {
                        HistoricoBancarioModel::add($indicador, $pagamento->getValor() * $comissao / 100, "COMISSÃO: Comissão de adesão do usuário <b>{$user->getLogin()}</b>", $indicacao, "adesao");
                    }

                }

                break;
            case self::TYPE_PRECADASTRO:

                HistoricoBancarioModel::add($user, $pagamento->getValor(), "Crédito de PRÉ-CADASTRO", $user, "precadastro");

                $user->setPagouPreCadastro(1);
                $user->save();

                break;
            case self::TYPE_RECARGA:

                HistoricoBancarioModel::add($user, $pagamento->getValor(), "RECARGA: Recarga", $user, "recarga");

                $valorRecarga = DadosModel::getValorRecarga($user, false);

                if ($pagamento->getValor() >= $valorRecarga) {

                    if (!$user->getDataValidade() or date('Y-m-d') > $user->getDataValidade()) {
                        $validade = date('Y-m-d', strtotime('+1month'));
                    } else {
                        $validade = date('Y-m-d', strtotime("{$user->getDataValidade()} +1month"));
                    }

                    $user->setDataValidade($validade);
                    $user->save();
                }

                break;
        }

        $pagamento->setStatus(self::STATUS_PAGO);
        $pagamento->setDataStatus(date('Y-m-d'));
        $pagamento->save();
    }

}