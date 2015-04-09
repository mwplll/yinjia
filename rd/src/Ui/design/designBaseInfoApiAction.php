<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午3:59
 */
class designBaseInfoApiAction extends baseAction{
    public function execute(){
        $designSchemaObj = new LibDesignSchema();
        $designSchemaId = Dapper_Http_Request::getParam('id');

        if(!$designSchemaId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $designBaseInfo = $designSchemaObj->getDesignBaseInfoById($designSchemaId);
        }


        if($designBaseInfo){
            //设计师信息
            $designerId = intval($designBaseInfo['user_id']);
            $userObj = new LibUser();
            $designerInfo = $userObj->getUserById($designerId);
            $designerInfo['designer_sn'] = 'YJ'.str_pad(($designerInfo['designer_sn']),5,"0",STR_PAD_LEFT);
            $mapArr = array(
                'id' => 'user_id',
                'userName' => 'user_name',
                'realName' => 'real_name',
                'qq' => 'qq',
                'designerSn' => 'designer_sn',
                'avatar' => 'user_avatar',
                'tel' => 'user_tel'
            );
            $designerInfo = $this->mapArray($mapArr,$designerInfo);
            $designBaseInfo['designer'] = $designerInfo;
            //装修总价
            $designPriceObj = new LibDesignSchemaPrice();
            $designBaseInfo['total_price'] = $designPriceObj->getDesignSchemaTotalPrice($designSchemaId);
            $designBaseInfo['manual_price'] = $designPriceObj->getManualPrice($designSchemaId);
            $designBaseInfo['material_price'] = $designPriceObj->getMaterialPrice($designSchemaId);
            //户型信息
            $houseTypeId = $designBaseInfo['house_type_id'];
            $houseTypeObj = new LibHouse();
            $houseTypeInfo = $houseTypeObj->getHouseById($houseTypeId);
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
            $designBaseInfo['house_type'] = $houseTypeInfo;
            //设计方案编号
            $designBaseInfo['design_sn'] = $designerInfo['designerSn'].str_pad(($designBaseInfo['design_sn']),4,"0",STR_PAD_LEFT);
        }

        $mapArr = array(
            'id' => 'design_schema_id',
            'name' => 'design_name',
            'designSn' => 'design_sn',
            'houseTypeId' => 'house_type_id',
            'totalPrice' => 'total_price',
            'manualPrice' => 'manual_price',
            'materialPrice' => 'material_price',
            'price' => 'design_price',
            'deposit' => 'design_deposit',
            'content' => 'design_content',
            'mainPic' => 'main_pic',
            'cadFile' => 'cad_file',
            'designer' => 'designer',
            'houseType' => 'house_type'
        );
        $jsonData = $this->mapArray($mapArr,$designBaseInfo);

        //print_r($jsonData);

        if($designBaseInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($jsonData);

    }
}