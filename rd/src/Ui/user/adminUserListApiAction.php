<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-15
 * Time: 下午7:01
 */
class adminUserListApiAction extends baseAction{
    public function execute(){
        $userObj = new LibUser();
        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        //查询条件
        $wh = array();
        $wh['is_special'] = intval(Dapper_Http_Request::getParam('isSpecial',0));
        $states = Dapper_Http_Request::getParam('states',NULL);
        if(!isset($states)){
            $states = array(0,1,2,3);
        }
        $userDel = '(';
        foreach($states as $k=>$v){
            $userDel = $userDel.$v.',';
        }
        $userDel = substr($userDel,0,-1);
        $userDel = $userDel.')';
        $wh['is_checked'] = $userDel;

        $userList = $userObj->getUserList($start,$num,$wh);
        $totalCount = (int)$userObj->getUserCount($wh);
        $totalPage = ceil($totalCount / $num);

        if($userList){
            foreach($userList as &$user){
                $user['designer_sn'] = 'YJ'.str_pad(($user['designer_sn']),5,"0",STR_PAD_LEFT);
            }
        }

        //print_r($userList);

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
        if($userList){
            $userRes = $this->mapArrays($mapArr,$userList);
        }
        else{
            $userRes = array();
        }

        $data = array(
            'userList' => $userRes,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));
        //print_r($data);

        if($data === NULL){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }


    }
}