<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-9
 * Time: 下午7:37
 */
class designerSchemaListApiAction extends baseAction{
    public function execute(){
        //判断是否登录
        if(!$this->checkLogin()){
            return $this->api_error(USER_UNLOGIN, 'not login');
        }
        $userId = $this->loginUid;
        $userInfo = $this->loginInfo();

        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $wh = array();  //查询条件
        $wh['keywords'] = Dapper_Http_Request::getParam('keywords',NULL);
        $states = Dapper_Http_Request::getParam('state',NULL);
        //$wh['design_schema_del'] = $state;
        //$designerObj = new LibDesigner();
        //$designerInfo = $designerObj->getDesignerByUid($this->loginUid);
        $userInfo = $this->loginInfo();
        if(((int)$userInfo['is_special'] != 1) || ((int)$userInfo['is_checked'] != 1)){
            //echo '$designerInfo = '.$designerInfo."\n";
            return $this->api_error(PARAM_ERROR,"抱歉，您还不是设计师用户，或者还未通过设计师实名认证审核！");
        }
        else{
            $wh['user_id'] = $userId;
        }
        //$wh['user_id'] = $designerInfo['designer_id'];
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

        $houseTypeObj = new LibHouse();
        $designSchemaObj = new LibDesignSchema();
        $schemaList = $designSchemaObj->getDesignSchemaList($start,$num,$wh,$order);
        $totalCount = (int)$designSchemaObj->getDesignSchemaCount($wh);
        $totalPage = ceil($totalCount / $num);

        if($schemaList){
            foreach($schemaList as &$designSchema){
                $houseTypeId = $designSchema['house_type_id'];
                $houseTypeInfo = $houseTypeObj->getHouseById($houseTypeId);
                //print_r($houseTypeInfo);
                $mapArr = array(
                    'id' => 'house_type_id',
                    'name' => 'house_type_name',
                    'building' => 'building_name',
                    'area' => 'area_name',
                    'city' => 'city_name',
                    'prov' => 'prov_name'
                );
                $houseTypeInfo = $this->mapArray($mapArr,$houseTypeInfo);
                //print_r($houseTypeInfo);
                $designSchema['house_type'] = $houseTypeInfo;  //户型信息

                $designSchemaId = $designSchema['design_schema_id'];
                $designPrice = new LibDesignSchemaPrice();
                $designSchema['total_price'] = $designPrice->getDesignSchemaTotalPrice($designSchemaId);

                //设计师编号和设计方案编号
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
            'price' => 'design_price',
            'totalPrice' => 'total_price',
            'deposit' => 'design_deposit',
            'mainPic' => 'main_pic',
            'modifyTime' => 'modify_time',
            'viewNum' => 'view_num',
            'state' => 'design_schema_del',
            'houseType' => 'house_type'
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