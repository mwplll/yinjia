<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-15
 * Time: 下午9:20
 */
class userAddrInfoApiAction extends baseAction{
    public function execute(){
        $addrObj = new LibAddr();

        $addrId = Dapper_Http_Request::getParam('id');
        if(!$addrId){
            return $this->api_error(PARAM_ERROR,'please provide addr id!');
        }

        $addrInfo = $addrObj->getAddrByAddrId($addrId);

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
        if($addrInfo){
            $addrRes = $this->mapArray($mapArr,$addrInfo);
        }
        else{
            $addrRes = array();
        }

        if($addrInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($addrRes);

    }
}