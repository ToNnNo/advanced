<?php


namespace App\Utils\Builder;


class QueryBuilder
{

    private $sql;
    private $pdo = null;

    private $fields = "*";
    private $table;
    private $where = [];
    private $order = [];

    private $params = [];

    public function __construct($table = null)
    {
        $this->table = $table;

        $this->pdo = new \PDO('mysql:dbname=fullstack;host=localhost:8889', 'root', 'root');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
    }

    public function fields($fields)
    {
        if (is_string($fields)) {
            $this->fields = $fields;
        } else if (is_array($fields)) {
            $this->fields = implode(", ", $fields);
        }

        return $this;
    }

    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    public function where($where)
    {
        $this->where[] = $where;

        return $this;
    }

    public function andWhere($where)
    {
        $this->where[] = " AND " . $where;

        return $this;
    }

    public function orWhere($where)
    {
        $this->where[] = " OR " . $where;

        return $this;
    }

    public function setParameter($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function getQuery($display = false)
    {
        $this->sql = "SELECT " . $this->fields . " FROM " . $this->table;

        if (!empty($this->where)) {
            $this->sql .= " WHERE ".implode("", $this->where);
        }

        if ($display) {
            echo $this->sql;
        }

        return $this;
    }

    public function getResult()
    {
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($this->params);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getOneResult()
    {
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($this->params);

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

}