<?php

namespace App\Controller;

use Core\Base\Controller;

class Index extends Controller
{
    public function Index()
    {
        $arr = [0,1,1,1,0];
        rsort($arr);
        $this->assign('res', rsort($arr));
        $this->render();
    }
}