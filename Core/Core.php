<?php

namespace Core;

//框架核心类路径
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

/**
 * 框架核心类
 * Class Core
 * @package Core
 */
class Core
{
    protected $config;

    /**
     * 初始化配置
     * Core constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 运行程序
     */
    public function run()
    {

    }

    /**
     * 路由处理
     */
    public function route()
    {

    }

    /**
     * 检测开发环境
     */
    public function checkDebug()
    {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
        }
    }

    /**
     * 删除敏感字符
     * @param $value
     * @return array|string
     */
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    /**
     * 检测敏感字符并删除
     */
    public function removeMagicQuotes()
    {
        if(get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    /**
     * 检测自定义全局变量并移除。因为 register_globals 已经弃用，如果
     * 已经弃用的 register_globals 指令被设置为 on，那么局部变量也将
     * 在脚本的全局作用域中可用。 例如， $_POST['foo'] 也将以 $foo 的形式存在
     */
    public function unregisterGlobals()
    {

    }

    /**
     * 自动加载类
     * @param $className
     */
    public function loadClass($className)
    {

    }

    /**
     * 内核文件命名空间映射
     */
    protected function classMap()
    {

    }

}