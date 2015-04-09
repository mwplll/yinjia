<?php

class getHouseInfoApiAction extends baseAction{
    public function execute(){

        $houseTypeId = intval(Dapper_Http_Request::getParam('house_type_id', 1));

        $houseObj = new LibHouse();

        $data = $houseObj->getHouseTypeInfoByHouseTypeID($houseTypeId);

        if(!$data){
            return $this->api_error(FAILED, "无法查询到 id 为 $houseTypeId 的相关户型信息");
        }

        $res = $houseObj->getRoomsByHouseId($houseTypeId);

        $data['room'] = $res ? $res : array();

        $tplData['errorCode'] = SUCCESS;
        $tplData['data'] = $data;

        $this->echo_json($tplData);

//        $houseObj->getRoomsById();

    }
}
