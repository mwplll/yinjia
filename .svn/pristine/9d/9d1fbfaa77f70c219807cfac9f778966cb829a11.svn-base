<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-15
 * Time: 下午7:54
 */
class userVerifyApiAction extends baseAction{
    public function execute(){

        $this->checkLogin();
        $userId = $this->loginUid;
        if(!$this->checkLogin()){
            return $this->api_error(FAILED,'not login：未登陆，需要先登陆！');
        }

        $userObj = new LibUser();

        $data = array();
        $data['real_name'] = Dapper_Http_Request::getParam('realName','');
        $data['qq'] = Dapper_Http_Request::getParam('qq','');
        $data['alipay'] = Dapper_Http_Request::getParam('alipay','');
        $data['cid'] = Dapper_Http_Request::getParam('cid','');
        $data['cid_front_pic'] = Dapper_Http_Request::getParam('cidFrontPic','');
        $data['cid_back_pic'] = Dapper_Http_Request::getParam('cidBackPic','');
        $data['is_checked'] = 2;  //2代表审核中
        $data['is_special'] = 1;  //1代表设计师

        if(!$data['real_name'] | !$data['qq'] | !$data['alipay'] | !$data['cid'] | !$data['cid_front_pic'] | !$data['cid_back_pic']){
            return $this->api_error(PARAM_ERROR,'Please provide realName,qq,alipay,cid,cidFrontPic,cidBackPic');
        }

        $res = $userObj->toBeDesigner($userId,$data);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }
}