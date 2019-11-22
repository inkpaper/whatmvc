<?php

namespace Core\Base;

/**
 * 视图基类
 * Class View
 * @package Core\Base
 */
class View
{
    protected $controller;
    protected $action;
    protected $params = [];

    /**
     * View constructor.
     * @param $controller
     * @param $action
     */
    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * 分配参数
     * @param $name
     * @param $val
     */
    public function assign($name, $val)
    {
        $this->params[$name] = $val;
    }

    /**
     * 渲染页面
     */
    public function render()
    {
        //为页面赋值
        extract($this->params);

        $defaultHeader = APP_PATH . 'App/View/Header.php';
        $defaulFooter = APP_PATH . 'App/View/Footer.php';

        $header = APP_PATH . 'App/View/' . $this->controller . '/Header.php';
        $footer = APP_PATH . 'App/View/' . $this->controller . '/Footer.php';
        $main = APP_PATH . 'App/View/' . $this->controller . '/' . $this->action . '.php';

        //引入页头页尾文件
        if (is_file($header)) {
            include $header;
        } else {
            include $defaultHeader;
        }

        $main = str_replace('/', DIRECTORY_SEPARATOR, $main);
        if (is_file($main)) {
            include $main;
        } else {
            echo '<h1>无法找到页面</h1>';
        }

        if (is_file($footer)) {
            include $footer;
        } else {
            include $defaulFooter;
        }
    }
}