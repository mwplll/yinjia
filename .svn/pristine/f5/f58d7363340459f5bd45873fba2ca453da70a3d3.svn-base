<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-9
 * Time: 下午9:00
 */
class checkDesignerApiAction extends baseAction{
    public function execute(){
        //判断是否登录
        if(!$this->checkLogin()){
           return $this->api_error(USER_UNLOGIN, 'not login');
        }

        $userId = $this->loginUid;
        //echo '$userID = '.$userId."\n";

        $designerObj = new LibDesigner();
        $res = $designerObj->checkDesigner($userId);

        if(!$res){
            return $this->api_error(FAILED,"您还未通过设计师实名认证，请先进行实名认证！");
        }
        else{
            return $this->api_success($res);
        }
    }
}