<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-3-19
 * Time: 下午11:26
 */
class myDesignMaterialApiAction extends baseAction{
    public function execute(){
        $designSchemaId = Dapper_Http_Request::getParam('id');

        if(!$designSchemaId){
            return $this->api_error(FAILED,'please provide id');
        }

        $this->checkLogin();  //判断是否是登录用户
        $userId = $this->loginUid;
        if(!$userId){
            return $this->api_error(FAILED,"您还没有登录，请先登录！");
        }


        $materialObj = new LibUserAction($this->loginUid);
        $materialList = $materialObj->getMyMaterialListBydesignId($designSchemaId);
        //print_r($materialList);

        $mapArr = array(
            'id' => 'material_user_id',
            'userId' => 'user_id',
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