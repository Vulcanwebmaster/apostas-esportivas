<?php

namespace app\helpers\pagamento;

use Gerencianet\Gerencianet;

class GerencianetPagamento extends Pagamento
{

    /**
     * Retorna os dados da notificação da GerenciaNET
     * @param $token
     * @return mixed
     */
    public static function notificacao($token)
    {
        return (new Gerencianet(self::getOptions()))
            ->getNotification([
                'token' => $token,
            ], []);
    }

    /**
     * @return array
     */
    private static function getOptions()
    {
        return [
            'client_id' => 'Client_Id_ace4777bed8579644d6ee5b9a1d78c0d09e7c94e',
            'client_secret' => 'Client_Secret_ecb0f580f0f2a84d5e22ef61de4c3d601ecbf2e8',
            'sandbox' => false,
        ];
    }

    public function cobrar()
    {
        $api = new Gerencianet(self::getOptions());
        $pagamento = $this->getPagamento();

        $charge = $api->createCharge([], [
            'items' => $this->getItens(),
            'metadata' => [
                'custom_id' => $pagamento->getToken(),
                'notification_url' => url('gerencianet', null, 'notificacoes'),
            ]
        ]);

        $charge = $api->payCharge([
            'id' => $charge['data']['charge_id']
        ], [
            'payment' => $this->getBoleto(),
        ]);

        $pagamento->setLink($charge['data']['link']);
        $pagamento->setCodigoBarras($charge['data']['barcode']);
        $pagamento->save();
    }

    /**
     * @return array
     */
    private function getItens()
    {
        $pagamento = $this->getPagamento();

        return [
            [
                'name' => $pagamento->getDescricao(),
                'amount' => 1,
                'value' => (int)($pagamento->getValor() * 100),
            ],
            [
                'name' => 'Taxa',
                'amount' => 1,
                'value' => 399,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getBoleto()
    {
        return [
            'banking_billet' => [
                'customer' => $this->getCustomer(),
                'expire_at' => date('Y-m-d', strtotime('+5days')),
            ]
        ];
    }

    /**
     * @return array
     */
    private function getCustomer()
    {
        $user = $this->getPagamento()->voUser();

        return [
            'name' => $user->getNome(),
            'cpf' => preg_replace('/[^0-9]/', null, $user->getCpf()),
            'phone_number' => preg_replace('/[^0-9]/', null, $user->getCelular() ?: $user->getWhatsapp() ?: $user->getTelefone()),
        ];
    }


}