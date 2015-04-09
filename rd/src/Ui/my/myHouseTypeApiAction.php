<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-1
 * Time: 下午3:57
 */
class myHouseTypeApiAction extends baseAction{
    public function execute(){
        $this->checkLogin();
        //$userId = $this->loginUid;
        /*if(!$this->loginUid){
            return $this->api_error(USER_UNLOGIN ,"not login");
        }*/
        //echo '$userId = '.$userId;

        $houseObj = new LibHouse();
        //$userObj = new LibUser();

        $loginInfo = $this->loginInfo();
        //print_r($loginInfo);
        $houseTypeID = $loginInfo['house_type_id'];

        //echo '$houseTypeID = '.$houseTypeID;

        $houseTypeInfo = $houseObj->getHouseTypeInfoByHouseTypeID($houseTypeID);
        if($houseTypeInfo)
            return $this->api_success($houseTypeInfo);
        else
            return $this->api_success(NULL);
        //print_r($houseTypeInfo);

    }

}




?>