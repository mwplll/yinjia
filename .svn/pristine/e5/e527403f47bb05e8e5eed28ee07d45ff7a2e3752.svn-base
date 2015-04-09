<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:39
 */

class buildingInfoApiAction1 extends baseAction{   //NOT USE
    public function execute(){
        $buildingObj = new LibBuilding();
        $buildId = Dapper_Http_Request::getParam('build_id');

        if(!$buildId){
            return $this->api_error(FAILED,'please provide build_id');
        }
        else{
            $res = $buildingObj->getBuildingById($buildId);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }
}