<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-16
 * Time: 下午10:38
 */
class designManualListApiAction extends baseAction{
    public function execute(){
        $designSchemaId = Dapper_Http_Request::getParam('id');
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }

        $designSchemaObj = new LibDesignSchema();
        $designSchemaBaseInfo = $designSchemaObj->getDesignBaseInfoById($designSchemaId);
        /*echo '$designSchemaBaseInfo = ';
        print_r($designSchemaBaseInfo);
        echo "\n";*/
        $houseTypeId = $designSchemaBaseInfo['house_type_id'];

        $manualObj = new LibManual();
        $manualList = $manualObj->getManualList();  //人工加辅料单价表
        /*echo '$manualList = ';
        print_r($manualList);
        echo "\n";*/

        $houseTypeObj = new LibHouse();
        $houseTypeInfo = $houseTypeObj->getHouseById($houseTypeId);
        $cityId = $houseTypeInfo['city_id'];
        $cityObj = new LibCity();
        $city = $cityObj->getCityById($cityId);
        $manualCoe = $city['manual_coe'];

        if($manualList){
            foreach($manualList as &$manual){
                $manual['manual_price'] = $manual['manual_price'] * $manualCoe;
                $manual['manual_price'] = round($manual['manual_price'],2);//计算结果保留两位小数
            }
        }

        $mapArr = array(
            'id' => 'manual_id',
            'name' => 'manual_name',
            'price' => 'manual_price',
            'styleId' => 'design_style_id',
            'styleName' => 'design_style_name'
        );

        if($manualList){
            $manualRes = $this->mapArrays($mapArr,$manualList);
        }
        else{
            $manualRes = array();
        }

        //print_r($manualList);
        if($manualList == FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($manualRes);
        }

    }
}