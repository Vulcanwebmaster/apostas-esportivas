<?php

namespace app\models;

use app\core\Model;
use app\vo\UserTypeVO;
use app\vo\UserVO;

class UsersTypesModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_users_types';
        $this->valueObject = UserTypeVO::class;
    }

    /**
     * Verifica se o usuário ter permissão para gerenciar o tipo de conta
     * @param UserVO $user
     * @param UserTypeVO $type
     * @return boolean
     */
    static function verificaPermissao(UserVO $user, UserTypeVO $type)
    {
        $permissoes = $type->getPermissoes(true);
        if (in_array($user->getType(), $permissoes)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna os tipos de conta
     * @param int $userType
     * @return array
     */
    static function getUserTypes($userType = null)
    {
        return self::lista("WHERE (:type IS NULL OR :type = 0 OR a.permissoes LIKE CONCAT('%[',:type,']%')) AND a.status = 1 ORDER BY a.title ASC", [
            'type' => $userType,
        ]);
    }

    /**
     * Retorna a lista de tipos de conta
     * @param int $userType
     * @return string
     */
    static function options($userType = null)
    {
        $html = '';
        foreach (self::lista('WHERE a.status != 99 AND (:type IS NULL OR :type = 1 OR a.permissoes LIKE CONCAT("%[",:type,"]%")) ORDER BY a.title ASC', [
            'type' => $userType,
        ]) as $v) {
            $html .= formOption($v->getTitle(), $v->getId());
        }
        return $html;
    }

}
    