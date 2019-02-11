<?php

namespace app\core\crud;

use PDO;
use PDOException;
use PDOStatement;

class Delete extends Conn
{

    private $Tabela;
    private $Termos;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Delete;

    /** @var PDO */
    private $Conn;

    /**
     *
     * @param string $Tabela
     * @param string $Termos
     * @param array $Places
     * @return $this
     */
    public function ExeDelete($Tabela, $Termos = null, array $Places = null)
    {
        $this->Tabela = (string)$Tabela;
        $this->Termos = (string)$Termos;
        $this->Places = $Places;
        $this->getSyntax();
        $this->Execute();
        return $this;
    }

    private function getSyntax()
    {
        $this->Delete = "DELETE FROM `{$this->Tabela}` {$this->Termos}";
    }

    private function Execute()
    {
        $this->Connect();
        try {
            $this->Delete->execute($this->Places);
            $this->Result = true;
        } catch (PDOException $e) {
            $this->Result = null;
            trigger_error("<b>Erro ao Deletar:</b> {$e->getMessage()}", $e->getCode());
        }
    }


    private function Connect()
    {
        $this->Conn = parent::getConn();
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    public function getResult()
    {
        return $this->Result;
    }

    //Cria a sintaxe da query para Prepared Statements

    public function getRowCount()
    {
        return $this->Delete->rowCount();
    }

    //Obtém a Conexão e a Syntax, executa a query!

    /**
     *
     * @param array $Places
     * @return $this
     */
    public function setPlaces($Places)
    {
        $this->Places = (array)$Places;
        $this->getSyntax();
        $this->Execute();
        return $this;
    }

}
    