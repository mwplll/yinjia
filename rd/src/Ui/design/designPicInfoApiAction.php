<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午5:17
 */
class designPicInfoApiAction extends baseAction{
    public function execute(){
        $designPicObj = new LibDesignPic();
        $designSchemaObj = new LibDesignSchema();
        $designSchemaId = Dapper_Http_Request::getParam('id');

        if(!$designSchemaId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $designPics = $designPicObj->getDesignPicsByDesignId($designSchemaId);
            $designBaseInfo = $designSchemaObj->getDesignBaseInfoById($designSchemaId);
        }

        $mapArr = array(
            'picId' => 'design_pic_id',
            'pic' => 'design_pic',
            'name' => 'room_name'
        );
        $picData = $this->mapArrays($mapArr,$designPics);
        if($picData == FALSE){
            $picData = array();
        }

        $jsonData = array(
            'picList' => $picData,
            'id' => $designBaseInfo['design_schema_id'],
            'mainPic' => $designBaseInfo['main_pic']
            );

        //print_r($jsonData);

        if($designBaseInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($jsonData);

    }
}