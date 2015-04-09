<?php
/**
 * Class loginUserApiAction
 * 用户登录API
 */
class userInfoApiAction extends baseAction{
    public function execute(){
        /*if(!$this->checkLogin()){
            return $this->api_error(FAILED,'not login：未登陆，需要先登陆！');
        }*/

        $userInfo = $this->loginInfo();
        $userInfo['designer_sn'] = 'YJ'.str_pad(($userInfo['designer_sn']),5,"0",STR_PAD_LEFT);

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
        if($this->loginInfo()){
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
