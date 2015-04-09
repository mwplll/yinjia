<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-1
 * Time: 下午5:25
 */
class houseListApiAction extends baseAction{
    public function execute(){
        $houseObj = new LibHouse();

        $num = intval(Dapper_Http_Request::getParam('num',15));
        $page = intval(Dapper_Http_Request::getParam('page',1));
        $cityId = Dapper_Http_Request::getParam('cityId',NULL);
        $areaId = Dapper_Http_Request::getParam('areaId',NULL);
        $buildingId = Dapper_Http_Request::getParam('buildingId',NULL);
        $states = Dapper_Http_Request::getParam('states');

        if(!$states){
            $states = array(0);
        }

        $houseDel = '(';
        foreach($states as $k=>$v){
            $houseDel = $houseDel.$v.',';
        }
        $houseDel = substr($houseDel,0,-1);
        $houseDel = $houseDel.')';
        //echo '$houseDel = '.$houseDel."\n";

        $wh = array();  //查询条件
        $wh['city_id'] = $cityId;
        $wh['area_id'] = $areaId;
        $wh['building_id'] = $buildingId;
        $wh['house_del'] = $houseDel;

        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $houseList = $houseObj->getHouseList($start,$num,$wh);
        $totalCount = (int)$houseObj->getHouseCount($wh);
        $totalPage = ceil($totalCount / $num);

        //print_r($houseList);

        $mapArr = array(
            'id' => 'house_type_id',
            'name' => 'house_type_name',
            'grossArea' => 'gross_area',
            'usableArea' => 'usable_area',
            'pic' => 'pic',
            'houseDesignNum' => 'design_num',
            'state' => 'house_del',
            'areaId' => 'area_id',
            'area' => 'area_name',
            'cityId' => 'city_id',
            'city' => 'city_name',
            'prov' => 'prov_name',
            'buildingId' => 'building_id',
            'building' => 'building_name',
            'buildingDesignNum' => 'total_design_num',
            'companyId' => 'company_id',
            'company' => 'company_name'
        );

        if($houseList){
            $houseListRes = $this->mapArrays($mapArr,$houseList);
        }
        else{
            $houseListRes = array();
        }

        $data = array(
            'houseList' => $houseListRes,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));

        //print_r($data);

        //json输出
        if($houseList === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($data);
    }
}