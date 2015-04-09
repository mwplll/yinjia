<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-15
 * Time: 下午7:31
 */
class adminUserInfoApiAction extends baseAction{
    public function execute(){
        $userObj = new LibUser();
        $userId = Dapper_Http_Request::getParam('id');

        if(!$userId){
            return $this->api_error(FAILED,'please provide user id');
        }
        else{
            $userInfo = $userObj->getUserById($userId);
            $userInfo['designer_sn'] = 'YJ'.str_pad(($userInfo['designer_sn']),5,"0",STR_PAD_LEFT);
        }



        //输出映射表
        $mapArr = array(
            'id' => 'user_id',
            'tel' => 'user_tel',
            'userName' => 'user_name',
            'realName' => 'real_name',
            'createTime' => 'create_time',
            'userSex' => 'user_sex',
            'avatar' => 'user_avatar',
            'birthday' => 'birthday',
            'isSpecial' => 'is_special',
            'state' => 'is_checked',
            'userShow' => 'user_show',
            'qq' => 'qq',
            'email' => 'email',
            'alipay' => 'alipay',
            'cid' => 'cid',
            'cidFrontPic' => 'cid_front_pic',
            'cidBackPic' => 'cid_back_pic',
            'reason' => 'fail_reason',
            'designerSn' => 'designer_sn'
        );
        if($userInfo){
            $userRes = $this->mapArray($mapArr,$userInfo);
        }
        else{
            $userRes = array();
        }

        if($userInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($userRes);

    }
}
