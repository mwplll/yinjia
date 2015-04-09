<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-7
 * Time: 下午4:53
 */
class designOrderInfoApiAction extends baseAction{
    public function execute(){
        $this->checkLogin();

        $orderSn = Dapper_Http_Request::getParam('sn');

        $orderObj = new LibOrder();

        if(strlen($orderSn) != 16){
            return $this->api_error(PARAM_ERROR,"please provide sn with 16 figures");
        }
        else{
            $orderInfo = $orderObj->getOrderBySn($orderSn);

            //用户信息
            $userId = $orderInfo['user_id'];
            $userObj = new LibUser();
            $orderInfo['user'] = $userObj->getUserById($userId);

            //设计方案信息
            $designId = $orderInfo['design_schema_id'];
            $designObj = new LibDesign();
            $orderInfo['design_schema'] = $designObj->getDesignInfoByDesignID($designId);

            //户型信息
            $designInfo = $orderInfo['design_schema'];
            $houseObj = new LibHouse();
            $houseTypeId = $designInfo['house_type_id'];
            $orderInfo['house_type'] = $houseObj->getHouseTypeInfoByHouseTypeID($houseTypeId);

            //收货地址信息
            $addrId = $orderInfo['addr_id'];
            $addrObj = new LibAddr();
            $orderInfo['addr'] = $addrObj->getAddrByAddrId($addrId);

            //重新上传的设计方案信息
            $designId = $orderInfo['cp_design_schema_id'];
            $designObj = new LibDesign();
            $orderInfo['cp_design_schema'] = $designObj->getDesignInfoByDesignID($designId);
            $designRoomObj = new LibDesignRoom();
            $orderInfo['cp_design_rooms'] = $designRoomObj->getRoomsByDesignId($designId);


            if($orderInfo === FALSE){
                return $this->api_error(FAILED);
            }
            else{
                return $this->api_success($orderInfo);
            }
        }
    }

}

?>