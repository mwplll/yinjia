<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-3-19
 * Time: 下午11:55
 */
class myDesignMaterialEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "save":
                $this->save();
                break;
            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    public function save(){
        $this->checkLogin();  //判断是否是登录用户
        $userId = $this->loginUid;
        if(!$userId){
            return $this->api_error(FAILED,"您还没有登录，请先登录！");
        }

        $designSchemaId = Dapper_Http_Request::getParam('id');
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }
        //首先判断该设计方案是否已经是用户收藏的方案
        $uaObj = new LibUserAction($userId);
        $isCollected = $uaObj->isCollectedDesign($designSchemaId);
        //echo '$isCollected = '.$isCollected."\n";
        if(!$isCollected){  //如果用户未收藏，则首先收藏方案，建立用户材料表
            //echo '$isCollected = '.$isCollected."\n";
            $collectRes = $uaObj->collectDesign($designSchemaId);
            if(!$collectRes){
                return $this->api_error(FAILED,'这可能不是一个上架的方案！');
            }
        }

        $materialList = Dapper_Http_Request::getParam('materialList');
        /*$materialList = array(array(
            "id" => 95,
            "goodsId" => 1,
            "productsId" => 1,
            "num" => 19,
        )
        );*/

        $myMaterialList = array();
        if(is_array($materialList)){
            foreach($materialList as $material){
                array_push($myMaterialList,array(
                    "material_user_id" => $material['id'],
                    "goods_id" => $material['goodsId'],
                    "products_id" => $material['productsId'],
                    "products_num" => intval($material['num'])
                ));
            }
        }

        if(is_array($materialList)){
            $res = $uaObj->updateMyMaterials($myMaterialList);
            if($res == FALSE){
                return $this->api_error(FAILED);
            }
            else{
                return $this->api_success($res);
            }
        }
        else{
            return $this->api_success(TRUE);
        }
    }
}