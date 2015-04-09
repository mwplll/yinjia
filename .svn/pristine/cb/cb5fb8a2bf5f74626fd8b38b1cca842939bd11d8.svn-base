<?php
/**
 * 默认首页
 */

class designDetailsApiAction extends baseAction
{
    public function execute()
    {
        $tplData['errorCode'] = SUCCESS;

        $designPicObj = new LibDesignPic();

        $designID = intval(Dapper_Http_Request::getParam('design_id', 0));
        //echo '$designID='.$designID;


        if($designID){
            $designRooms = $designPicObj->getDesignPicsByDesignId($designID);

            $designObj = new LibDesign();
            $designSchemaInfo = $designObj->getDesignInfoByDesignID($designID);

            //print_r($designSchemaInfo);

            $houseTypeID = $designSchemaInfo['house_type_id'];
            $houseObj = new LibHouse();
            $houseTypeInfo = $houseObj->getHouseTypeInfoByHouseTypeID($houseTypeID);

            //print_r($houseTypeInfo);
            //print_r($designSchemaInfo);
            //print_r($designRooms);
            //echo '$houseTypeId = '.$houseTypeId;

            $tplData = array(
                'errorCode' => SUCCESS,
                'data' => array(
                    'housetype' => $houseTypeInfo,
                    'designschema' => $designSchemaInfo,
                    'designrooms' => $designRooms

                )
            );

        }else{
            $tplData = array(
                'errorCode' => FAILED,
                'message' => '请传入 design_id查看方案详情'
            );
        }

        $this->echo_json($tplData);
        return;
    }




}
?>
