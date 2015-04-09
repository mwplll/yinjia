<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:35
 */
class articleCatEditApiAction extends baseAction{
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
     * 删除分类操作
     * @return bool
     */
    public function del(){
        $catId = Dapper_Http_Request::getParam('id');
        if(!$catId){
            return $this->api_error(FAILED, 'please provide id');
        }

        $categoryObj = new LibArticleCat();
        $data['cat_del'] = 1;
        $res = $categoryObj->updateArticleCat($catId,$data);
        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }

    }

    /**
     * 保存分类操作
     * @return bool
     */
    public function save(){
        $catId = Dapper_Http_Request::getParam('id');

        $data = array();
        $data['cat_name'] = Dapper_Http_Request::getParam('name');
        $data['cat_del'] = Dapper_Http_Request::getParam('state',0);
        if(!$data['cat_name']){
            return $this->api_error(PARAM_ERROR,'please provide category name!');
        }

        $categoryObj = new LibArticleCat();
        $res = TRUE;
        if($catId){
            $res = $categoryObj->updateArticleCat($catId,$data);
        }
        else{
            //echo 'no catId';
            $data['cat_father'] = Dapper_Http_Request::getParam('fatherId',NULL);
            if(!isset($data['cat_father'])){
                //echo 'hello';
                $data['cat_father'] = intval($data['cat_father']);
                return $this->api_error(PARAM_ERROR,'please provide category father id!');
            }
            $res = $categoryObj->addArticleCat($data);
        }

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }
    }


}