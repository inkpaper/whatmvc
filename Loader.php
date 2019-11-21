<?php
/**
 * 自动加载文件类
 */
class Loader
{
    private static $classMap = [
        'WeChat' => __DIR__ . DIRECTORY_SEPARATOR . 'Wehat',
        'Design' => __DIR__ . DIRECTORY_SEPARATOR . 'Design'
    ];

    public static function __autoload($class)
    {
        $file = self::findFile($class);
        if (file_exists($file))
            self::requireFile($file);
    }

    private static function findFile($class)
    {
        //获取文件夹
        $first_namespace = substr($class, 0, strpos($class, '\\'));
        $class_folder = self::$classMap[$first_namespace];

        //拼接文件名
        $file_path = substr($class, strlen($first_namespace)) . '.php';
        $file_name = strtr($first_namespace . $file_path, '\\', DIRECTORY_SEPARATOR);
        return $file_name;
    }

    /**
     * 包含文件
     * @param $file
     */
    private static function requireFile($file)
    {
        if (is_file($file))
            require_once $file;
    }
}