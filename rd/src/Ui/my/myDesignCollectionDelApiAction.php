<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-3-19
 * Time: 下午10:11
 */
class myDesignCollectionDelApiAction extends baseAction{
    public function execute(){
        $this->checkLogin();  //判断是否是登录用户
        $userId = $this->loginUid;
        if(!$userId){
            return $this->api_error(FAILED,"您还没有登录，请先登录！");
        }

        $designIds = Dapper_Http_Request::getParam('ids');

        //echo '$designIds = '."\n";
        //print_r($designIds);

        if(is_array($designIds)){
            $uaObj = new LibUserAction($this->loginUid);
            $res = $uaObj->delCollectedDesign($designIds);

            if($res == FALSE){
                return $this->api_error(FAILED);
            }
            else{
                return $this->api_success($res);
            }
        }
    }
}