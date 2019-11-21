<?php

//定义应用目录为当前目录
define('APP_PATH', __DIR__ . '/');

//开启调试
define('APP_DEBUG', true);

//加载框架和配置文件
require APP_PATH . 'Core/Core.php';
$config = require APP_PATH . 'Config/Config.php';

//自动加载类
require 'Loader.php';
spl_autoload_register('Loader::__autoload');