<?php

namespace App\Controller;

use Core\Base\Controller;
use App\Model\User as UserModel;

class User extends Controller
{
    public function index()
    {
        $list = (new UserModel())->getUserList();

        $this->assign('title', 'ss');
        $this->assign('list', $list);
        $this->render();
    }
}