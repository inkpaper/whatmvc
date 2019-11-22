<?php

namespace Core\Base;

class View
{
    public function __construct($controller, $action)
    {

    }

    public function assign($name, $val)
    {

    }

    public function render($mode = 'html')
    {
        switch ($mode) {
            case 'xml':
                //渲染为xml
                break;
            case 'html':
            default:
                //渲染为html
                break;
        }
    }
}