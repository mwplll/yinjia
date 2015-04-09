<?php
/**
 * lib对象生成工厂
 * @category	libs
 * @package		LibFactory
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 * @date		2011/10/09
 * 用于lib层统一创建对象
 */

class LibFactory
{
    /**
     * Array of libs instances
     * @var array
     */
    public static $_instances = array();

    /**
     * Get a libs instance
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
        if(strpos($_className, 'Lib') === false)
        {
            $_className = 'Lib' . $classKey;
        }

        if(!isset(self::$_instances[$_className]))
        {
            self::$_instances[$_className] = null;
            $libObj = empty($param) ? new $_className() : new $_className($param);
            self::$_instances[$_className] = $libObj;
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

    /**
     * 对象消除接口()
     *
     * @param string $classKey 类名关键字
     * @param string $param 类构造初始化参数
     */
    public static function mvInstance($className)
    {
        unset(self::$_instances[$className]);
    }
}
?>
