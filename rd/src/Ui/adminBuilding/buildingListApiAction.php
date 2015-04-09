<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:39
 */
class buildingListApiAction1 extends baseAction{   //NOT USE
    public function execute(){
        $buildingObj = new LibBuilding();
        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        $wh['city_id'] = Dapper_Http_Request::getParam('city_id',NULL);
        $wh['area_id'] = Dapper_Http_Request::getParam('area_id',NULL);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;
        $buildingList = $buildingObj->getBuildingList($wh,$start,$num);
        $totalCount = (int)$buildingObj->getBuildingCount($wh);
        $totalPage = ceil($totalCount / $num);

        $data = array(
            'buildinglist' => $buildingList,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));
        //print_r($data);

        //echo 'time = '.time()."\n";
        //echo 'now = '.date('Y-m-d H:i:s',time())."\n";
        if($data === NULL){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }
    }
}