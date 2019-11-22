<?php

namespace App\Model;

use Core\Base\Model;

class User extends Model
{
    public $table = 'user';

    public function getUserList()
    {
        return $this->fetchAll();
    }
}