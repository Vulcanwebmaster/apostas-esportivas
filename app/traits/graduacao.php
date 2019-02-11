<?php
/**
 * Created by PhpStorm.
 * User: JhonLennon
 * Date: 09/07/2018
 * Time: 10:51
 */

namespace app\traits;


use app\models\GraduacoesModel;
use app\vo\GraduacaoVO;

trait graduacao
{

    private $graduacao;

    public function getGraduacaoOrdem()
    {
        if ($g = $this->voGraduacao()) {
            return $g->getOrdem();
        } else {
            return 0;
        }
    }

    /**
     * @return GraduacaoVO|null
     */
    public function voGraduacao()
    {
        return GraduacoesModel::getByLabel('id', $this->getGraduacao());
    }

    /**
     * @return mixed
     */
    public function getGraduacao()
    {
        return (int)$this->graduacao;
    }

    /**
     * @param mixed $graduacao
     * @return $this
     */
    public function setGraduacao($graduacao)
    {
        $this->graduacao = $graduacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGraduacaoTitle()
    {
        if ($g = $this->voGraduacao()) {
            return $g->getTitle();
        }
        return 'Não graduado';
    }

    /**
     * @return GraduacaoVO|null
     */
    public function voGraduacaoProxima()
    {
        if ($g = $this->voGraduacao()) {
            return current(GraduacoesModel::lista('WHERE a.status = 1 AND a.ordem > :ordem, a.title ASC ORDER BY a.ordem ASC LIMIT 1', [
                'ordem' => $g->getOrdem()
            ])) ?: null;
        } else {
            return current(GraduacoesModel::lista('WHERE a.status = 1 ORDER BY a.ordem ASC LIMIT 1')) ?: null;
        }
    }

    /**
     * @return GraduacaoVO|null
     */
    public function voGraduacaoAnterior()
    {
        if ($g = $this->voGraduacao()) {
            return current(GraduacoesModel::lista('WHERE a.status = 1 AND a.ordem < :ordem, a.title ASC ORDER BY a.ordem DESC LIMIT 1', [
                'ordem' => $g->getOrdem()
            ])) ?: null;
        } else {
            return null;
        }
    }

}