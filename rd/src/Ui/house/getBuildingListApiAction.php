<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-27
 * Time: 下午2:38
 */


class getBuildingListApiAction extends baseAction {
    public function execute(){
        $HouseObj = LibFactory::getInstance('LibHouse');

        $cityId = Dapper_Http_Request::getParam('city_id');

        $cityId = intval($cityId);

        if($cityId!==''){
            $BuildingList = $HouseObj->getBuildingListByCityId($cityId);
            //print_r($BuildingList);
            $tplData = array(
                'errorCode' => $BuildingList ? SUCCESS : FAILED,
                'data' => $BuildingList
            );
        }else{
            $tplData = array(
                'errorCode' => FAILED,
                'msg' => 'please provide city_id'
            );
        }

        $this->echo_json($tplData);
        return;


    }


}


?>