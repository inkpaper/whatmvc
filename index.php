<?php

require dirname(__FILE__) . '/System/App.php';
require dirname(__FILE__) . '/Config/Config.php';
require 'Loader.php';

spl_autoload_register('Loader::__autoload');