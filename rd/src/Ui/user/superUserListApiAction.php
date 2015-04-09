<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-27
 * Time: 下午8:41
 */
class superUserListApiAction extends baseAction{
    public function execute(){
        $userObj = new LibUser();

        $userList = $userObj->getsuperUserList();

        //print_r($userList);

        //输出映射表
        $mapArr = array(
            'id' => 'user_id',
            'user' => 'user_name',
            'isSpecial' => 'is_special'
        );

        if($userList){
            $userRes = $this->mapArrays($mapArr,$userList);
        }
        else{
            $userRes = array();
        }

        $data = array('userList' => $userRes);
        //print_r($data);

        if($data === NULL){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }


    }
}