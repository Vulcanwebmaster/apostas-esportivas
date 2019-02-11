<?php

namespace app\core\crud;

use PDO;
use PDOException;
use PDOStatement;

class Update extends Conn
{

    private $Tabela;
    private $Dados;
    private $Termos;
    private $Places;
    private $Result;
    private $Syntax;

    /** @var PDOStatement */
    private $Update;

    /** @var PDO */
    private $Conn;

    /**
     *
     * @param string $tabela
     * @param array $dados
     * @param int $id
     * @return $this
     */
    public function byId($tabela, array $dados, $id)
    {
        $this->ExeUpdate($tabela, $dados, 'WHERE `id` = :id LIMIT 1', ['id' => $id]);
        return $this;
    }

    /**
     * <b>Exe Update:</b> Executa uma atualização simplificada com Prepared Statments. Basta informar o
     * nome da tabela, os dados a serem atualizados em um Attay Atribuitivo, as condições e uma
     * analize em cadeia (ParseString) para executar.
     * @param string $Tabela = Nome da tabela
     * @param array $Dados = [ NomeDaColuna ] => Valor ( Atribuição )
     * @param string $Termos = WHERE coluna = :link AND.. OR..
     * @param string $ParseString = link={$link}&link2={$link2}
     * @return $this
     */
    public function ExeUpdate($Tabela, array $Dados, $Termos = null, array $Places = null)
    {
        $this->Tabela = (string)$Tabela;
        $this->Dados = (array)self::format_values($Tabela, $Dados);
        $this->Termos = $Termos;
        $this->Places = $Places;
        $this->getSyntax();
        $this->Execute();
        return $this;
    }

    /**
     * Cria a sintaxe da query para Prepared Statements
     */
    private function getSyntax()
    {
        foreach ($this->Dados as $Key => $Value) {
            $Places[] = "`{$Key}` = :{$Key}";
        }
        $Places = implode(', ', $Places);
        $this->Syntax = "UPDATE `{$this->Tabela}` AS a SET {$Places} {$this->Termos}";
    }

    /**
     * Obtém a Conexão e a Syntax, executa a query!
     */
    private function Execute()
    {
        $this->Connect();
        try {
            $this->Update->execute(array_merge((array)$this->Dados, (array)$this->Places));
            $this->Result = true;
        } catch (PDOException $e) {
            $this->Result = null;
            error_log("Error: Update");
            error_log($this->Update->queryString);
            error_log("{$e->getCode()}: {$e->getMessage()}");
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Obtém o PDO e Prepara a query
     */
    private function Connect()
    {
        $this->Conn = parent::getConn();
        $this->Update = $this->Conn->prepare($this->Syntax);
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */

    /**
     * <b>Obter resultado:</b> Retorna TRUE se não ocorrer erros, ou FALSE. Mesmo não alterando os dados se uma query
     * for executada com sucesso o retorno será TRUE. Para verificar alterações execute o getRowCount();
     * @return BOOL $Var = True ou False
     */
    public function getResult()
    {
        return $this->Result;
    }

    /**
     * <b>Contar Registros: </b> Retorna o número de linhas alteradas no banco!
     * @return INT $Var = Quantidade de linhas alteradas
     */
    public function getRowCount()
    {
        return $this->Update->rowCount();
    }

    /**
     * <b>Modificar Links:</b> Método pode ser usado para atualizar com Stored Procedures. Modificando apenas os valores
     * da condição. Use este método para editar múltiplas linhas!
     * @param STRING $ParseString = id={$id}&..
     * @return $this
     */
    public function setPlaces($Places)
    {
        $this->Places = self::format_values($Places);
        $this->getSyntax();
        $this->Execute();
        return $this;
    }

}
    