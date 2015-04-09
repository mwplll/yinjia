<?php

class houseInfoApiAction extends baseAction
{
    public function execute(){

        $houseObj = new LibHouse();
        $houseId = intval(Dapper_Http_Request::getParam('id',0));

        if(!$houseId){
            return $this->api_error(FAILED,'please provide right house id!');
        }
        else{
            $houseInfo = $houseObj->getHouseById($houseId);
        }

        //print_r($houseInfo);
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

        if($houseInfo){
            $houseRes = $this->mapArray($mapArr,$houseInfo);
        }
        else{
            $houseRes = array();
        }

        //print_r($houseRes);
        if($houseInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($houseRes);

    }
    /*public function execute()
    {


        // 使用 __autoload() 自动加载 PHP 的类文件
        // 参考 Dapper.class.php(index.php 加载的框架入口文件)中调用的 Dapper::registerAutoload();
        // @see http://www.jb51.net/article/29625.htm
        // spl_autoload_register
//        $db = new DBHouse();
        $db = DBFactory::getInstance('DBHouse');

        // 每页的个数
        $num = isset($_GET["num"]) ? $_GET["num"] : 15;
        // 当前的分页
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        if($page < 1){
            $page = 1;
        }

        $start = ($page - 1) * $num;
        //楼盘所在的城市
        $city = isset($_GET["city"]) ? $_GET["city"] : NULL;
        //楼盘所在区域
        $area = isset($_GET["area"]) ? $_GET["area"] : NULL;
        //楼盘的开发商
        $keywords = isset($_GET["keywords"]) ? $_GET["keywords"] : NULL;
        //户型建筑面积最小值
        $minarea = isset($_GET["minarea"]) ? $_GET["minarea"] : 0;
        //echo '$_GET["minarea"] = '.$_GET["minarea"];
        //echo 'isset($_GET["minarea"]) = '.isset($_GET["minarea"]);
        //echo '$minarea = '.$minarea;
        //户型建筑面积最大值
        $maxarea = isset($_GET["maxarea"]) ? $_GET["maxarea"] : 1000;

        $wh=array();
        $wh['city'] = $city;
        $wh['area'] = $area;
        $wh['keywords'] = $keywords;
        $wh['minarea'] = $minarea;
        $wh['maxarea'] = $maxarea;
        $enable = Dapper_Http_Request::getParam('enable',NULL);
        //echo '$enable = '.$enable;
        if($enable == 'all'){
            $wh['is_enable'] = '(1'.','.'2)';
        }
        else{
            $wh['is_enable'] = '(1'.')';
        }
        //print_r($wh);

        $return = $db->getHouseTypeList($num, $start,$wh);
        $totalCount = (int)$db->getHouseTypeCount($wh);
        $totalPage = ceil($totalCount / $num);

        $tplData = array(
            'errorCode' => SUCCESS,//$return ? SUCCESS : FAILED,
            'data' => array(
                'list' => $return,
                'pagination' => array(
                    'count' => $totalCount,
                    'page' => $totalPage
                ),
            )
        );

        $this->echo_json($tplData);
    }*/



}
?>
