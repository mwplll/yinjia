<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-9
 * Time: 下午7:37
 */
class designSchemaListApiAction extends baseAction{
    public function execute(){
        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $wh = array();  //查询条件
        $wh['keywords'] = Dapper_Http_Request::getParam('keywords',NULL);
        $wh['city_id'] = Dapper_Http_Request::getParam('cityId',NULL);
        $wh['area_id'] = Dapper_Http_Request::getParam('areaId',NULL);
        $wh['building_id'] = Dapper_Http_Request::getParam('buildingId',NULL);
        $wh['house_type_id'] = Dapper_Http_Request::getParam('houseId',NULL);
        $recommend = Dapper_Http_Request::getParam('recommend',NULL);
        $states = Dapper_Http_Request::getParam('states',NULL);
        //print_r($states);
        $order = array();  //排序
        $sort = Dapper_Http_Request::getParam('sort',NULL);
        $turn = intval(Dapper_Http_Request::getParam('turn',1));
        $order['turn'] = $turn;  //0为正序，1为倒序，默认为1
        switch($sort){
            case "time":
                $order['sort'] = 'modify_time';
                break;
            case "price":
                $order['price'] = 'design_price';
                break;

            default:
                $order['sort'] = 'modify_time';  //默认按更新时间排序
                break;
        }

        //设计方案状态
        if(!isset($states)){
            $states = array(0);
        }

        $designSchemaDel = '(';
        foreach($states as $k=>$v){
            $designSchemaDel = $designSchemaDel.$v.',';
        }
        $designSchemaDel = substr($designSchemaDel,0,-1);
        $designSchemaDel = $designSchemaDel.')';
        $wh['design_schema_del'] = $designSchemaDel;
        //推荐状态
        if(!isset($recommend)){
            $recommend = array(0,1);
        }

        $designSchemarecommend = '(';
        foreach($recommend as $k=>$v){
            $designSchemarecommend = $designSchemarecommend.$v.',';
        }
        $designSchemarecommend = substr($designSchemarecommend,0,-1);
        $designSchemarecommend = $designSchemarecommend.')';
        $wh['design_schema_recommend'] = $designSchemarecommend;

        $houseTypeObj = new LibHouse();
        $designSchemaObj = new LibDesignSchema();
        $schemaList = $designSchemaObj->getDesignSchemaList($start,$num,$wh,$order);
        $totalCount = (int)$designSchemaObj->getDesignSchemaCount($wh);
        $totalPage = ceil($totalCount / $num);

        if($schemaList){
            foreach($schemaList as &$designSchema){
                //户型信息
                $houseTypeId = $designSchema['house_type_id'];
                $houseTypeInfo = $houseTypeObj->getHouseById($houseTypeId);
                //print_r($houseTypeInfo);
                $mapArr = array(
                    'id' => 'house_type_id',
                    'name' => 'house_type_name',
                    'grossArea' => 'gross_area',
                    'building' => 'building_name',
                    'area' => 'area_name',
                    'city' => 'city_name',
                    'prov' => 'prov_name'
                );
                $houseTypeInfo = $this->mapArray($mapArr,$houseTypeInfo);
                $designSchema['house_type'] = $houseTypeInfo;

                //装修总价
                $designSchemaId = $designSchema['design_schema_id'];
                $designPrice = new LibDesignSchemaPrice();
                $designSchema['total_price'] = $designPrice->getDesignSchemaTotalPrice($designSchemaId);  //装修总价

                //设计师编号和设计方案编号
                $designSchema['designer_sn'] = 'YJ'.str_pad(($designSchema['designer_sn']),5,"0",STR_PAD_LEFT);
                $designSchema['design_sn'] = $designSchema['designer_sn'].str_pad(($designSchema['design_sn']),4,"0",STR_PAD_LEFT);
            }
        }

        //输出处理
        $mapArr = array(
            'id' => 'design_schema_id',
            'name' => 'design_name',
            'designSn' => 'design_sn',
            'userId' => 'user_id',
            'userName' => 'user_name',
            'realName' => 'real_name',
            'qq' => 'qq',
            'designerSn' => 'designer_sn',
            'avatar' => 'user_avatar',
            'price' => 'design_price',
            'totalPrice' => 'total_price',
            'deposit' => 'design_deposit',
            'mainPic' => 'main_pic',
            'modifyTime' => 'modify_time',
            'viewNum' => 'view_num',
            'likeNum' => 'like_num',
            'commentNum' => 'comment_num',
            'state' => 'design_schema_del',
            'recommend' => 'design_schema_recommend',
            'houseType' => 'house_type',
            'file' => 'cad_file'
        );
        $schemaList = $this->mapArrays($mapArr,$schemaList);
        if($schemaList == FALSE){
            $schemaList = array();
        }

        $jsonData = array(
            'schemaList' => $schemaList,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));

        //print_r($jsonData);
        if($jsonData == FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($jsonData);
        }

    }
}