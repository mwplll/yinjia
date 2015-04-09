<?php
/**
 * dal对象生成工厂
 * @category	dal
 * @package		Factory
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 * @date		2011/10/09
 * 用于dal层统一创建对象
 */

class DBFactory
{
    /**
     * Array of dal instances
     * @var array
     */
    public static $_instances = array();

    /**
     * Get a dal instance
     *
     * @param string $classKey 类名关键字
     * @param string $param 类构造初始化参数
     */
    public static function getInstance($classKey, $param = null)
    {
        if(empty($classKey))
        {
            return null;
        }

        $_className = $classKey;
        if(strpos($_className, 'DB') === false)
        {
            $_className = 'DB' . $classKey;
        }

        if(!isset(self::$_instances[$_className]))
        {
            self::$_instances[$_className] = null;
            $DBObj = empty($param) ? new $_className() : new $_className($param);
            self::$_instances[$_className] = $DBObj;
            return self::$_instances[$_className];
        }
        else
        {
            return self::$_instances[$_className];
        }
    }

    /**
     * 对象注入接口(qa专用)
     *
     * @param string $classKey 类名关键字
     * @param string $param 类构造初始化参数
     */
    public static function setInstance($className, $obj)
    {
        self::$_instances[$className] = $obj;
    }
}
?>