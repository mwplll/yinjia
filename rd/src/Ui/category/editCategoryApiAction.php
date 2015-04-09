<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-17
 * Time: 下午5:09
 */
class editCategoryApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "del":
                $this->del();
                break;
            case "save":
                $this->save();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 删除商品分类操作
     * @return bool
     */
    public function del(){
        $catId = Dapper_Http_Request::getParam('id');
        if(!$catId){
            return $this->api_error(FAILED, 'please provide id');
        }

        $categoryObj = new LibCategory();
        $data['del'] = 1;
        $res = $categoryObj->updateCategory($data,$catId);
        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }

    }

    public function save(){
        $catId = Dapper_Http_Request::getParam('id');

        $data = array();
        $data['cat_name'] = Dapper_Http_Request::getParam('name');
        $data['del'] = Dapper_Http_Request::getParam('del',0);
        if(!$data['cat_name']){
            return $this->api_error(PARAM_ERROR,'please provide category name!');
        }

        $categoryObj = new LibCategory();
        $res = TRUE;
        if($catId){
            $res = $categoryObj->updateCategory($data,$catId);
        }
        else{
            $data['cat_father'] = Dapper_Http_Request::getParam('father',NULL);
            if(!isset($data['cat_father'])){
                return $this->api_error(PARAM_ERROR,'please provide category father id!');
            }
            $res = $categoryObj->addCategory($data);
        }

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }
    }


}