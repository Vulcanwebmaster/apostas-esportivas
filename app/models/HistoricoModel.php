<?php

namespace app\models;

use app\core\Model;
use app\core\ValueObject;
use app\helpers\BuildQuery;
use app\helpers\Date;
use app\helpers\Pagination;
use app\modules\admin\Admin;
use app\vo\HistoricoVO;
use app\vo\UserVO;

class HistoricoModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_historico';
        $this->valueObject = HistoricoVO::class;
        $this->query = (new BuildQuery($this->table, 'a'));
    }

    /**
     * Efetua uma busca complexa a partir dos parâmetros passados
     * @param array $parans
     * @param int $page
     * @param int $porPagina
     * @param string $OrderBy
     * @return Pagination
     */
    static function busca(array $parans = null, $page = 1, $porPagina = 10)
    {
        $termos = 'WHERE a.status != 99';
        $places = [];
        $orderby = 'a.insert DESC';
        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'dataInicial':
                        case 'dataFinal':
                            if ($data = Date::data($value)) {
                                $sinal = $key == 'dataInicial' ? '>=' : '<=';
                                $hora = $key == 'dataInicial' ? '00:00:00' : '23:59:59';
                                $termos .= " AND a.insert {$sinal} :{$key}";
                                $places[$key] = "{$data} {$hora}";
                            }
                            break;
                        case 'id':
                        case 'user':
                        case 'status':
                        case 'referencia':
                        case 'ref':
                        case 'refid':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                        case 'search':
                            $termos .= " AND (a.descricao LIKE CONCAT('%',:{$key},'%') OR a.ip = :{$key})";
                            $places[$key] = $value;
                            break;
                    }
                }
            }
        }
        return self::listaPagination("{$termos} ORDER BY {$orderby}", $places, $page, $porPagina);
    }

    /**
     * Adiciona um histórico para o registro
     * @param string $descricao
     * @param ValueObject $vo
     * @param UserVO $user
     */
    static function add($descricao, ValueObject $vo = null, UserVO $user = null)
    {

        if (!$user) {
            $user = Admin::getLogged();
        }

        self::newValueObject()
            ->Save([
                'ref' => $vo ? $vo->getTable() : null,
                'refid' => $vo ? $vo->getId() : null,
                'descricao' => $descricao,
                'ip' => getUserIP(),
                'user' => $user ? $user->getId() : 0,
            ]);
    }

    /**
     * Lista do Histórico do Registro
     * @param ValueObject $vo
     * @return string
     */
    static function get(ValueObject $vo = null)
    {
        if ($vo) {
            return self::lista("WHERE a.ref = :ref AND a.refid = :refid AND a.status = 1 ORDER BY a.insert DESC, a.id DESC", [
                'ref' => $vo->getTable(),
                'refid' => $vo->getId(),
            ], false, true, true);
        } else {
            return self::lista("WHERE a.status = 1 ORDER BY a.insert DESC", null, false, true, true);
        }
    }

}
    