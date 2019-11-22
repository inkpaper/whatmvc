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
        spl_autoload_register(array($this, 'loadClass'));
        $this->checkDebug();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->setDbConfig();
        $this->route();
    }

    /**
     * 路由处理
     */
    public function route()
    {
        $controllerName = $this->config['default']['controller'];
        $actionName = $this->config['default']['controller'];
        $params = [];

        //获取url
        $url = $_SERVER['REQUEST_URI'];

        //清除?之后的url参数
        $paramPosition = strpos($url, '?');
        $url = $paramPosition ? substr($url, 0, $paramPosition) : $url;

        //删除前后的/
        //url示例为/<Controller>/<Action>/<Param1>/<Param2>
        $url = trim($url, '/');

        if ($url) {
            //url分割为数组存储
            $urlArr = explode('/', $url);
            $urlArr = array_filter($urlArr);

            //获取控制器名
            $controllerName = ucfirst($urlArr[0]);

            //获取方法名
            array_shift($urlArr);
            $actionName = $urlArr[0] ? $urlArr[0] : $actionName;

            //获取url参数
            array_shift($urlArr);
            $params = $urlArr ? $urlArr : [];
        }

        $className = 'App\\Controller\\' . $controllerName;
        //检测控制器是否存在
        if (!class_exists($className)) exit($className . '不存在');
        //检测方法是否存在
        if(!method_exists($className, $actionName)) exit($actionName . '不存在');

        //实例化控制器
        $controller = new $className($className, $actionName);

        //调用控制器方法
        call_user_func_array(array($controller, $actionName), $params);

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
        if (get_magic_quotes_gpc()) {
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
        if (ini_get('register_globals')) {
            $arr = ['_SESSION', '_POST', '_GET', '_REQUEST', '_COOKIE', '_SERVER', '_ENV', '_FILES'];
            foreach ($arr as $value) {
                foreach ($GLOBALS[$value] as $k => $v) {
                    if ($GLOBALS[$k] === $v) {
                        unset($GLOBALS[$k]);
                    }
                }
            }
        }
    }

    /**
     * 设置数据库配置信息
     */
    public function setDbConfig()
    {
        if($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['name']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }

    /**
     * 自动加载类
     * @param $className
     */
    public function loadClass($className)
    {
        $classMap = $this->classMap();

        if (isset($classMap[$className])) {
            //加载内核类文件
            $file = $classMap[$className];
        } elseif (strpos($className, '\\') !== false) {
            //加载App类文件
            $file = APP_PATH . str_replace('/', '\\', $className) . '.php';
        } else {
            //没有找到文件
            return;
        }

        //如果是文件，就加载
        if (is_file($file)) {
            include $file;
        } else {
            return;
        }
    }

    /**
     * 内核文件命名空间映射
     */
    protected function classMap()
    {
        return [
            'Core\Base\Controller' => CORE_PATH . '/Base/Controller.php',
            'Core\Base\Model' => CORE_PATH . '/Base/Model.php',
            'Core\Base\View' => CORE_PATH . '/Base/View.php',
            'Core\Db\Db' => CORE_PATH . '/Db/Db.php',
            'Core\Db\Sql' => CORE_PATH . '/Db/Sql.php',
        ];
    }

}