<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-25
 * Time: 下午10:50
 */
class userPwdRstApiAction extends baseAction
{
    public function execute()
    {
        $tel = Dapper_Http_Request::getParam('tel','');
        $code = Dapper_Http_Request::getParam('code','');
        $pwd = Dapper_Http_Request::getParam('pwd','');

        if($tel && $code && $pwd){

            $userObj = new LibUser();
            $userInfo = $userObj->getUserByTel($tel);
            if(!$userInfo){
                $this->api_error(PARAM_ERROR,"手机号不存在！");
            }
            else{
                $userId = $userInfo['user_id'];
                //echo '$userId = '.$userId."\n";
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
                $data['user_passwd'] = MD5($pwd);
                //echo '$pwd = '.$pwd."\n";
                //print_r($data);
                //echo 'MD5 = '.MD5('1234567')."\n";
                $res = $userObj->updateUser($userId,$data);

                if($res === FALSE)
                    return $this->api_error(FAILED);
                else
                    return $this->api_success($res);
            }
        }
        else{
            return $this->api_error(PARAM_ERROR,"please provide tel、tel and code!");
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