<?php

class myDesignCollectionApiAction extends baseAction
{
    public function execute(){
        $this->checkLogin();  //判断是否是登录用户
        $userId = $this->loginUid;
        if(!$userId){
            return $this->api_error(FAILED,"您还没有登录，请先登录！");
        }

        $uaObj = new LibUserAction($this->loginUid);
        $schemaList = $uaObj->getDesignCollection(); //收藏的设计方案列表
        //print_r($schemaList);


        if($schemaList){
            foreach($schemaList as &$designSchema){
                $houseTypeId = $designSchema['house_type_id'];
                //echo '$houseTypeId = '.$houseTypeId."\n";
                $houseTypeObj = new LibHouse();
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
            'state' => 'design_schema_del',
            'recommend' => 'design_schema_recommend',
            'houseType' => 'house_type',
            'file' => 'cad_file'
        );
        $schemaList = $this->mapArrays($mapArr,$schemaList);
        if($schemaList == FALSE){
            $schemaList = array();
        }

        $jsonData = array('schemaList' => $schemaList);

        //print_r($jsonData);
        if($jsonData == FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($jsonData);
        }
    }
}