<?php

namespace Core\Base;

use Core\Db\Sql;

/**
 * 模型基类
 * Class Model
 * @package Core\Base
 */
class Model extends Sql
{
    public $model;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        if (!$this->table) {
            //获取当前Model
            $this->model = get_class($this);
            //数据库表名与类名一致
            $this->table = strtolower($this->model);
        }
    }
}