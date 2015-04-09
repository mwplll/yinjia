<?php

/**
 * DapperPHP (php轻量级框架)
 *
 * 路由处理分发
 * @author zhaoshunyao <zhaoshunyao@baidu.com>
 * @since 2010-12-06
 */

class Dapper_Controller_Router
{
	/**
     * 环境根目录
     *
     * @var string
     */
	protected static $_baseDir = '';

	/**
     * 分发ui路径
     *
     * @var string
     */
	protected static $_uiDir = 'Ui/';

	/**
     * 默认的Action
     *
     * @var string
     */
	protected static $_defaultAction = 'index';

	/**
     * 默认的Controller
     *
     * @var string
     */
	protected static $_defaultController = 'index';

	/**
     * 默认的Action基类
     *
     * @var string
     */
	protected static $_baseAction = 'base';

	/**
     * 默认的Controller基类
     *
     * @var string
     */
	protected static $_baseController = 'base';

	/**
     * 路由规则表
     * router=>rule
     *
     * @var 数组
     */
	protected static $_arrRouterRules = array();

	/**
	 * router的分隔符
	 *
	 * @var string
	 */
	protected static $_strSepOfRouter = '/';

	/**
	 * 初始化配置信息
	 * @param array $arrConfig
	 */
	public static function init($arrConfig)
	{
		if(isset($arrConfig['baseDir']))
		{
			self::$_baseDir = $arrConfig['baseDir'];
		}
		if(isset($arrConfig['uiDir']))
		{
			self::$_uiDir = $arrConfig['uiDir'];
		}
		if(isset($arrConfig['defaultAction']))
		{
			self::$_defaultAction = $arrConfig['defaultAction'];
		}
		if(isset($arrConfig['defaultController']))
		{
			self::$_defaultController = $arrConfig['defaultController'];
		}
		if(isset($arrConfig['sepOfRouter']))
		{
			self::$_strSepOfRouter = $arrConfig['sepOfRouter'];
		}
		if(isset($arrConfig['baseAction']))
		{
			self::$_baseAction = $arrConfig['baseAction'];
		}
		if(isset($arrConfig['baseController']))
		{
			self::$_baseController = $arrConfig['baseController'];
		}
		if(isset($arrConfig['routerRules']) && is_array($arrConfig['routerRules']))
		{
			self::$_arrRouterRules = $arrConfig['routerRules'];
		}
	}

	/**
     * 路由分发
     */
    public static function dispatch()
    {
		$_strUrl = Dapper_Http_Request::getPathInfo();
		$_strUrl = self::_safeFilterPath($_strUrl);
		if($_strUrl == '/' || $_strUrl == '')
		{
			//默认分发
			Dapper_Http_Request::setParams($_GET);
			self::_dispatchAction(self::$_defaultAction);
		}
		else
		{
			$_router = self::_getDispatchRouter($_strUrl);
			if($_router)
			{
                //收集参数
				$_arrParams = array();
				$_arrParams += $_GET;
				$_arrParams += $_POST;
				Dapper_Http_Request::setParams($_arrParams);
				if(strpos($_router, '::'))
				{
					self::_dispatchController($_router);
				}
				else
				{
                    self::_dispatchAction($_router);
				}
			}
			else
			{
                //router rule is error
				self::_dispatchAction('header404');
			}
		}
    }

	/**
     * 分发action动作
     */
	private static function _dispatchAction($strDispatchRouter)
    {
        $_intPos = strrpos($strDispatchRouter, '/');
        $_strClassName = $strDispatchRouter;
        if($_intPos)
		{
        	$_strClassName = substr($strDispatchRouter, $_intPos + 1);
        }
        // 用于检测 indexAction 类是否实现
		$_strClassName .= 'Action';
        // 用于检测 indexAction.php 文件是否存在
		$_strClassPath = self::$_baseDir . self::$_uiDir . $strDispatchRouter . 'Action.php';
		if(is_file($_strClassPath) && is_readable($_strClassPath))
		{
            // 加载 baseAction.php 文件
			include(self::$_baseDir . self::$_uiDir . self::$_baseAction .'Action.php');
            // 加载继承了 baseAction 类的文件，如 indexAction.php
            include($_strClassPath);
            if(class_exists($_strClassName))
			{
                $_objAction = new $_strClassName();
                if(method_exists($_objAction, 'init'))
				{
                    $_objAction->init();
                }
                $_objAction->execute();
                return true;
            }
        }
        return false;
    }

	/**
     * 分发Controller动作
     */
	private static function _dispatchController($strDispatchRouter)
    {
		$_module = '';
		$_controller = '';
		$_action = '';
		$_intPos = strrpos($strDispatchRouter, '/');
        if($_intPos)
		{
			$_module = substr($strDispatchRouter, 0, $_intPos + 1);
			$_strExecutive = substr($strDispatchRouter, $_intPos + 1);
			$_arrExecutive = explode('::', $_strExecutive);
			$_controller = $_arrExecutive[0] . 'Controller';
			$_action = $_arrExecutive[1] . 'Action';
        }
		else
		{
			return false;
		}
		$_runFile = self::$_baseDir . self::$_uiDir . $_module . $_controller . '.php';
		if(is_file($_runFile) && is_readable($_runFile))
		{
			include(self::$_baseDir . self::$_uiDir . self::$_baseController .'Controller.php');
            include($_runFile);
            if(class_exists($_controller))
			{
                $_objController = new $_controller();
                if(method_exists($_objController, 'initAction'))
				{
                    $_objController->initAction();
                }
				if(method_exists($_objController, $_action))
				{
                    $_objController->$_action();
                }
                return true;
            }
        }
        return false;
    }

	/**
	 * 解析$strRouterKey,获取router
	 * @param string $strRouter
	 * @return false/string
	 *
	 */
	private static function _getDispatchRouter($strRouter)
	{
		$_strRouter = trim($strRouter, '/');
		if(empty($_strRouter) || empty(self::$_arrRouterRules))
		{
			return false;
		}
		//静态Router
		if(isset(self::$_arrRouterRules[$_strRouter]))
		{

            $_ruleValue = self::$_arrRouterRules[$_strRouter];
			$_intPos = strpos($_ruleValue, '?');
			if($_intPos !== false)
			{
				$_arrParse = explode('?', $_ruleValue);
				if(isset($_arrParse[1]))
				{
					$_ruleValue = trim($_arrParse[0], '/');
					$_ruleValue = trim($_arrParse[0]);
					parse_str($_arrParse[1], $_arrOutput);
					Dapper_Http_Request::setParams($_arrOutput);
				}
			}
			return $_ruleValue;
		}

		//动态Router
		$_arrRouterNodes = explode(self::$_strSepOfRouter, $_strRouter);
		$_intNodeSize = count($_arrRouterNodes);
		foreach(self::$_arrRouterRules as $_ruleKey => $_ruleValue)
		{
			$_arrRuleKey = explode(self::$_strSepOfRouter, $_ruleKey);
			if($_arrRouterNodes[0] != $_arrRuleKey[0])
			{
				continue;
			}
			$_intPos = strpos($_ruleKey, '(');
			if($_intPos === false)
			{
				continue;
			}
			$_intRuleKey = count($_arrRuleKey);
			if($_intRuleKey == $_intNodeSize)
			{
				$_matchRet = self::_isExactMatch($_arrRuleKey, $_arrRouterNodes);
				if($_matchRet)
				{
					if(is_array($_matchRet))
					{
						$_arrRuleValue = explode('?', $_ruleValue);
						if(isset($_arrRuleValue[1]))
						{
							self::_extractParams($_arrRuleValue[1], $_matchRet);
						}
						$_ruleValue = trim($_arrRuleValue[0], '/');
					}
					return $_ruleValue;
				}
			}
			else
			{
				$_matchRet = self::_isFuzzyMatch($_arrRuleKey, $_intRuleKey, $_arrRouterNodes);
				if($_matchRet)
				{
					if(is_array($_matchRet))
					{
						$_arrRuleValue = explode('?', $_ruleValue);
						if(isset($_arrRuleValue[1]))
						{
							self::_extractParams($_arrRuleValue[1], $_matchRet);
						}
						$_ruleValue = trim($_arrRuleValue[0], '/');
					}
					return $_ruleValue;
				}
			}
		}
		return false;
	}

	/**
	 * 精确匹配路由
	 * @param array $arrRuleKey 要匹配的rule
	 * @param array $arrNodes 待匹配的url
	 * @return boolean/array匹配到的参数
	 *
	 */
	private static function _isExactMatch($arrRuleKey, $arrNodes)
	{
		$_arrParams = array();
		foreach($arrRuleKey as $i=>$subRule)
		{
			if($subRule == $arrNodes[$i])
			{
				continue;
			}
			elseif($subRule == '(\d+)')
			{
				if(is_numeric($arrNodes[$i]))
				{
					$_arrParams[] = $arrNodes[$i];
				}
				else
				{
					return false;
				}
			}
			elseif($subRule == '(\w+)')
			{
				//检测是否是只包含[A-Za-z0-9]
				if(ctype_alnum($arrNodes[$i]))
				{
					$_arrParams[] = $arrNodes[$i];
				}
				else
				{
					return false;
				}
			}
			elseif($subRule == '(.*)')
			{
				if(is_string($arrNodes[$i]) || is_numeric($arrNodes[$i]))
				{
					$_arrParams[] = $arrNodes[$i];
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		if(isset($_arrParams[0]))
		{
			return $_arrParams;
		}

		return true;
	}

	/**
	 * 模糊匹配路由
	 * @param array $arrRuleKey 要匹配的rule
	 * @param int $intRuleKey 要匹配的rule的深度
	 * @param array $arrNodes 用户请求rule
	 * @return boolean/array匹配到的参数
	 *
	 */
	private static function _isFuzzyMatch($arrRuleKey, $intRuleKey, $arrNodes)
	{
		$_intLast = $intRuleKey - 1;
		$_intLast = $_intLast > 0 ? $_intLast : 0;
		if($arrRuleKey[$_intLast] != '(.*)')
		{
			return false;
		}
		$_arrParams = array();
		foreach($arrRuleKey as $i=>$subRule)
		{
			if($subRule == $arrNodes[$i])
			{
				unset($arrNodes[$i]);
				continue;
			}
			elseif($subRule == '(.*)')
			{
				$_arrParams[] = ($i == $_intLast) ? implode('/', $arrNodes) : $arrNodes[$i];
				unset($arrNodes[$i]);
			}
			else
			{
				return false;
			}
		}
		if(isset($_arrParams[0]))
		{
			return $_arrParams;
		}

		return true;
	}

	/**
	 * 提取rule中的参数
	 * @param string $strParams 参数项目表
	 * @param array $arrParamsValue 参数值表
	 *
	 */
	private static function _extractParams($strParams, $arrParamsValue)
	{
		if(empty($strParams) && empty($arrParamsValue))
		{
			return false;
		}
		else
		{
			$_arrParams = array();
			parse_str($strParams, $_arrParams);
			if(!empty($_arrParams))
			{
				foreach($_arrParams as $k=>$v)
				{
					$v = trim($v);
					if(!empty($v) && $v{0} == '$')
					{
						$i = substr($v, 1);
						$i = intval($i) - 1;
						$i = $i < 0 ? 0 : $i;
						$_arrParams[$k] = isset($arrParamsValue[$i]) ? $arrParamsValue[$i] : NULL;
					}
				}
				Dapper_Http_Request::setParams($_arrParams);
			}
			return true;
		}
	}

	/**
	 * url path 分发路径安全过滤
	 * @param string $strInput
	 * @return string $_strOutput
	 *
	 */
	private static function _safeFilterPath($strInput)
	{
		if(empty($strInput))
		{
			return '';
		}

		$_strInput = strtolower($strInput);
		$_strOutput = '';

		//白名单过滤
		$_arrSafeString = array(
			'a'=>1,'b'=>1,'c'=>1,'d'=>1,'e'=>1,'f'=>1,'g'=>1,'h'=>1,'i'=>1,'j'=>1,'k'=>1,'l'=>1,'m'=>1,
			'n'=>1,'o'=>1,'p'=>1,'q'=>1,'r'=>1,'s'=>1,'t'=>1,'u'=>1,'v'=>1,'w'=>1,'x'=>1,'y'=>1,'z'=>1,
			'0'=>1,'1'=>1,'2'=>1,'3'=>1,'4'=>1,'5'=>1,'6'=>1,'7'=>1,'8'=>1,'9'=>1,'/'=>1,'-'=>1,'_'=>1
			);

		$_intStrlen = strlen($_strInput);
		for($i = 0; $i < $_intStrlen; $i++)
		{
			if(isset($_arrSafeString[$_strInput{$i}]))
			{
				$_strOutput .= $_strInput{$i};
			}
		}
		return $_strOutput;
	}
}
