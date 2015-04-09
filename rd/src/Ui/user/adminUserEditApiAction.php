<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-15
 * Time: 下午7:34
 */
class adminUserEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        //echo '$act = '.$act."\n";

        switch($act){
            case "check":
                $this->check();
                break;
            case "del":
                $this->del();
                break;
            case "add":
                $this->add();
                break;
            case "update":
                $this->update();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 删除用户
     * @return bool
     */
    public function del(){
        $userObj = new LibUser();
        $userId = Dapper_Http_Request::getParam('id');

        $data['user_del'] = 1;

        if(!$userId){
            return $this->api_error(FAILED,'please provide user id');
        }
        else{
            $res = $userObj->updateUser($userId,$data);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }

    /**
     * 审核实名认证
     * @return bool
     */
    public function check(){
        $userObj = new LibUser();
        $userId = Dapper_Http_Request::getParam('id');

        $data = array();
        $data['is_checked'] = intval(Dapper_Http_Request::getParam('isChecked',0));
        if(1 == $data['is_checked']){  //1表示审核通过
            $data['is_special'] = 1;  //1代表设计师用户
        }
        else{
            $data['is_special'] = 1;  //1代表设计师用户
            $data['fail_reason'] = Dapper_Http_Request::getParam('failReason','不符合印家设计师注册要求，请仔细阅读印家设计师注册须知！');
        }

        if(!$userId){
            return $this->api_error(FAILED,'please provide user id');
        }
        else{
            $res = $userObj->updateUser($userId,$data);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }

    /**
     * 添加管理员用户
     * @return bool
     */
    public function add(){
        $userName = Dapper_Http_Request::getParam('user','');
        $passwd = Dapper_Http_Request::getParam('pwd');
        $isSpecial = Dapper_Http_Request::getParam('isSpecial');

        if(!$userName | !$passwd | !$isSpecial){
            return $this->api_error(PARAM_ERROR,"Please provide user,pwd,isSpecial!");
        }

        // 验证用户名
        $msg = $this->_validateName($userName);
        if ($msg !== true){
            return $this->api_error(PARAM_ERROR,$msg);
        }

        //验证密码
        $msg = $this->_validatePwd($passwd);
        if ($msg !== true){
            return $this->api_error(PARAM_ERROR,$msg);
        }

        $userObj = new LibUser();

        $data = array();
        $data['user_name'] = $userName;
        $data['user_passwd'] = $passwd;
        $data['is_special'] = intval($isSpecial);
        $data['create_time'] = time();

        $res = $userObj->addSuperUser($data);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    public function update(){
        $userId = Dapper_Http_Request::getParam('id','');
        $userName = Dapper_Http_Request::getParam('user');
        $passwd = Dapper_Http_Request::getParam('pwd');
        $isSpecial = Dapper_Http_Request::getParam('isSpecial');

        if(!$userId){
            return $this->api_error(PARAM_ERROR,"Please provide user id!");
        }

        $data = array();  //待更新的数据
        if($userName){
            $msg = $this->_validateName($userName);
            if ($msg !== true){
                return $this->api_error(PARAM_ERROR,$msg);
            }

            $data['user_name'] = $userName;
        }

        if($passwd){
            $msg = $this->_validatePwd($passwd);
            if ($msg !== true){
                return $this->api_error(PARAM_ERROR,$msg);
            }
            $data['user_passwd'] = MD5($passwd);
        }

        if($isSpecial){
            $data['is_special'] = intval($isSpecial);
        }

        $userObj = new LibUser();
        $res = $userObj->updateUser($userId,$data);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    private function _validateName($str){
        $nameLen = strlen($str);
        if( $nameLen < 6 || $nameLen > 24 ){
            return "用户名的长度必须要在6~24个字符之间";
        }
        return true;
    }

    private function _validatePwd($str){
        $nameLen = strlen($str);
        if( $nameLen < 6 || $nameLen > 24 ){
            return "密码不能少于6个字符";
        }
        return true;
    }
}