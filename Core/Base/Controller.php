<?php

namespace Core\Base;

/**
 * 控制器基类
 * Class Controller
 * @package Core\Base
 */
class Controller
{
    public $controller;
    public $action;
    public $view;

    /**
     * Controller constructor.
     * @param $controller
     * @param $action
     */
    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->view = new View($controller, $action);
    }

    /**
     * 分配变量
     * @param $name
     * @param $val
     */
    public function assign($name, $val)
    {
        $this->view->assign($name, $val);
    }

    /**
     * 视图渲染
     * @param string $mode
     */
    public function render($mode = 'html')
    {
        $this->view->render($mode);
    }
}