<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:39
 */

class buildingInfoApiAction extends baseAction{
    public function execute(){
        $buildingObj = new LibBuilding();
        $buildId = Dapper_Http_Request::getParam('id');

        if(!$buildId){
            return $this->api_error(FAILED,'please provide right building id!');
        }
        else{
            $buildingInfo = $buildingObj->getBuildingById($buildId);
        }

        $mapArr = array(
            'id' => 'building_id',
            'cityId' => 'city_id',
            'prov' => 'prov_name',
            'city' => 'city_name',
            'areaId' => 'area_id',
            'area' => 'area_name',
            'name' => 'building_name',
            'recommend' => 'building_recommend',
            'designNum' => 'total_design_num',
            'companyId' => 'company_id',
            'company' => 'company_name'
        );

        if($buildingInfo){
            $buildingRes = $this->mapArray($mapArr,$buildingInfo);
        }
        else{
            $buildingRes = array();
        }

        if($buildingInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($buildingRes);

    }
}