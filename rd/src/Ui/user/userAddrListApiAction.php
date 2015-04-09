<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-5
 * Time: 下午10:48
 */
class userAddrListApiAction extends baseAction{
    public function execute(){
        if(!$this->checkLogin()){
            return $this->api_error(FAILED,'not login：未登陆，需要先登陆！');
        }

        $userId = $this->loginUid;
        //echo '$userId = '.$userId;

        $addrObj = new LibAddr();
        $addrList = $addrObj->getAddrListByUserId($userId);

        //输出映射表
        $mapArr = array(
            'id' => 'addr_id',
            'userId' => 'user_id',
            'address' => 'address',
            'area' => 'area',
            'city' => 'city',
            'province' => 'province',
            'name' => 'accept_name',
            'zip' => 'zip',
            'telephone' => 'telephone',
            'mobile' => 'mobile',
            'isDefault' => 'is_default'
        );
        if($addrList){
            $addrRes = $this->mapArrays($mapArr,$addrList);
        }
        else{
            $addrRes = array();
        }

        if($addrList === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($addrRes);


    }
}

?>