<?php 
/**
 * Controller基类
 */

abstract class baseController
{
	protected $loginInfo = array();
	protected $loginUid = 0;
	protected $lookUid = 0;
	protected $module = 'ui';
	
    public function initAction()
    {
    	//初始化全局信息
		//可做统一登录状态等
		//... ...
    	return true;
    }
	
	public function loginAction()
    {
		//
    }
}