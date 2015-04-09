<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午7:23
 */
class designCadEditApiAction extends baseAction{
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
        $designSchemaObj = new LibDesignSchema();
        $designSchemaId = Dapper_Http_Request::getParam('id');

        $data = array();
        $data['cad_file'] = Dapper_Http_Request::getParam('file',NULL);

        /*if(!$data['cad_file']){
            return $this->api_error(PARAM_ERROR,'please provide file!');
        }*/

        if(!$designSchemaId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            //更新施工图工程文件
            $res = $designSchemaObj->updateDesignSchema($designSchemaId,$data);
        }

        /*************************施工图图保存操作***************************/
        $designCadObj = new DBDesignCad();
        $designCadObj->delDesignCadsByDesignId($designSchemaId);   //删除该设计方案已有的效果图
        $this->_updateCads();   //更新已有的效果图
        $this->_addCads($designSchemaId);  //新增效果图


        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 整理施工图
     * @return array|bool
     */
    private function _gatherCads(){
        $cadNameArr = Dapper_Http_Request::getParam('name',NULL);
        $picArr = Dapper_Http_Request::getParam('pic',NULL);
        $picIdArr = Dapper_Http_Request::getParam('picId',NULL);

        $newCads = array();    //新增的效果图
        $updateCads = array();   //需要更新的效果图
        $num = count($cadNameArr);
        if(($num >= 1) && ($num == count($picArr)) && ($num == count($picIdArr))){
            foreach($cadNameArr as $k => $v){
                if(isset($picIdArr[$k]) && $picIdArr[$k] != NULL){
                    array_push($updateCads,array(
                        "design_cad_id" => $picIdArr[$k],
                        "design_cad" => $picArr[$k],
                        "cad_name" => $v
                    ));
                }
                else{
                    array_push($newCads,array(
                        "design_cad" => $picArr[$k],
                        "cad_name" => $v
                    ));
                }
            }

            $cads = array();
            $cads['new'] = $newCads;
            $cads['update'] = $updateCads;
            return $cads;
        }
        return FALSE;
    }

    /**
     * 批量更新施工图
     * @return bool|mixed
     */
    private function _updateCads(){
        $designCads = $this->_gatherCads();
        $designCadObj = new LibDesignCad();

        if($designCads['update']){
            $updateRes = $designCadObj->updateDesignCads($designCads['update']);
            //echo 'update'."\n";
            return $updateRes;
        }
        return FALSE;
    }

    /**
     * 批量增加施工图
     * @param $designSchemaId
     * @return bool|mixed
     */
    private function _addCads($designSchemaId){
        $designCads = $this->_gatherCads();
        $designCadObj = new LibDesignCad();

        if($designCads['new']){
            foreach($designCads['new'] as &$value){
                $value['design_schema_id'] = $designSchemaId;
            }
            $addRes = $designCadObj->addDesignCads($designCads['new']);
            //echo 'add '."\n";
            return $addRes;
        }

        return FALSE;
    }


}