<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-2
 * Time: 下午10:20
 */
class addMyHouseTypeApiAction extends baseAction{
    public function execute(){
        $getHouseTypeId = Dapper_Http_Request::getParam('house_type_id');
        //1.判断用户是否登录
        $this->checkLogin();

        //2.对于已登录用户，查找Userid
        //$loginInfo = $this->loginInfo();
        $userId = $this->loginUid;
        //$houseTypeId = $loginInfo['house_type_id'];

        $userObj = new LibUser();
        $updateUserInfo = array(
            'house_type_id' => $getHouseTypeId
        );
        if($userObj->updateUser($updateUserInfo,$userId))
            return $this->api_success('');
        else
            return $this->api_error(USER_BASE_INFO_ADD_FAILED,'添加我的户型失败');

/*        if(!$houseTypeId){//3.如果不存在关联的户型id,则添加该户型id到当前用户表
            if($userObj->addHouseTypeIdToUser($houseTypeId))
                $this->api_success('');
            else
                $this->api_error(USER_BASE_INFO_ADD_FAILED,'添加我的户型失败');
        }
        elseif($getHouseTypeId == $houseTypeId){//4.如果关联的户型id与客户端提交的户型id相同，返回提示信息
            $this->api_error(USER_BASE_INFO_ADD_FAILED,'该户型图已经是我的户型了');
        }
        else{//5.如果关联的户型id与客户端提交的户型id不同，强制替换替换当前户型id
            if($userObj->addHouseTypeIdToUser($houseTypeId))
                $this->api_success('');
            else
                $this->api_error(USER_BASE_INFO_ADD_FAILED,'添加我的户型失败');
        }*/





    }

}

?>