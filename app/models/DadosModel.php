<?php

namespace app\models;

use app\core\Model;
use app\vo\DadosVO;
use app\vo\UserVO;

class DadosModel extends Model
{

    private static $config;

    public function __construct()
    {
        $this->table = 'sis_dados';
        $this->valueObject = DadosVO::class;
    }

    /**
     * Verifica se o sistema está ativo
     * @return boolean
     */
    public static function estaAtivo()
    {
        $config = self::get();

        $hoje = date('Y-m-d');

        if ($config->getPeriodoInicial() <= $hoje) {
            if (!$config->getPeriodoFinal() or $config->getPeriodoFinal() >= $hoje) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retorna a configuração do sistema
     * @return DadosVO
     */
    public static function get()
    {
        if (!self::$config) {
            self::$config = current(self::lista('ORDER BY a.id DESC LIMIT 1', null, false, true, true));
            if (!self::$config) {
                self::$config = self::newValueObject([
                    'banca' => 'Grupo Adapta',
                    'periodoinicial' => date('Y-m-d'),
                    'periodofinal' => date('Y-m-d', strtotime('+5years')),
                    'periodovalor' => 30000,
                    'limiteusuarios' => 99999,
                ]);
                self::$config->Save();
            }
        }
        return self::$config;
    }

    /**
     * @param bool $formatar
     * @return string|float
     */
    public static function getValorPreCadastro($formatar = false)
    {
        return self::get()->getValorPreCadastro($formatar);
    }

    /**
     * @param UserVO $user
     * @param bool $formatar
     * @return string|float
     */
    public static function getValorRecarga(UserVO $user, bool $formatar = false)
    {
        return self::get()->valorRecarga($user, $formatar);
    }

    /**
     * @param UserVO $user
     * @param bool $formatar
     * @return float|string
     */
    public static function getValorPlanoAdesao(UserVO $user, bool $formatar = false)
    {
        return self::get()->valorPlanoAdesao($user, $formatar);
    }

    /**
     * @param UserVO $user
     * @param bool $formatar
     * @return string|float
     */
    public static function getValorPlano(UserVO $user, bool $formatar = false)
    {
        return self::get()->valorPlano($user, $formatar);
    }

    /**
     * @param UserVO $user
     * @param bool $formatar
     * @return string|float
     */
    public static function getValorAdesao(UserVO $user, bool $formatar = false)
    {
        if ($licenca = $user->voLicenca()) {
            return $licenca->getValorAdesao($formatar);
        } else {
            return 0;
        }
    }

    /**
     * @param UserVO $user
     * @param int $nivel
     * @param bool $formatar
     * @return mixed
     */
    public static function getBonusComercializacao(UserVO $user, int $nivel, bool $formatar = false)
    {
        if ($licenca = $user->voLicenca()) {
            return $licenca->get("ComissaoJogos{$nivel}", $formatar);
        } else {
            return 0;
        }
    }

    /**
     * @param UserVO $user
     * @param int $nivel
     * @param bool $formatar
     * @return mixed
     */
    public static function getBonusApuracao(UserVO $user, int $nivel, bool $formatar = false)
    {
        if ($licenca = $user->voLicenca()) {
            return $licenca->get("ComissaoApuracao{$nivel}", $formatar);
        }
        return 0;
    }

    /**
     * Recupera o percentual de indicação do usuário
     * @param UserVO $user
     * @param bool $formatar
     * @return string|float
     */
    public static function getComissaoIndicacao(UserVO $user, bool $formatar = false)
    {
        if ($licenca = $user->voLicenca()) {
            return $licenca->getComissaoIndicacao($formatar);
        } else {
            return 0;
        }
    }

}
    