<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午7:23
 */
class designCadInfoApiAction extends baseAction{
    public function execute(){
        $designCadObj = new LibDesignCad();
        $designSchemaObj = new LibDesignSchema();
        $designSchemaId = Dapper_Http_Request::getParam('id');

        if(!$designSchemaId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $designCads = $designCadObj->getDesignCadsByDesignId($designSchemaId);
            $designBaseInfo = $designSchemaObj->getDesignBaseInfoById($designSchemaId);
        }

        $mapArr = array(
            'picId' => 'design_cad_id',
            'pic' => 'design_cad',
            'name' => 'cad_name'
        );
        $cadData = $this->mapArrays($mapArr,$designCads);
        if($cadData == FALSE){
            $cadData = array();
        }

        $jsonData = array(
            'picList' => $cadData,
            'id' => $designBaseInfo['design_schema_id'],
            'file' => $designBaseInfo['cad_file']
        );

        //print_r($jsonData);

        if($designBaseInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($jsonData);

    }
}