<?php

namespace app\models\helpers;

use app\core\Model;
use app\helpers\Date;
use app\helpers\Pagination;
use app\vo\helpers\BannerVO;

class BannersModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_banners';
        $this->valueObject = BannerVO::class;
    }

    /**
     * Retorna os banners ativos no periodo
     * @param string $ref
     * @param date $data
     * @param int $dia
     * @param int $limit
     * @param string $orderby
     * @return BannerVO[]
     */
    public static function get(string $ref, string $data = null, int $dia = null, int $limit = 5, string $orderby = 'rand()')
    {

        $places = [
            'status' => 1,
            'ref' => $ref,
            'data' => $data,
            'dia' => $dia,
            'limit' => $limit,
        ];

        return self::busca($places, 0, $limit)->getRegistros();
    }

    /**
     * Efetua uma busca complexa a partir dos parâmetros passados
     * @param array $parans
     * @param int $page
     * @param int $forPage
     * @param string $OrderBy
     * @return Pagination
     */
    static function busca(array $parans = null, $page = 1, $forPage = 10)
    {

        $termos = 'WHERE a.status != 99';
        $places = [];
        $orderby = 'rand()';

        if ($parans) {
            foreach ($parans as $key => $value) {
                if (!isEmpty($value) and !empty($key)) {
                    switch ($key) {
                        case 'data':
                            if ($data = Date::data($value)) {
                                $termos .= " AND (a.inicio IS NULL OR :data >= a.inicio) AND (a.fim IS NULL OR :data <= a.fim)";
                                $places['data'] = $data;
                            }
                            break;
                        case 'dia':
                            $termos .= ' AND (a.dias IS NULL OR a.dias LIKE "%[*]%" OR a.dias LIKE CONCAT("%[",:dia,"]%"))';
                            $places['dia'] = $value;
                            break;
                        case 'status':
                        case 'ref':
                            $termos .= " AND a.{$key} = :{$key}";
                            $places[$key] = $value;
                            break;
                        case 'title':
                            $termos .= ' AND (a.title CONCAT("%",:title,"%"))';
                            $places['title'] = $value;
                            break;
                        case 'orderby':
                            switch ($value) {
                                case 'title':
                                    $orderby = 'a.title ASC';
                                    break;
                                case 'insert':
                                    $orderby = 'a.insert DESC';
                                    break;
                                case 'ordem':
                                    $orderby = 'a.ordem ASC';
                                    break;
                                case 'tipo':
                                    $orderby = 'a.tipo ASC';
                                    break;
                                case 'rand':
                                default:
                                    $orderby = 'rand()';
                            }
                            break;
                    }
                }
            }
        }

        return self::ListaPagination("{$termos} ORDER BY {$orderby}", $places, $page, $forPage);
    }

}
    