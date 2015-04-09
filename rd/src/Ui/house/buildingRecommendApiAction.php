<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-8
 * Time: 上午11:15
 */
class buildingRecommendApiAction extends baseAction{
    public function execute(){
        $buildingObj = new LibBuilding();

        $wh['building_recommend'] = 1;
        $buildingList = $buildingObj->getBuildingList(0,8,$wh);  //查询推荐楼盘

        //print_r($buildingList);

        //输出字段映射
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
        if($buildingList)
            $buildingRes = $this->mapArrays($mapArr,$buildingList);
        else
            $buildingRes = array();

        $data = array(
            'buildingList' => $buildingRes
        );

        if($buildingList === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }

    }
}