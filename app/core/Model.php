<?php

namespace app\core;

use app\core\crud\Create;
use app\core\crud\Delete;
use app\core\crud\Read;
use app\core\crud\Update;
use app\helpers\BuildQuery;
use app\helpers\Pagination;
use Exception;

abstract class Model
{

    /** @var array */
    protected $cache = [];

    /** @var string */
    protected $query;

    /** @var string Nome da tabela */
    protected $table;

    /** @var string */
    protected $valueObject;

    /**
     * Cria um objeto ValueObject para a Model Atual
     * @param array $Values
     * @return ValueObject
     * @throws Exception
     */
    static function newValueObject(array $Values = null)
    {
        $model = self::Instance();
        /* @var $vo ValueObject */
        if ($class = $model->valueObject) {
            return new $class($model, $Values);
        } else {
            throw new Exception('Não foi informado a ValueObject.');
        }
    }

    /**
     * Retorna uma instancia única da Model
     * @return $this
     */
    public static function instance()
    {
        static $instanes = [];
        $class = get_called_class();
        if (!isset($instanes[$class])) {
            $instanes[$class] = new $class;
        }
        return $instanes[$class];
    }

    /**
     *
     * @param string $termos
     * @param array $places
     * @param int $page
     * @param int $forPage
     * @return Pagination
     */
    static function listaPagination(string $termos = null, array $places = null, $page = 1, $forPage = 20)
    {
        $p = new Pagination;

        $p->Termos = $termos;
        $p->Places = $places;

        if (!$page and $forPage) {

            $registros = self::lista("{$termos} LIMIT {$forPage}", $places, false);

            $p->setCount(count($registros));
            $p->setPorPagina($forPage);
            $p->setCurrentPage(1);
            $p->setRegistros($registros, false);

        } else if (!$page and !$forPage) {

            $registros = self::lista($termos, $places);

            $p->setCount(count($registros));
            $p->setPorPagina(count($registros));
            $p->setCurrentPage(1);
            $p->setCurrentPage(1);
            $p->setRegistros($registros);

        } else {

            $total = self::lista($termos, $places, true);

            $p->setCount($total);
            $p->setPorPagina($forPage);
            $p->setCurrentPage($page);
            $p->setRegistros($total ? self::lista("{$termos} {$p->getLimitOffset()}", $places) : [], false);

        }

        return $p;
    }

    /**
     * Lista
     * @param string $termos
     * @param array $places
     * @param boolean $Count
     * @return ValueObject[]|int
     */
    static function lista(string $termos = null, array $places = null, $Count = false)
    {

        # Montando a pesquisa
        if (strpos($termos, 'SELECT ') !== false) {
            $query = str_replace('#table#', self::getTable(), $termos);
        } else {
            $query = str_replace('#table#', self::getTable(), self::getQuery() . " {$termos}");
        }

        # Listando registro
        if (!$Count) {
            $result = self::select($query, $places);

            return self::toValueObject($result);

        } # Contagem dos registros
        else {
            $query = preg_replace('/SELECT.*?FROM/is', 'SELECT COUNT(*) AS `total` FROM', $query);
            $result = self::select($query, $places);
            return count($result) ? $result[0]['total'] : 0;
        }
    }

    /**
     * Table
     * @return string
     */
    public static function getTable()
    {
        return self::instance()->table;
    }

    /**
     * Query
     * @return string
     */
    public static function getQuery()
    {
        $model = self::instance();
        $Query = str_replace('#table#', $model->getTable(), !empty($model->query) ? $model->query : 'SELECT a.* FROM `#table#` AS a');
        if (!preg_match('/SELECT /', $Query)) {
            return preg_replace('/SELECT /', 'SELECT ', $Query);
        }
        return $Query;
    }

    /**
     * Mysql Select
     * @param string $Query
     * @param array $Places
     * @return array
     */
    protected static function select($Query, array $Places = null)
    {
        return self::pdoRead()->FullRead($Query, $Places)->getResult();
    }

    /**
     * PDO::Read
     * @return Read
     */
    public static function pdoRead()
    {
        static $instance;
        if (!$instance)
            $instance = new Read();
        return $instance;
    }

    /**
     *
     * @param array $registros
     * @param string $ValueObjectName
     * @return array|ValueObject
     */
    public static function toValueObject(array $registros)
    {
        $class = self::instance()->valueObject;

        foreach ($registros as $key => $v) {

            /* @var $vo ValueObject */
            $vo = new $class(self::instance(), $v);

            self::addCache('id', $vo->getId(), $vo);

            if (method_exists($vo, 'getToken')) {
                self::addCache('token', $vo->getToken(), $vo);
            }

            $registros[$key] = $vo;
        }

        return $registros;
    }

    /**
     * @param string $label
     * @param mixed $value
     * @param ValueObject $object
     */
    private static function addCache($label, $value, ValueObject $object)
    {
        self::instance()->cache[sha1("{$label}:{$value}")] = $object;
    }

    /**
     * @return BuildQuery
     */
    public static function getBuildQuery()
    {
        $model = self::instance();
        return $model->query instanceof BuildQuery ? $model->query : new BuildQuery($model->table, 'a');
    }

    /**
     * Salva os dados na base de dados
     * @param ValueObject $vo
     */
    public static function save(ValueObject $vo)
    {

        // Verificando dados
        if ($vo->getStatus() != 99 and method_exists($vo, 'check')) {
            $vo->check();
        }

        /// Atualizando registro
        if ($vo->getId()) {

            $termos = 'WHERE `id` = :id LIMIT 1';
            $values = $vo->toArray(false, true);
            $places = ['id' => $vo->getId()];

            if (!$values) {
                return true;
            }

            if (!self::update($vo->getTable(), $values, $termos, $places)) {
                throw new Exception("Não foi possíve atualizar as informações do registro #{$vo->getVoReference()}");
            }

            return true;
        } // Criando registro
        else {

            $values = $vo->toArray(false, false);

            if (!$values) {
                throw new Exception("Nenhum valor foi alterado");
            }

            $values['id'] = null;

            $id = self::insert($vo->getTable(), $values);

            if ($id > 0) {
                $vo->setId($id);
            } else {
                throw new Exception("Não foi possível gravar o registro em `{$vo->getTable()}`");
            }

            return $id;
        }
    }

    /**
     * Mysql Update
     * @param string $Tabela
     * @param array $Dados
     * @param string $Termos
     * @param array $Places
     * @return boolean
     */
    protected static function update($Tabela, array $Dados, $Termos = null, array $Places = null)
    {
        return self::pdoUpdate()->ExeUpdate($Tabela, $Dados, $Termos, $Places)->getResult();
    }

    /**
     * PDO::Update
     * @return Update
     */
    public static function pdoUpdate()
    {
        static $instance;
        if (!$instance)
            $instance = new Update();
        return $instance;
    }

    /**
     * Mysql Insert
     * @param string $Tabela
     * @param array $Dados
     * @return int|false
     */
    protected static function insert($Tabela, array $Dados)
    {
        return self::pdoCreate()->ExeCreate($Tabela, $Dados)->getResult();
    }

    /**
     * PDO::Create
     * @return Create
     */
    public static function pdoCreate()
    {
        static $instance;
        if (!$instance)
            $instance = new Create();
        return $instance;
    }

    /**
     * Atualiza status para 99: Excluído
     * @param int|ValueObject $id
     * @throws Exception
     */
    public function Status99($id)
    {
        if ($v = $this->getByLabel('id', $id)) {
            $this->update($this->table, ['status' => 99], "WHERE a.id = :id LIMIT 1", ['id' => is_array($v) ? $v['id'] : $v->getId()]);
        } else {
            throw new Exception('Registro inválido.');
        }
    }

    /**
     * Retorna registro pela label
     * @param string $label
     * @param string|int $value
     * @param boolean $ReturnFirst
     * @return ValueObject
     */
    static function getByLabel($label, $value = null)
    {

        # Registro inválido
        if ($value == null or $label == 'id' and !$value) {
            return null;
        }

        # Verificando o cache
        if ($o = self::getCache($label, $value)) {
            return $o;
        }

        # Buscando
        $result = self::lista("WHERE a.{$label} = :value ORDER BY a.status ASC LIMIT 1", ['value' => $value], false, true, true);

        # Resultados
        if ($result) {
            self::addCache($label, $value, $result[0]);
            return $result[0];
        } else {
            return null;
        }
    }

    /**
     * Retorna o registro do cache
     * @param string $label
     * @param mixed $value
     * @return ValueObject
     */
    private static function getCache($label, $value)
    {
        $model = self::instance();
        $key = sha1("{$label}:{$value}");
        return isset($model->cache[$key]) ? $model->cache[$key] : null;
    }

    /**
     * Excluí registro da tabela
     * @param int|ValueObject $VO_or_ID
     * @return boolean
     */
    public function excluir($VO_or_ID = null)
    {
        try {

            $Value = $VO_or_ID;

            # Value Object
            if (is_a($Value, ValueObject::class)) {
                if ($Value->getTable() != $this->table) {
                    throw new Exception('Inválido: ' . $Value->getTable() . ' != ' . $this->table);
                } else if (!$Value->getId()) {
                    throw new Exception('Registro não se encontra na base de dados.');
                }
                $id = $Value->getId();
            } # Int ou String
            else if (is_int($Value) or is_string($Value)) {
                $id = $Value;
            } # Tipo inválido
            else {
                throw new Exception('Precisa ser passado um ValueObject ou um Int para excluir um registro.');
            }

            # Excluíndo
            $this->delete($this->table, 'WHERE `id` = :id LIMIT 1', ['id' => $id]);

            # Excluí todas as imagens da ValueObject
            if (is_object($Value)) {
                $Value->imgDeleteAll();
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Mysql Delete
     * @param string $Tabela
     * @param string $Termos
     * @param array $Places
     * @return boolean
     */
    protected static function delete($Tabela, $Termos = null, array $Places = null)
    {
        return self::pdoDelete()->ExeDelete($Tabela, $Termos, $Places)->getResult();
    }

    /**
     * PDO::Delete
     * @return Delete
     */
    public static function pdoDelete()
    {
        static $instance;
        if (!$instance)
            $instance = new Delete();
        return $instance;
    }

}
    