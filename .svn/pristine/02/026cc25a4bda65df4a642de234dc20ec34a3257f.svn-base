<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-25
 * Time: 下午10:43
 */
class userCheckTelApiAction extends baseAction
{
    public function execute()
    {
        $tel = Dapper_Http_Request::getParam('tel','');
        $code = Dapper_Http_Request::getParam('code','');

        if($tel && $code){
            $userObj = new LibUser();
            $userInfo = $userObj->getUserByTel($tel);
            if(!$userInfo){
                $this->api_error(PARAM_ERROR,"手机号不存在！");
            }

            if(!$this->_is_mobile($tel)){
                $this->api_error(PARAM_ERROR,"手机号格式不正确！");
            }

            session_start();

            $captcha = isset($_SESSION['reg_captcha']) ? $_SESSION['reg_captcha'] : "";
            $sessionTel = isset($_SESSION['user_tel']) ? $_SESSION['user_tel'] : "";
            //echo '$captcha = '.$captcha."\n";
            //echo '$sessionTel = '.$sessionTel."\n";
            if(($captcha != $code) || ($tel != $sessionTel)){
                return $this->api_error(FAILED,'code error输入的验证码不正确，请确认后重新输入！');
            }
            else{
                return $this->api_success(TRUE);
            }
        }
        else{
            return $this->api_error(PARAM_ERROR,"please provide tel and code!");
        }

    }

    private function _is_mobile($mobilePhone) {
        if (preg_match("/^1[34578][0-9]{9}$/", $mobilePhone)) {
            return true;
        } else {
            return false;
        }
    }
}