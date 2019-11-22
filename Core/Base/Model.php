<?php

namespace Core\Base;

use Core\Db\Sql;

class Model extends Sql
{
    public $model;

    public function __construct()
    {
        if (!$this->table) {
            //获取当前Model
            $this->model = get_class($this);
            //数据库表名与类名一致
            $this->table = $this->model;
        }
    }
}