<?php

namespace Core\Db;

use PDOStatement;

class Sql
{
    protected $table;
    private $filter = '';//拼接条件
    private $params = [];//绑定查询参数

    /**
     * 查询条件拼接
     * 示例： $this->where(['id = :id', 'name = :name'], [':id' => $id, ':name' => $name])->fetch();
     * @param $where
     * @param $params
     * @return $this
     */
    public function where($where, $params)
    {
        if ($where) {
            $this->filter .= ' WHERE ';
            $this->filter .= implode(',', $where);

            $this->params = $params;
        }
        return $this;
    }

    /**
     * 排序条件拼接
     * 示例：$this->order(['id DESC', 'username ASC', ...])->fetch();
     * @param $order
     * @return $this
     */
    public function order($order)
    {
        if ($order) {
            $this->filter .= ' ORDER BY ';
            $this->filter .= implode(',', $order);
        }
        return $this;
    }

    /**
     * 查询一条数据
     * @return mixed
     */
    public function fetch()
    {
        $sql = sprintf("SELECT * FROM `%s` %s", $this->table, $this->filter);

        //创建PDOStatement句柄
        $sth = Db::createPdo()->prepare($sql);
        //绑定参数
        $this->formatParam($sth, $this->params);
        $sth->execute();

        return $sth->fetch();
    }

    /**
     * 查询所有符合条件的数据
     * @return array
     */
    public function fetchAll()
    {
        $sql = sprintf("SELECT * FROM `%s` %s", $this->table, $this->filter);

        $sth = Db::createPdo()->prepare($sql);
        $this->formatParam($sth, $this->params);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * 插入数据
     * @param $data
     * @return int
     */
    public function add($data)
    {
        $sql = sprintf("INSERT INTO `%s` %s", $this->table, $this->formatInsert($data));

        $sth = Db::createPdo()->prepare($sql);
        $this->formatParam($sth, $data);
//        $this->formatParam($sth, $this->params);
        $sth->execute();

        //返回被影响行数
        return $sth->rowCount();
    }

    /**
     * 更新数据
     * @param $data
     * @return int
     */
    public function update($data)
    {
        $sql = sprintf("UPDATE `%s` SET %s %s", $this->table, $this->formatUpdate($data), $this->filter);

        $sth = Db::createPdo()->prepare($sql);
        $this->formatParam($sth, $data);
        $this->formatParam($sth, $this->params);
        $sth->execute();

        return $sth->rowCount();
    }

    /**
     * 删除数据
     * @return int
     */
    public function delete()
    {
        $sql = sprintf("DELETE FROM `%s` %s", $this->table, $this->filter);

        $sth = Db::createPdo()->prepare($sql);
        $this->formatParam($sth, $this->params);
        $sth->execute();

        return $sth->rowCount();
    }

    /**
     * 绑定变量
     * @param PDOStatement $sth
     * @param $params
     * @return PDOStatement
     */
    private function formatParam(PDOStatement $sth, $params)
    {
        //params示例：[':id' => $id](查询时使用)或者['id' => $id](添加，更新使用)
        foreach ($params as $name => $val) {
            $name = is_int($name) ? $name + 1 : ':' . ltrim($name, ':');
            //绑定变量
            $sth->bindParam($name, $val);
        }
        return $sth;
    }

    /**
     * 拼接插入语句
     * @param $data
     * @return string
     */
    private function formatInsert($data)
    {
        $fields = [];
        $values = [];

        //data示例：['id' => 1]
        foreach ($data as $k => $v) {
            $fields[] = sprintf("`%s`", $k);
            $values[] = sprintf(":%s", $k);
        }

        $field = implode(',', $fields);
        $value = implode(',', $values);

        return sprintf("(%s) values (%s)", $field, $value);
    }

    /**
     * 拼接更新语句
     * @param $data
     * @return string
     */
    private function formatUpdate($data)
    {
        $fields = [];
        foreach ($data as $k => $v) {
            $fields[] = sprintf("`%s` = :%s", $k, $v);
        }
        return implode(',', $fields);
    }
}