<?php

namespace Core\Db;

use PDO;
use PDOException;

/**
 * Database基类
 * Class Db
 * @package Core\Db
 */
class Db
{
    private static $pdo = null;

    /**
     * 创建pdo句柄
     * @return PDO|null
     */
    public static function createPdo()
    {
        //如果有实例化句柄，则直接返回
        if (self::$pdo !== null)
            return self::$pdo;

        try {
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf-8", DB_HOST, DB_NAME);
            $option = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

            return self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $option);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}