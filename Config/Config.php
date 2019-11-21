<?php

//数据库配置
$config['sysytem']['db'] = [
    'db_host' => '127.0.0.1',
    'db_username' => 'root',
    'db_password' => 'root',
    'db_name' => 'whatmvc',
    'db_prefix' => '',
    'db_charset' => 'utf8'
];

//自定义类库配置
$config['sysytem']['lib'] = [];

//缓存配置
$config['syaytem']['cache'] = [
    'cache_dir' => 'cache',//缓存路径，相对于根目录
    'cache_prefix' => 'cache_',
    'cache_time' => 1800,
    'cache_mode' => 2,//mode 1 为serialize ，model 2为保存为可执行文件
];

//路由配置
$config['system']['route'] = [
    'default_controller' => 'home',
    'default_action' => 'index',
    'url_type' => 1,//定义URL的形式 1 为普通模式    index.php?c=controller&a=action&id=2  2 为PATHINFO   index.php/controller/action/id/2
];