<?php

namespace app\modules\admin;

use app\APP;
use app\helpers\Seo;
use app\helpers\Session;
use app\models\admin\MenuModel;
use app\models\DadosModel;
use app\models\UsersModel;
use app\vo\admin\MenuVO;
use app\vo\DadosVO;
use app\vo\UserVO;
use Browser;

class Admin
{

    private static $Session;

    /**
     * Ao iniciar a aplicação
     */
    public function __construct()
    {

        session_cache_limiter('nocache');

        /*
         * Verificando se está logado
         */
        $user = self::getLogged();

        if (!$user) {
            if (IS_AJAX) {
                json('Você precisa estar logado(a).');
            } else {
                location(url(null, null, 'entrar'));
            }
        } else if (!Admin::isMaster() and !Admin::isGerente()) {
            location(url(null, null, 0));
        }

        $this->Seo();

        if (!DadosModel::estaAtivo() or self::getConfiguracoes()->getBloqueado()) {
            if (!Admin::isMaster()) {
                if (!IS_AJAX) {
                    location(url('bloqueio'));
                } else {
                    json('Sistema inativo: Entre em contato com o administrador para mais informações.');
                }
            }
        }

        view_vars('user', $user);
        view_vars('module', APP::getCurrentModule());
        view_vars('config', self::getConfiguracoes());
        view_vars('ativo', DadosModel::estaAtivo());
        view_vars('bloqueado', self::getConfiguracoes()->getBloqueado());
        view_vars('isDev', self::isDeveloper());
        view_vars('isMaster', self::isMaster());
        view_vars('isAdmin', self::isAdmin());
        view_vars('isGerente', self::isGerente());

        $this->checkRoute();

    }

    /** @return UserVO */
    static function getLogged()
    {
        return UsersModel::getLogedUser();
    }

    /**
     * Verifica se é um usuário master (admin ou developer)
     * @return boolean
     */
    static function isMaster()
    {
        if (self::getLogged()) {
            return in_array(self::getLogged()->getType(), [UsersModel::TYPE_DEVELOPER, UsersModel::TYPE_MASTER]);
        }
        return false;
    }

    /**
     * Verifica se é um gerente
     * @return boolean
     */
    static function isGerente()
    {
        if (self::getLogged())
            return in_array(self::getLogged()->getType(), [UsersModel::TYPE_GERENTE]);
        return false;
    }

    /**
     * Configura o CSS, JS e Metatags do html
     */
    private function seo()
    {
        if (!IS_AJAX) {

            $dados = self::getConfiguracoes();

            Seo::setCharset('UTF-8');
            Seo::setTitle($dados->getBanca());
            Seo::setDescription("Escritório Virtual");

            Seo::addValue('name', 'MobileOptimized', '320');
            Seo::addValue('http-equiv', 'X-UA-Compatible', 'IE=edge');

        }
    }

    /**
     * Retorna a configuração da Banca
     * @return DadosVO
     */
    static function getConfiguracoes()
    {
        return DadosModel::get();
    }

    /**
     * Verifica se é um desenvolvedor
     * @return boolean
     */
    static function isDeveloper()
    {
        if (self::getLogged())
            return in_array(self::getLogged()->getType(), [UsersModel::TYPE_DEVELOPER]);
        return false;
    }

    /**
     * Verifica se é um administrador
     * @return boolean
     */
    static function isAdmin()
    {
        if (self::getLogged())
            return in_array(self::getLogged()->getType(), [UsersModel::TYPE_MASTER, UsersModel::TYPE_ADMINISTRADOR]);
        return false;
    }

    function checkRoute()
    {

        $param = url_parans(0);

        if ($param and preg_match('/^PAGE[a-z0-9]{50}$/i', $param)) {

            $token = str_replace('PAGE', null, $param);

            $pagina = MenuModel::getByLabel('token', $token);

            if (!$pagina instanceof MenuVO) {
                location();
            } else if (!in_array(Admin::getLogged()->getType(), $pagina->getPermissoes(true))) {
                location();
            }

            $parse = APP::parseURI("{$pagina->getModuleURI()}/{$pagina->getController()}");

            if ($parse['controller'] != APP::getControllerName()) {
                location();
            }

            view_vars('title', $pagina->getTitle());
            view_vars('page', $pagina);
            view_vars('controller', APP::getControllerName());

            $controller = APP::setController($parse['controller']);
            view_vars('controller', str_replace('\\', '/', APP::getControllerName()));
            $controller->{"{$parse['action']}Action"}($pagina);

            exit;

        } else {
            view_vars('controller', str_replace('\\', '/', APP::getControllerName()));
        }
    }

    /**
     * @return int
     */
    static function getIdLogged()
    {
        if ($user = self::getLogged())
            return $user->getId();
        return 0;
    }

    /**
     * Retorna o menu em um array
     * @return array
     */
    static function getMenu()
    {
        return MenuModel::getMenu(self::getLogged()->getType(), null, 1);
    }

    /** @return MenuVO */
    static function getCurrentPage()
    {
        return self::getSession()->get('page');
    }

    /** @return Session */
    static function getSession()
    {
        return self::$Session ?: self::$Session = new Session(__CLASS__);
    }

}
    