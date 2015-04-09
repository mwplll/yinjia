<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午5:42
 */
class designPicEditApiAction extends baseAction{
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
        $data['main_pic'] = Dapper_Http_Request::getParam('mainPic',NULL);

        if(!$data['main_pic']){
            return $this->api_error(PARAM_ERROR,'please provide mainPic!');
        }

        if(!$designSchemaId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            //更新效果图主图信息
            $res = $designSchemaObj->updateDesignSchema($designSchemaId,$data);
        }

        /*************************效果图保存操作***************************/
        $designPicObj = new DBDesignPic();
        $designPicObj->delDesignPicsByDesignId($designSchemaId);   //删除该设计方案已有的效果图
        $this->_updatePics();   //更新已有的效果图
        $this->_addPics($designSchemaId);  //新增效果图


        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 整理效果图
     * @return array|bool
     */
    private function _gatherPics(){
        $roomNameArr = Dapper_Http_Request::getParam('name',NULL);
        $picArr = Dapper_Http_Request::getParam('pic',NULL);
        $picIdArr = Dapper_Http_Request::getParam('picId',NULL);

        $newPics = array();    //新增的效果图
        $updatePics = array();   //需要更新的效果图
        $num = count($roomNameArr);
        if(($num >= 1) && ($num == count($picArr)) && ($num == count($picIdArr))){
            foreach($roomNameArr as $k => $v){
                if(isset($picIdArr[$k]) && $picIdArr[$k] != NULL){
                    array_push($updatePics,array(
                        "design_pic_id" => $picIdArr[$k],
                        "design_pic" => $picArr[$k],
                        "room_name" => $v
                    ));
                }
                else{
                    array_push($newPics,array(
                        "design_pic" => $picArr[$k],
                        "room_name" => $v
                    ));
                }
            }

            $pics = array();
            $pics['new'] = $newPics;
            $pics['update'] = $updatePics;
            return $pics;
        }
        return FALSE;
    }

    /**
     * 批量更新效果图
     * @return bool|mixed
     */
    private function _updatePics(){
        $designPics = $this->_gatherPics();
        $designPicObj = new LibDesignPic();

        if($designPics['update']){
            $updateRes = $designPicObj->updateDesignPics($designPics['update']);
            //echo 'update'."\n";
            return $updateRes;
        }
        return FALSE;
    }

    /**
     * 批量增加效果图
     * @param $designSchemaId
     * @return bool|mixed
     */
    private function _addPics($designSchemaId){
        $designPics = $this->_gatherPics();
        $designPicObj = new LibDesignPic();

        if($designPics['new']){
            foreach($designPics['new'] as &$value){
                $value['design_schema_id'] = $designSchemaId;
            }
            $addRes = $designPicObj->addDesignPics($designPics['new']);
            //echo 'add '."\n";
            return $addRes;
        }

        return FALSE;
    }


}