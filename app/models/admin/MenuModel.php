<?php

namespace app\models\admin;

use app\core\Model;
use app\models\ModulesModel;
use app\vo\admin\MenuVO;

class MenuModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_menu';
        $this->valueObject = MenuVO::class;
        $this->query = "SELECT a.*, module.title AS moduleTitle, module.uri AS moduleURI "
            . "FROM `#table#` AS a "
            . "INNER JOIN `" . ModulesModel::getTable() . "` AS module ON module.id = a.module ";
    }

    /**
     * @param int $userType
     * @param string $module
     * @param int $status
     * @return MenuVO[]
     */
    public static function getMenu(int $userType = 0, string $module = null, int $status = null)
    {

        $termos = <<<SQL
WHERE (:status IS NULL OR a.status = :status) AND a.status != 99 AND
    (:module IS NULL OR module.uri = :module) AND 
    (:type = 0 OR a.permissoes LIKE CONCAT('%[',:type,']%'))
ORDER BY a.ordem
SQL;

        return self::lista($termos, [
            'type' => $userType,
            'status' => $status,
            'module' => $module,
        ], false, true, true);
    }

    /**
     *
     * @param int $id
     * @return MenuVO
     */
    public static function getById($id)
    {
        return self::getByLabel('id', $id, true);
    }

    /**
     * Retorna a página principal que o tipo de usuário tem acesso
     * @param int $Type
     * @param int $Module
     * @return MenuVO
     */
    public static function getPaginaPrincipal($UserType = 0, $Module = 0)
    {

        # Menu Principal Definido
        $busca = self::lista('WHERE (a.status BETWEEN 1 AND 2) AND a.principal > 0 AND '
            . '(a.controller != "") AND '
            . '(:type = 0 OR a.permissoes LIKE CONCAT("%[",:type,"]%")) AND '
            . '(a.module = :module OR module.uri = :module) '
            . 'ORDER BY module.ordem ASC, a.principal ASC '
            . 'LIMIT 1', [
            'type' => $UserType,
            'module' => $Module,
        ], false, true, true);

        # Primeiro Menu
        if (!$busca) {
            $pagina = current(self::lista('WHERE (a.status = 1 OR (a.principal > 0 AND a.status = 2)) AND '
                . '(a.controller != "") AND '
                . '(:type = 0 OR a.permissoes LIKE CONCAT("%[",:type,"]%")) AND '
                . '(a.module = :module OR module.uri = :module) '
                . 'ORDER BY module.ordem ASC, a.ordem ASC '
                . 'LIMIT 1', [
                'type' => $UserType,
                'module' => $Module,
            ], false, true, true));

            return $pagina;
        } else {
            return current($busca);
        }
    }

    /**
     * Retorna o menu
     * @param int $id
     * @param int $userType
     * @param string $module
     * @return MenuVO
     */
    static function getPage($id, $userType = NULL, string $module = null)
    {

        if(strlen($id) == 50){
            $campo = 'token';
        }else{
            $campo = 'id';
        }

        $termos = <<<SQL
WHERE 
    a.{$campo} = :id AND 
    (:module IS NULL OR module.uri = :module) AND 
    (:type IS NULL OR a.permissoes LIKE CONCAT('%[',:type,']%'))
SQL;

        $sql = self::lista($termos, [
            'type' => (int)$userType,
            'id' => $id,
            'module' => $module,
        ], false, true, true);
        return count($sql) ? $sql[0] : null;
    }

}
    