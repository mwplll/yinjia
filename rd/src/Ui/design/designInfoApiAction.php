<?php

/**
 * 默认首页
 */

class designInfoApiAction extends baseAction
{
    public function execute()
    {
        $tplData['errorCode'] = SUCCESS;

        $designObj = new LibDesign();
        $designPriceObj = new LibDesignSchemaPrice();

        $houseTypeID = intval(Dapper_Http_Request::getParam('house_type_id', 0));
        $num = intval(Dapper_Http_Request::getParam('num', 3));
        $page = intval(Dapper_Http_Request::getParam('page', 1));
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;


        $houseObj = new LibHouse();
        $houseTypeInfo = $houseObj->getHouseTypeInfoByHouseTypeID($houseTypeID);

        if($houseTypeID != NULL){
            $designInfo = $designObj->searchDesignByHouseTypeId($houseTypeID,$start,$num,1);

            //$totalCount = (int)$designObj->getDesignCountByHouseTypeId($houseTypeID);
            //$totalPage = ceil($totalCount / $num);

            $designPicObj = new LibDesignPic();


            foreach($designInfo as &$info){
                $id = $info['design_schema_id'];
                $info['room'] = $designPicObj->getDesignPicsByDesignId($id);
                $info['total_price'] = $designPriceObj->getDesignSchemaTotalPrice($id);

            }

            //print_r($designInfo);

            $tplData = array(
                'errorCode' => SUCCESS,
                'data' => array(
                    'designinfo' => $designInfo,
                    'housetype' => $houseTypeInfo


                )
            );
        }else{
            $tplData = array(
                'errorCode' => FAILED,
                'msg' => '请传入 house_type_id 搜索相关设计图'
            );
        }

        $this->echo_json($tplData);
        return;
    }




}
?>
