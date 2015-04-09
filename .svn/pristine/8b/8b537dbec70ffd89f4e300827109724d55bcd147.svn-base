<?php

/**
 * 收藏户型 api
 * Class collectDesignApiAction
 */
class collectDesignApiAction extends baseAction{
    public function execute(){
        $this->checkLogin();  //判断是否是登录用户
        $data['user_id'] = $this->loginUid;
        if(!$data['user_id']){
            return $this->api_error(FAILED,"您还没有登录，请先登录！");
        }

        $designSchemaId = Dapper_Http_Request::getParam('id');

        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR, "no `id` param");
        }

        $uaObj = new LibUserAction($this->loginUid);
        $ret = $uaObj->collectDesign($designSchemaId);  //收藏设计方案

        if($ret){
            return $this->api_success(array(
                'collectionId' => $ret
            ));
        }else{
            return $this->api_error(FAILED, "该方案可能还不是上架的方案！");
        }
    }
}