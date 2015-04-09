<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-27
 * Time: 下午2:59
 */

class getHouseTypeListApiAction extends baseAction {
    public function execute(){
        $HouseObj = LibFactory::getInstance('LibHouse');

        $buildingId = Dapper_Http_Request::getParam('building_id');
        //echo '$buildingId='.$buildingId;

        $buildingId = intval($buildingId);

        if($buildingId!==''){
            $HouseTypeList = $HouseObj->getHouseTypeListByBuildingId($buildingId);
            //print_r($HouseTypeList);
            $tplData = array(
                'errorCode' => SUCCESS,
                'data' => $HouseTypeList
            );
        }else{
            $tplData = array(
                'errorCode' => FAILED,
                'msg' => '请传入 building_id 搜索户型！'
            );
        }

        $this->echo_json($tplData);
        return;


    }


}

?>