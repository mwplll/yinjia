<?php
/**
 * 全局配置变量操作类
 *
 * @category	libs
 * @package		LibConfig
 * @author		zhangguoxian <zhangguoxian@baidu.com>
 */
class LibConfig
{
    /**
     * 全局配置
     */
    private $_config = array();

    /**
     * 配置文件容器
     */
    private $_configFile = array();

    /**
     * 添加配置变量
     *
     * @param array $config
     * @return false/true
     */
    public function setConfig($config = array())
    {
        if(!is_array($config))
        {
            return false;
        }

        foreach($config as $key => $val)
        {
            $this->_config[$key] = $val;
        }
        return true;
    }

    /**
     * 装载配置文件,并添加变量
     *
     * @param string $configFileName
     * @return false/true
     */
    public function loadConfigFile($configFileName)
    {
        $configFileName = trim($configFileName);
        if(empty($configFileName))
        {
            return false;
        }

        if(!isset($this->_configFile[$configFileName]))
        {
            require_once(ROOT_PATH . 'conf/'. $configFileName . '.conf.php');
            if(!empty($config))
            {
                foreach($config as $key => $val)
                {
                    $this->_config[$key] = $val;
                }
            }
        }
        else
        {
            //已装载过,避免重复加载
        }
        return true;
    }

    /**
     * 取得配置变量
     *
     * @param string $configName
     * @return array
     */
    public function getConfig($configName)
    {
        if(isset($this->_config[$configName]))
        {
            return $this->_config[$configName];
        }
        else
        {
            return false;
        }
    }
}
?>