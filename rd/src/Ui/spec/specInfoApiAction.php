<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-20
 * Time: 下午9:39
 */
class specInfoApiAction extends baseAction{
    public function execute(){
        $specObj = new LibSpec();
        $specId = Dapper_Http_Request::getParam('id');

        if(!$specId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $sepcInfo = $specObj->getSpecById($specId);
        }

        $mapArr = array(
            'id' => 'spec_id',
            'name' => 'spec_name',
            'value' => 'spec_value',
            'type' => 'spec_type',
            'del' => 'is_del'
        );
        $jsonData = $this->mapArray($mapArr,$sepcInfo);


        if($sepcInfo['spec_type'] == 1){
            //将规格中的图片列表找出，做个转换，便于在图片表中查询相对应的图片
            //$specPics = str_replace("[","(",$sepcInfo['spec_value']);
            //$specPics = str_replace("]",")",$specPics);
            $specPicsValue = $sepcInfo['spec_value'];
            //echo '$specPicsValue = '.$specPicsValue;
            //$specPicValue = array();
            $specPicValue = explode(",",$specPicsValue);
            //print_r($specPicValue);
            foreach($specPicValue as &$value){
                $value = '"'.$value.'"';
            }
            $specPics = implode(",",$specPicValue);
            $specPics = '('.$specPics.')';
            //echo '$specPics = '.$specPics;

            //$specPics = '('.$sepcInfo['spec_value'].')';


            //echo '$specPics = '.$specPics;
            $specPicList = $specObj->getSpecPicInSpec($specPics);
            $map = array(
                'picId' => 'spec_pic_id',
                'pic' => 'spec_pic',
                'picName' => 'pic_name',
            );
            $jsonPicData = $this->mapArrays($map,$specPicList);
            $jsonData['picList'] = $jsonPicData;
        }

        //print_r($jsonData);

        if($sepcInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($jsonData);

    }
}