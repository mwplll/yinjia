<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-8
 * Time: 下午5:29
 */
class designMaterialInfo2UserApiAction extends baseAction{
    public function execute(){
        $designSchemaId = Dapper_Http_Request::getParam('id');

        if(!$designSchemaId){
            return $this->api_error(FAILED,'please provide id');
        }

        $materialObj = new LibDesignMaterial();
        $materialList = $materialObj->getMaterialListBydesignId($designSchemaId);
        //print_r($materialList);

        $mapArr = array(
            'materialId' => 'design_material_id',
            'materialNo' => 'design_material_number',
            'materialName' => 'design_material_name',
            'goodsId' => 'goods_id',
            'goodsName' => 'goods_name',
            'period' => 'period',
            'unit' => 'unit',
            'productsId' => 'products_id',
            'sellPrice' => 'sell_price',
            'num' => 'products_num',
            'content' => 'designer_content'
        );
        $jsonData = $this->mapArrays($mapArr,$materialList);

        //if($jsonData === FALSE)
            //return $this->api_error(FAILED);
        //else
            return $this->api_success($jsonData);
    }


}