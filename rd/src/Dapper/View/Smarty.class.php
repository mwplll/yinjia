<?php
/**
 * DapperPHP (php轻量级框架)
 * smarty接口
 * @author zhaoshunyao (zhaoshunyao@baidu.com)
 * @since 2011-06-10
 */

//加载smarty（独立配置，方便fe独立开发测试）
require_once(ROOT_PATH . 'Smarty/libs/Smarty.class.php');
require_once(ROOT_PATH . 'Smarty/smarty.conf.php');

//smarty初始化
Dapper_View_Smarty::setOptions($config['smartyConfig']);
//Dapper_View_Smarty::loadConfig('global.conf');

class Dapper_View_Smarty
{
    public static $view = null;
	
    public static function getView()
    {
        if(empty(self::$view))
		{
            self::$view = new Smarty();
        }
        return self::$view;
    }
    public static function setOptions($arrConfig)
    {
        $objSmarty = self::getView();

		if(isset($arrConfig['force_compile'])) $objSmarty->force_compile = $arrConfig['force_compile'];
		if(isset($arrConfig['compile_check'])) $objSmarty->compile_check = $arrConfig['compile_check'];
		if(isset($arrConfig['template_dir'])) $objSmarty->template_dir = $arrConfig['template_dir'];
		if(isset($arrConfig['compile_dir'])) $objSmarty->compile_dir = $arrConfig['compile_dir'];
        if(isset($arrConfig['config_dir'])) $objSmarty->config_dir = $arrConfig['config_dir'];
        if(isset($arrConfig['plugins_dir'])) $objSmarty->plugins_dir = $arrConfig['plugins_dir'];
        if(isset($arrConfig['left_delimiter'])) $objSmarty->left_delimiter = $arrConfig['left_delimiter'];
        if(isset($arrConfig['right_delimiter'])) $objSmarty->right_delimiter = $arrConfig['right_delimiter'];
		if(isset($arrConfig['caching'])) $objSmarty->caching = $arrConfig['caching'];
		if(isset($arrConfig['cache_dir'])) $objSmarty->cache_dir = $arrConfig['cache_dir'];
		if(isset($arrConfig['cache_lifetime'])) $objSmarty->cache_lifetime = $arrConfig['cache_lifetime'];
		if(isset($arrConfig['debugging'])) $objSmarty->debugging = $arrConfig['debugging'];
		
    }
    public static function assign($key, $value)
    {
        self::getView()->assign($key, $value);
    }
    public static function display($template)
    {
        self::getView()->display($template);
    }
    public static function loadConfig($file)
    {
        self::getView()->configLoad($file);
    }
    public static function append($tpl_var, $value = null, $merge = false)
    {
        self::getView()->append($tpl_var, $value, $merge);
    }
	public static function setCaching()
    {
		self::getView()->setCaching(Smarty::CACHING_LIFETIME_SAVED);
    }
	public static function isCached($template)
    {
		return self::getView()->isCached($template);
    }
}
//class end