<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-13
 * Time: 下午12:02
 */
class designPropagadaApiAction extends baseAction
{
    public function execute()
    {
        $designRoomObj = LibFactory::getInstance('LibDesignRoom');
        $designObj = LibFactory::getInstance('LibDesign');
        $houseTypeObj = LibFactory::getInstance('LibHouse');

        //指定用于前台展示设计方案ID
        $designSchemaIds = array(array('designId'=>1),
                                  array('designId'=>2),
                                  array('designId'=>3),
                                  array('designId'=>4),
                                  array('designId'=>5),
                                  //array('designId'=>6),
                                  //array('designId'=>7),
                                  //array('designId'=>8),
//                                  array('designId'=>9),
//                                  array('designId'=>10),
//                                  array('designId'=>11),

        );
        foreach($designSchemaIds as &$designSchemaId){
            //echo $designSchemaId['designId'];
            $designSchemaId['pic']= $designRoomObj->getRoomsByDesignId($designSchemaId['designId']);
            //print_r($designSchemaId['pic']);
            if(isset($designSchemaId['pic']['0']['house_type_id']))
                $houseId = $designSchemaId['pic']['0']['house_type_id'];
            $houseTypeInfo = $houseTypeObj->getHousetypeInfoByHousetypeID($houseId);
            $designSchemaId['house_type_info'] = $houseTypeInfo;
            $designSchemaInfo = $designObj->getDesignInfoByDesignID($designSchemaId['designId']);
            $designSchemaId['design_schema_info'] = $designSchemaInfo;

        }

        //print_r($designSchemaIds);
//        $designObj = LibFactory::getInstance('LibDesign');
//        $designInfo = $designObj->searchDesignForDisplay();
//
//        $designRoomObj = LibFactory::getInstance('LibDesignRoom');
//        $houseTypeObj = LibFactory::getInstance('LibHouse');
//
//
//        //echo $designInfo;
//        foreach($designInfo as &$info){
//
//            $id = $info['design_schema_id'];
//            $house_type_id = $info['house_type_id'];
//            $info['room'] = $designRoomObj->getRoomsByDesignId($id);
//            $info['house_type_id'] = $houseTypeObj->getHousetypeInfoByHousetypeID($house_type_id);
//        }

        $tplData = array(
            'errorCode' => SUCCESS,
            'data' => $designSchemaIds
        );

        $this->echo_json($tplData);
    }

}
?>