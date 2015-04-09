<?php

class designOrderApiAction extends baseAction
{
    public function execute()
    {
        $this->checkLogin();

        $uaObj = new LibUserAction($this->loginUid);
        $orderInfo = $uaObj->getDesignOrder();
        //print_r($OrderInfo);
        foreach($orderInfo as &$v){
            //设计方案信息
            $designId = $v['design_schema_id'];
            $designObj = new LibDesign();
            $v['design_schema'] = $designObj->getDesignInfoByDesignID($designId);

            //户型图信息
            $designInfo = $v['design_schema'];
            $houseObj = new LibHouse();
            $houseTypeId = $designInfo['house_type_id'];
            $v['house_type'] = $houseObj->getHouseTypeInfoByHouseTypeID($houseTypeId);
        }

        //print_r($orderInfo);
        if($orderInfo === FALSE){
            return $this->api_error(FAILED);
        }

        return $this->api_success($orderInfo);
    }
}