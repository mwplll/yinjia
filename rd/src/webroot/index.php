<?php
/**
 * web入口
 *
 */
$startTime = microtime(TRUE);

//设置环境常量
define('ROOT_PATH', substr(dirname(__FILE__), 0, -7));
define('DB_PATH', ROOT_PATH.'Dal/');
define('LIB_PATH', ROOT_PATH.'Lib/');
define('LOG_PATH', ROOT_PATH.'log/');


//加载常量定义
require(ROOT_PATH . 'Conf/runtime.conf.php');
require(ROOT_PATH . 'Conf/const.conf.php');
require(ROOT_PATH . 'Conf/global.conf.php');
require(ROOT_PATH . 'Conf/router.conf.php');
require(ROOT_PATH . 'Conf/log.conf.php');
// 全站错误信息
require(ROOT_PATH . 'Conf/errmsg.conf.php');
require(ROOT_PATH . 'Conf/db.conf.php');

//加载Dapper框架
require(ROOT_PATH . 'Dapper/Dapper.class.php');
//路由分发
Dapper_Controller_Router::init($config['routerConfig']);
//全局配置初始化
$confObj = LibFactory::getInstance('LibConfig');
$confObj->setConfig($config);

//框架初始化
//Dapper::loadConfig(array('global','router','db','log'), ROOT_PATH.'Conf/');
//Dapper::loadConfig(array('global','router'), ROOT_PATH.'Conf/');

//开启日志
Dapper_Log::init($config['logConfig'][RUNTIME]);

//var_dump(Dapper::$config['routerConfig']);

Dapper_Controller_Router::dispatch();

//记录日志
//Dapper_Log::notice("request ok", 'ui');

//$endTime = microtime(TRUE);
//$runtime = number_format($endTime - $startTime, 6);
//echo "<hr />runtime: $runtime";
//echo "test!";

?>
