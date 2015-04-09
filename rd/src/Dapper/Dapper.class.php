<?php
/**
 * DapperPHP (php轻量级框架)
 * 框架入口类
 * @package		Dapper
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 * @since		2011-06-10
 */

class Dapper
{
	/**
	 * 配置变量
	 */
	public static $config = array();

	/**
	 * 加载配置变量
	 *
	 * @param array $configList 配置文件列表
	 * @param string $confDir 配置文件目录
	 * @return boolean
	 */
	public static function loadConfig($configList = array('global'), $confDir = '')
	{
		if(!is_array($configList))
		{
			return false;
		}
		foreach($configList as $configName)
		{
			if(empty($configName))
			{
				continue;
			}
			$configFile = $confDir . $configName . '.conf.php';
			if(is_file($configFile))
			{
				include($configFile);
				if(is_array($config))
				{
					self::$config += $config;
					unset($config);
				}
			}
		}
		return true;
	}

	/**
	 * 取得指定配置
	 *
	 * @param string $key
	 * @param string $default
	 * @return
	 */
	public static function getConfig($key, $default = NULL)
	{
		if(isset(self::$config[$key]))
		{
			return self::$config[$key];
		}
		else
		{
			return $default;
		}
	}

	/**
	 * 取得全部配置
	 *
	 * @param array $config
	 * @return false/true
	 */
	public static function getAllConfig()
	{
		return self::$config;
	}

	/**
	 * 加载类文件
	 *
     * @param string $className
     * @param string $baseDir
     * @return boolean
	 */
	public static function loadClass($className, $baseDir = '')
	{
		if($className == '') return false;
		if($className{0} == 'D' && $className{1} == 'a' && $className{2} == 'p' && $className{3} == 'p' && $className{4} == 'e' && $className{5} == 'r')
		{
			$className = str_replace('_', '/', $className);
			include(ROOT_PATH . $className . '.class.php');
		}
//		elseif($className{0} == 'D' && $className{1} == 'a' && $className{2} == 'l')
//		{
//			$className = str_replace('_', '/', $className);
//			include(ROOT_PATH . $className . '.class.php');
//		}
//		elseif($className{0} == 'L' && $className{1} == 'i' && $className{2} == 'b')
//		{
//			$className = str_replace('_', '/', $className);
//			include(ROOT_PATH . $className . '.class.php');
//		}
        elseif($className{0} == 'L' && $className{1} == 'i' && $className{2} == 'b')
        {
            include(LIB_PATH . $className . '.class.php');
        }
        elseif($className{0} == 'D' && $className{1} == 'B')
        {
            include(DB_PATH . $className . '.class.php');
        }
		elseif($className{0} == 'S' && $className{1} == 'm' && $className{2} == 'a' && $className{3} == 'r' && $className{4} == 't' && $className{5} == 'y')
		{
		    return true;
		}
		else
		{
			//include($className . '.class.php');
			trigger_error('load class "'.$className .'" fail!', E_USER_WARNING);
		}
		return true;
	}

	/**
     * Register autoload
     *
     * @param string $func
     */
    public static function registerAutoload($func = 'Dapper::loadClass')
    {
        spl_autoload_register($func);
    }
}

Dapper::registerAutoload();
//DapperPHP init end
