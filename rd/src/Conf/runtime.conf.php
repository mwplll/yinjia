<?php
/**
 * 运行环境配置文件
 */

define('RUNTIME', 'test');		//环境标识，方便环境切换
define('DEBUG', true);			//DEBUG 模式

// 动态改变PHP 配置，用于复写 php.ini 文件
if(RUNTIME == 'test') {
    ini_set('display_errors', 1);
//    error_reporting(E_ALL);
}