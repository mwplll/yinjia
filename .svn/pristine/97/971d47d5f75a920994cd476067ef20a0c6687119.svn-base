<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-10
 * Time: 上午12:24
 */
class designerSchemaEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');
        $designSchemaId = intval(Dapper_Http_Request::getParam('id',NULL));
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }
        //echo '$designSchemaId = '.$designSchemaId;

        $updateInfo = array();
        switch($act){
            case "del":
                $updateInfo['design_schema_del'] = 1;
                break;
            case "up":
                $updateInfo['design_schema_del'] = 0;
                break;
            case "down":
                $updateInfo['design_schema_del'] = 3;
                break;
            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
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
}