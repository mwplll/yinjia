<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-10
 * Time: 上午12:38
 */
class adminDesignSchemaEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "check":
                $this->check();
                break;
            case "del":
                $this->del();
                break;
            case "recommend":
                $this->recommend();
                break;
            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 删除操作
     * @return bool
     */
    public function del(){
        $designSchemaId = Dapper_Http_Request::getParam('id',NULL);
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }

        $updateInfo = array();
        $updateInfo['design_schema_del'] = 1;
        $designSchemaObj = new LibDesignSchema();
        $res = $designSchemaObj->updateDesignSchema($designSchemaId,$updateInfo);

        if($res == FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }
    }

    /**
     * 管理员审核操作
     * @return bool
     */
    public function check(){
        $designSchemaId = Dapper_Http_Request::getParam('id',NULL);
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }

        $updateInfo = array();
        $isChecked = Dapper_Http_Request::getParam('isCheck',NULL);
        if($isChecked == NULL){
            return $this->api_error(PARAM_ERROR,'please provide isCheck');
        }
        elseif($isChecked == 0){
            $updateInfo['design_schema_del'] = 4;
            $updateInfo['fail_reason'] = Dapper_Http_Request::getParam('reason',NULL);
            if(!$updateInfo['fail_reason']){
                return $this->api_error(PARAM_ERROR,'please provide fail reason!');
            }
        }
        else{
            $updateInfo['design_schema_del'] = 0;
        }

        $designSchemaObj = new LibDesignSchema();
        $res = $designSchemaObj->updateDesignSchema($designSchemaId,$updateInfo);

        if($res == FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }

    }

    /**
     * 推荐的设计方案
     * @return bool
     */
    public function recommend(){
        $designSchemaId = Dapper_Http_Request::getParam('id',NULL);
        //$designSchemaId = Dapper_Http_Request::getParam('recommend',0);
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }

        $updateInfo = array();
        $updateInfo['design_schema_recommend'] = Dapper_Http_Request::getParam('recommend',0);
        $designSchemaObj = new LibDesignSchema();
        $res = $designSchemaObj->updateDesignSchema($designSchemaId,$updateInfo);

        if($res == FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }
    }


}