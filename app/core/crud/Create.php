<?php

namespace app\core\crud;

use Exception;
use PDO;
use PDOException;

class Create extends Conn
{

    /** @var string */
    private $table;

    /** @var array */
    private $dados;

    /** @var int */
    private $result;

    /**
     * <b>ExeCreate:</b> Executa um cadastro simplificado no banco de dados utilizando prepared statements.
     * Basta informar o nome da tabela e um array atribuitivo com nome da coluna e valor!
     *
     * @param string $table = Informe o nome da tabela no banco!
     * @param array $dados = Informe um array atribuitivo. ( Nome Da Coluna => Valor ).
     * @return $this
     */
    public function ExeCreate($table, array $dados)
    {
        $this->table = (string)Conn::getTableName($table);
        $this->dados = self::format_values($table, $dados);

        if (empty($this->dados)) {
            throw new Exception("A array de dados está vazia. Tentativa de salvar dados na tabela `{$table}` não foi concluída.");
        }

        $this->getSyntax();
        $this->execute();
        return $this;
    }

    /**
     * @return string
     */
    private function getSyntax()
    {
        $Fileds = '`' . implode('`, `', array_keys($this->dados)) . '`';
        $Places = ':' . implode(', :', array_keys($this->dados));
        return "INSERT INTO {$this->table} ({$Fileds}) VALUES ({$Places})";
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function execute()
    {
        $this->connect();

        try {
            $prepare = $this->connect()->prepare($this->getSyntax());
            $prepare->execute($this->dados);
            $this->result = $this->connect()->lastInsertId();
        } catch (PDOException $e) {
            $this->result = null;
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return PDO
     */
    private function connect()
    {
        static $conn;
        if (!$conn) {
            $conn = parent::getConn();
        }
        return $conn;
    }

    //Obtém a Conexão e a Syntax, executa a query!

    /**
     * <b>Obter resultado:</b> Retorna o ID do registro inserido ou FALSE caso nem um registro seja inserido!
     * @return INT $Variavel = lastInsertId OR FALSE
     */
    public function getResult()
    {
        return $this->result;
    }

}
    