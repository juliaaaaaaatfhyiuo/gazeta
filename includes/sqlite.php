<?php

class DB
{
    private $db;
    public $error;

    public function __construct($dbfile = ':memory:')
    {
        if (!file_exists($dbfile) && $dbfile != ':memory:') {
            echo 'File ' . $dbfile . ' not exists';
            exit;
        }

        $this->db = new SQLite3($dbfile);

        function lower($str) {
            $str = str_replace(array('ё', 'Ё'), 'е', $str);
            return mb_strtolower($str);
        }
        $this->db->createFunction('lower', 'lower');
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function getDB()
    {
        return $this->db;
    }

    public function escape($string)
    {
        return SQLite3::escapeString($string);
    }

    public function exec(string $query): bool
    {
        $result = $this->db->exec($query);

        return $result;
    }

    public function query(string $query)
    {
        $result = $this->db->query($query);
        if (is_bool($result)) return $result;

        $array = array();
        while ($row = $result->fetchArray()) {
            $array[] = $row;
        }

        return $array;
    }

    public function error()
    {
        return $this->db->lastErrorMsg();
    }

    public function insertID()
    {
        return $this->db->lastInsertRowID();
    }

    /**
     * @param string $table Name of table
     * @param array $data Array of rows and values
     * @return bool Result of query
     */
    public function insert(string $table, array $data) : bool
    {
        $columns = '';
        $values = '';
        $first = true;

        foreach ($data as $column => $value) {
            if (!$first) {
                $columns .= ', ';
                $values  .= ', ';
            }

            if (!is_numeric($value)) {
                $value = $this->escape($value);
                $value = '\'' . $value . '\'';
            }

            $columns .= '`' . $column . '`';
            $values .= $value;

            $first = false;
        }

        $table = '`' . $table . '`';

        $query = "INSERT INTO $table ($columns) VALUES ($values);";
        $result = $this->exec($query);
        return $result;
    }

    /**
     * @param string $table Name of table
     * @param array $data Array of rows and values
     * @param string $where Condition
     * @return bool Result of query
     */
    public function update(string $table, array $data, string $where = '1') : bool
    {
        $update = '';
        $first = true;

        foreach ($data as $column => $value) {
            if (!$first) {
                $update .= ', ';
            }

            if (!is_numeric($value)) {
                $value = $this->escape($value);
                $value = '\'' . $value . '\'';
            }

            $update .= '`' . $column . '` = ' . $value;

            $first = false;
        }

        $table = '`' . $table . '`';

        $query = "UPDATE $table SET $update WHERE $where;";
        $result = $this->exec($query);
        return $result;
    }

    /**
     * @param string $table Name of table
     * @param string $where Condition
     * @return bool Result of Query
     */
    public function delete(string $table, $where = '1')
    {
        $table = '`' . $table . '`';

        $query = "DELETE FROM $table WHERE $where;";
        $result = $this->exec($query);
        return $result;
    }

    /**
     * @param string|array $table Name of table
     * @param string|array $fields Fields
     * @param string $where Condition
     * @param string|array $order Order by
     * @param int $limit LIMIT
     * @param int $offset limit offset
     * @return array|bool Result of query
     */
    public function select($table, $fields = '*', string $where = '1', $order = array(), int $limit = -1, int $offset = 0)
    {
        if (is_array($fields)) {
            $_fields = '';

            for ($i = 0; $i < count($fields); $i++) {
                if ($i > 0) $_fields .= ', ';
                $_fields .= '`' . $fields[$i] . '`';
            }
            $fields = $_fields;
        }

        $_order = '';
        if (!is_array($order)) $order = array($order);
        $countOrder = count($order);
        if ($countOrder > 0) {
            if ($countOrder == 1) {
                $_order .= '`' . $order[0] . '`';
            } else {
                $_order .= '`' . $order[0] . '` ' . $order[1];
            }
            $order = 'ORDER BY ' . $_order;
        } else {
            $order = '';
        }

        if ($limit >= 0) {
            $limit = 'LIMIT ' . $offset . ', ' . $limit;
        } else {
            $limit = '';
        }

        if (!is_array($table)) $table = array($table);
        $tables = '';
        $countTables = count($table);
        for($i = 0; $i < $countTables; $i++) {
            if ($i > 0) $tables .= ', ';
            $tables .= '`' . $table[$i] . '`';;
        }

        $query = "SELECT $fields FROM $tables WHERE $where $order $limit;";

        $result = $this->query($query);
        return $result;
    }

    /**
     * @param string|array $table Name of table
     * @param string|array $fields Fields
     * @param string $where Condition
     * @param string|array $order Order by
     * @param int $offset limit offset
     * @return array|bool Result of query
     */
    public function selectOne($table, $fields = '*', string $where = '1', $order = array(), int $offset = 0)
    {
        $result = $this->select($table, $fields, $where, $order, 1, $offset);
        if ($result === false) return false;
        return $result[0];
    }

}