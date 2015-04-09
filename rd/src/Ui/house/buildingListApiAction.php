<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-1
 * Time: 下午3:25
 */
class buildingListApiAction extends baseAction{
    public function execute(){
        $buildingObj = new LibBuilding();
        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        $cityId = Dapper_Http_Request::getParam('cityId',NULL);
        $areaId = Dapper_Http_Request::getParam('areaId',NULL);
        //echo '$areaId = '.$areaId;
        //构建查询条件
        $wh = array();
        if($cityId){
            $wh['city_id'] = $cityId;
        }
        if($areaId){
            //echo '$areaId = '.$areaId;
            $wh['area_id'] = $areaId;
        }

        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;
        $buildingList = $buildingObj->getBuildingList($start,$num,$wh);
        $totalCount = (int)$buildingObj->getBuildingCount($wh);
        $totalPage = ceil($totalCount / $num);

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
            $buildingList = $this->mapArrays($mapArr,$buildingList);
        else
            $buildingList = array();

        $data = array(
            'buildingList' => $buildingList,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));
        //print_r($data);

        //echo 'time = '.time()."\n";
        //echo 'now = '.date('Y-m-d H:i:s',time())."\n";
        if($data === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }
    }
}