<?php
/**
 * DapperPHP (php轻量级框架)
 * 请求处理类
 * @author zhaoshunyao <zhaoshunyao@baidu.com>
 * @since 2010-12-06
 */

class Dapper_Http_Request
{
	/**
     * url 参数表
     * key=>value
     *
     * @var 数组
     */
	protected static $_arrParams = array();
	
	/**
     * 是否转义过滤
     */
	protected static $_boolSafeAddslashes = false;
	
	/**
	 * 添加参数表
	 * @param array $arrInput
	 * @param boolean $overWrite
	 * @return false/true
	 * 
	 */
	public static function setParams($arrInput, $overWrite = false)
	{
		$arrInput = (array) $arrInput;
		if(self::$_boolSafeAddslashes)
		{
			$arrInput = self::safeAddslashes($arrInput);
		}
		if($overWrite)
		{
			self::$_arrParams = $arrInput + self::$_arrParams;
		}
		else
		{
			self::$_arrParams += $arrInput;
		}

		return true;
	}

	/**
	 * 取得指定参数值
	 * @param string $key
	 * @return string $value
	 * 
	 */	
	public static function getParam($key, $value = '')
	{
		if(isset(self::$_arrParams[$key]))
		{
			return self::$_arrParams[$key];
		}
		else
		{
			return $value;
		}
	}
	
	/**
	 * 取得全部参数
	 * @return array $_arrParams
	 * key=>value
	 * 
	 */	
	public static function getAllParams()
	{
		return 	self::$_arrParams;
	}
	
	/**
	 * 判断是不是AJAX请求
	 * @return bool
	 * 
	 */
    public static function isAjax()
	{
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']))
		{
            if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
                return true;
        }
        return false;
    }

	/**
	 * addslashes
	 * @param string $strInput
	 * @param bool $force
	 * @return string/array
	 * 
	 */
	public static function safeAddslashes($strInput , $force = false)
	{
		if(!get_magic_quotes_gpc() || $force)
		{
			if(is_array($strInput))
			{
				foreach($strInput as $_key => $_val)
				{
					$strInput[$_key] = self::safeAddslashes($_val, $force);
				}
			}
			else
			{
				$strInput = addslashes($strInput);
			}
		}
		return $strInput;
	}

	/**
	 * 取得path_info
	 * @return string
	 * 
	 */
	public static function getPathInfo()
	{
		$_strUrl = isset($_SERVER['PATH_INFO']) ? strip_tags($_SERVER['PATH_INFO']) : '/';
		$_intTmpPos = strpos($_strUrl, '.');
		if($_intTmpPos)
		{
			$_strUrl = substr($_strUrl, 0, $_intTmpPos);
		}
		$_intTmpPos = strpos($_strUrl, '?');
		if ($_intTmpPos)
		{
			$_strUrl = substr($_strUrl, 0, $_intTmpPos);
		}
		$_intTmpPos = strrpos($_strUrl, 'index');
		if($_intTmpPos)
		{
			$_strUrl = substr($_strUrl, 0, $_intTmpPos - 1);
		}
		
		return $_strUrl;
	}
}
?>