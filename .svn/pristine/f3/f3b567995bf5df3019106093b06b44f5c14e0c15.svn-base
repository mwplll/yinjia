<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-30
 * Time: 下午7:14
 */
class administratorLoginApiAction extends baseAction{
    public function execute(){
        $nickname = Dapper_Http_Request::getParam('user');
        $passwd = Dapper_Http_Request::getParam('pwd');


        $userObj = new LibUser();

        if(!$nickname || !$passwd){
            return $this->api_error(PARAM_ERROR,'请提供管理员用户名和密码！');
        }

        if($userObj->adminLogin($nickname, $passwd)){
            return $this->api_success(TRUE);
        }else{
            return $this->api_error(FAILED,'用户名或密码错误!');
        }

    }
}