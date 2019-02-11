<?php

namespace app\helpers;

use app\core\ValueObject;

class Pagination
{

    private $PorPagina = 20;
    private $Count = 0;
    private $VisiblePages = 11;
    private $Registros;
    private $CurrentPage = 1;

    function getPageDescription()
    {
        $inicial = $this->getCurrentPage() * $this->getForPage() - $this->getForPage() + 1;
        $final = min($inicial + $this->getForPage() - 1, $this->getCount());
        return "Exibindo de {$inicial} até {$final} de {$this->getCount()} registros";
    }

    function getCurrentPage()
    {
        return $this->CurrentPage;
    }

    /**
     * Informa a página atual
     * @param int $CurrentPage
     * @return $this
     */
    function setCurrentPage($CurrentPage)
    {
        $this->CurrentPage = max(1, $CurrentPage);
        $this->checkCurrentPage();
        return $this;
    }

    function getForPage()
    {
        return $this->PorPagina;
    }

    /**
     * Retorna o número total de registros
     * @return int
     */
    function getCount()
    {
        return $this->Count;
    }

    /**
     * Número total de registros
     * @param int $Count
     * @return $this
     */
    function setCount($Count)
    {
        $this->Count = (int)$Count;
        $this->checkCurrentPage();
        return $this;
    }

    /**
     * Verifica a página atual se está dentro dos limites
     * @return $this
     */
    private function checkCurrentPage()
    {
        $this->CurrentPage = max(1, min($this->CurrentPage, $this->getTotalPaginas()));
        return $this;
    }

    /**
     * Total de páginas
     * @return int
     */
    function getTotalPaginas()
    {
        return Number::ceil(max($this->Count, 1) / $this->PorPagina);
    }

    /**
     * Informa o número de registros por página
     * @param int $PorPagina
     * @return $this
     */
    function setPorPagina($PorPagina)
    {
        $this->PorPagina = max(1, $PorPagina);
        $this->checkCurrentPage();
        return $this;
    }

    /**
     * Retorna os registros passado para o object já cortado
     * @return array|ValueObject
     */
    function getRegistros()
    {
        return $this->Registros;
    }

    /**
     *
     * @param array $Registros
     * @param boolean $Fatiar
     * @return $this
     */
    function setRegistros(array $Registros, $Fatiar = false)
    {
        if ($Fatiar) {
            $this->setCount(count($Registros));
            $this->Registros = array_slice($Registros, ($this->CurrentPage - 1) * $this->PorPagina, $this->PorPagina);
        } else {
            $this->Registros = $Registros;
        }
        return $this;
    }

    /**
     * Informa o número máximo de páginas visivel durante a navegação
     * @param int $VisiblePages Precisa ser um número impar
     * @return $this
     */
    public function setVisiblePages($VisiblePages)
    {
        $this->VisiblePages = max(3, $VisiblePages - ($VisiblePages % 2 == 1 ? 0 : 1));
        return $this;
    }

    /**
     * Retorna o LIMIT e OFFSET para buscas MySql
     * @return string ex: LIMIT 10 OFFSET 30
     */
    public function getLimitOffset()
    {
        return 'LIMIT ' . $this->PorPagina . ' OFFSET ' . (($this->CurrentPage - 1) * $this->PorPagina);
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->display();
    }

    /**
     * Retorna o HTML da paginação
     * @param string $Link
     * @param array $Attributes
     * @return string
     */
    function display($Link = null, array $Attributes = null)
    {
        if ($this->Count) {
            $html = '<nav ' . htmlAttributes($Attributes) . ' >';

            $totalPaginas = $this->getTotalPaginas();

            if ($totalPaginas > 1) {
                $html .= '<ul class="pagination clearfix" >';

                # Min e Max
                $min = (int)max(1, $this->CurrentPage - ($this->VisiblePages - 1) * 0.5);
                $max = (int)min($totalPaginas, $this->CurrentPage >= (($this->VisiblePages - 1) * 0.5 + 1) ? $this->CurrentPage + (($this->VisiblePages - 1) * 0.5) : $this->CurrentPage + 11 - $this->CurrentPage);
                if ($totalPaginas == $max) {
                    $min = max(1, $max - $this->VisiblePages + 1);
                }

                # Ir para a primeira página
                if ($min > 1) {
                    $html .= '<li class="page-item" ><a class="page-link" data-page="1" href="' . str_replace('#page#', 1, $Link ? $Link : '#') . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                }

                # Páginas
                for ($i = $min; $i <= $max; $i++) {
                    $html .= '<li class="page-item ' . ($this->CurrentPage == $i ? 'active' : null) . '" ><a class="page-link" data-page="' . $i . '" href="' . str_replace('#page#', $i, $Link ? $Link : '#') . '" >' . $i . '</a></li>';
                }

                # Ir para a última página
                if ($max < $totalPaginas) {
                    $html .= '<li class="page-item" ><a class="page-link" data-page="' . $totalPaginas . '" href="' . str_replace('#page#', $totalPaginas, $Link ? $Link : '#') . '" aria-label="Next" ><span aria-hidden="true">&raquo;</span></a></li>';
                }

                $html .= '</ul>';

                return $html;
            }
        }

        return '';
    }

}
    