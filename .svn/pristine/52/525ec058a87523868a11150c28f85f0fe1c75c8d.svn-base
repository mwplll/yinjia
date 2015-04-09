<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-15
 * Time: 下午8:35
 */
class userEditApiAction extends baseAction{
    public function execute(){
        if(!$this->checkLogin()){
            return $this->api_error(FAILED,'not login：未登陆，需要先登陆！');
        }

        $part = Dapper_Http_Request::getParam('part','base');

        switch($part){
            case "base":
                $this->base();
                break;
            case "pwd":
                $this->pwd();
                break;
            case "tel":
                $this->tel();
                break;
            case "email":
                $this->email();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'part' param!");
                break;
        }
    }

    /**
     * 修改基本信息
     * @return bool
     */
    public function base(){

        $this->checkLogin();
        $userId = $this->loginUid;

        $data = array();
        $data['user_avatar'] = Dapper_Http_Request::getParam('avatar','');
        $data['user_sex'] = Dapper_Http_Request::getParam('userSex',2);
        $data['user_show'] = Dapper_Http_Request::getParam('userShow','');
        $data['birthday'] = Dapper_Http_Request::getParam('birthday','');

        if(!$data){
            return $this->api_error(PARAM_ERROR,'please provide user avatar,userSex,userShow,birthday!');
        }

        $userObj = new LibUser();

        $res = $userObj->updateUser($userId,$data);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }

    /**
     * 修改密码
     * @return bool
     */
    public function pwd(){
        $this->checkLogin();
        $userId = $this->loginUid;

        $oldPwd = Dapper_Http_Request::getParam('oldPwd',NULL);
        $newPwd = Dapper_Http_Request::getParam('newPwd',NULL);

        if(!$oldPwd | !$newPwd){
            return $this->api_error(PARAM_ERROR,'Please provide oldPwd and newPwd!');
        }

        $userInfo = $this->loginInfo();
        $userObj = new LibUser();
        $res = FALSE;
        if($oldPwd){
            if($userInfo['user_passwd'] != MD5($oldPwd)){
                return $this->api_error(FAILED,'原密码错误！');

            }
            else{
                $data['user_passwd'] = MD5($newPwd);
                $res = $userObj->updateUser($userId,$data);
            }
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }


    /**
     * 修改手机号
     * @return bool
     */
    public function tel(){
        $this->checkLogin();
        $userId = $this->loginUid;

        $tel = Dapper_Http_Request::getParam('tel',NULL);
        $code = Dapper_Http_Request::getParam('code',NULL);

        if(!$tel | !$code){
            return $this->api_error(PARAM_ERROR,'Please provide tel and code!');
        }

        $userObj = new LibUser();
        $res = FALSE;
        session_start();
        $captcha = isset($_SESSION['reg_captcha']) ? $_SESSION['reg_captcha'] : "";
        if($code){
            if($captcha != $code){
                return $this->api_error(PARAM_ERROR,'code error输入的验证码不正确，请确认后重新输入！');
            }
            else{
                $data['user_tel'] = $tel;
                $res = $userObj->updateUser($userId,$data);
            }
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 修改邮箱
     * @return bool
     */
    public function email(){
        $this->checkLogin();
        $userId = $this->loginUid;

        $email = Dapper_Http_Request::getParam('email',NULL);

        if(!$email){
            return $this->api_error(PARAM_ERROR,'Please provide email!');
        }

        $userObj = new LibUser();
        $data['email'] = $email;
        $res = $userObj->updateUser($userId,$data);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }






}