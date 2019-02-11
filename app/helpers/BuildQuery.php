<?php

namespace app\helpers;

use app\core\Model;

class BuildQuery
{

    private $inners = [];
    private $sqlCache = false;
    private $distinct = true;
    private $tables = [];
    private $where;
    private $having;
    private $fields;
    private $group;
    private $order;
    private $limit;
    private $table = [];

    /**
     * BuildQuery constructor.
     * @param string $table
     * @param string $alias
     */
    public function __construct(string $table, string $alias)
    {
        $this->setTable($table, $alias);
        $this->fields = ["{$alias}.*"];
    }

    /**
     * @param $table
     * @param $alias
     * @return $this
     */
    function setTable($table, $alias)
    {
        $this->tables = ["`{$table}` AS `{$alias}` "];
        return $this;
    }

    /**
     * @param $table
     * @param $alias
     * @return $this
     */
    function addTable($table, $alias)
    {
        $this->table[] = "`{$table}` AS `{$alias}`";
        return $this;
    }

    /**
     * @param string $having
     * @return $this
     */
    function setHaving(string $having)
    {
        if ($having) {
            $this->having = "HAVING {$having}";
        } else {
            $this->having = null;
        }
        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    function setSelectFields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param string $where
     * @return $this
     */
    function addInnerJoin(string $table, string $alias, string $where)
    {
        $this->inners[] = "INNER JOIN `{$table}` AS `{$alias}` ON {$where} ";
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param string $where
     * @return $this
     */
    function addLeftJoin(string $table, string $alias, string $where)
    {
        $this->inners[] = "LEFT JOIN `{$table}` AS `{$alias}` ON {$where} ";
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param string $where
     * @return $this
     */
    function addRightJoin(string $table, string $alias, string $where)
    {
        $this->inners[] = "RIGHT JOIN `{$table}` AS `{$alias}` ON {$where} ";
        return $this;
    }

    /**
     * @param string $where
     * @return $this
     */
    function setWhere(string $where)
    {
        if ($where) {
            $this->where = "WHERE {$where}";
        } else {
            $this->where = null;
        }
        return $this;
    }

    /**
     * @param array $order
     * @return $this
     */
    function setOrder(array $order = null)
    {
        if ($order) {
            $this->order .= "ORDER BY " . implode(', ', $order);
        } else {
            $this->order = null;
        }
        return $this;
    }

    /**
     * @param string $group
     * @return $this
     */
    function setGroup(array $group = null)
    {
        if ($group) {
            $this->group .= "GROUP BY " . implode(', ', $group);
        } else {
            $this->group = null;
        }
        return $this;
    }

    /**
     * @param int|string $limit
     * @return $this
     */
    function setLimit($limit)
    {
        if ($limit) {
            $this->limit .= "LIMIT {$limit}";
        } else {
            $this->limit = null;
        }
        return $this;
    }

    /**
     *
     * @param array $places
     * @return array
     */
    function execute(array $places = null)
    {
        return Model::pdoRead()->FullRead($this->getQuery(), $places)->getResult();
    }

    /**
     * @return string
     */
    function getQuery()
    {
        $query = 'SELECT ';

        if ($this->sqlCache) {
            $query .= 'SQL_CACHE ';
        }

        if ($this->distinct) {
            $query .= 'DISTINCT ';
        }

        $query .= implode(',', $this->fields) . " "
            . "\nFROM " . implode(', ', $this->tables);

        foreach ($this->inners as $inner) {
            $query .= "\n{$inner}";
        }

        $query .= "\n{$this->where}"
            . "\n{$this->group}"
            . "\n{$this->having}"
            . "\n{$this->order}"
            . "\n{$this->limit}";

        return $query;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->getQuery();
    }

}
    