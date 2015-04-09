<?php
/**
 * Class loginUserApiAction
 * 用户登录API
 */
class userLoginApiAction extends baseAction{
    public function execute(){
        $nickname = Dapper_Http_Request::getParam('user');
        $passwd = Dapper_Http_Request::getParam('pwd');


        $userObj = new LibUser();

        if(!$nickname || !$passwd){
            return $this->api_error(PARAM_ERROR,'请提供用户名和密码！');
        }

        if($userObj->login($nickname, $passwd)){
            return $this->api_success(TRUE);
        }else{
            return $this->api_error(FAILED,'用户名或密码错误!');
        }

    }
}
