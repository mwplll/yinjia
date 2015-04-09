<?php
/**
 * DapperPHP (php轻量级框架)
 *
 * 数据库类
 * @package		DB
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 * @since		2011-06-10
 */
class Dapper_Model_DB
{
    /**
     * Array of DB instances
     * @var array
     */
    public static $instances = array();

    /**
     * Get a DB instance for the specified database.
     *
     * @param array $config
     * array('hosts' => array(ip1, ip2, ...)
     *		'port' => xx,
     *		'database' => '',
     *		'username' => '',
     * 		'password' => '',
     *		'timeout' => xx,
     *		'adapter' => '',
     *		)
     */
    public static function getInstance($dbName)
    {
        $confObj = LibFactory::getInstance('LibConfig');
        $dbConf = $confObj->getConfig('db');
        $config = $dbConf[$dbName][RUNTIME];
        $_database = $config['database'];
        if(empty($_database))
        {
            return false;
        }

        if(!isset(self::$instances[$_database]))
        {
            self::$instances[$_database] = null;
            $className = 'Dapper_Model_Db_' . ucfirst($config['adapter']);
            $db = new $className($config);
            if($db->isOK())
            {
                self::$instances[$_database] = $db;
            }
            unset($config);
        }
        return self::$instances[$_database];
    }
}