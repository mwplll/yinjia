<?php
/**
 * 创建设计图 API
 */


class editOrderDesignApiAction extends baseAction
{
    public function execute()
    {
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "update":
                $this->update();
                break;
            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }

    }


    /**
     * 整理房间设计图信息
     */
    private function _gatherDesignRoom(){
        $arr_room_id = Dapper_Http_Request::getParam('room_id');
        $arr_design_pic = Dapper_Http_Request::getParam('design_pic');


        $rooms = array();


        $room_id_num = count($arr_room_id);
        if($room_id_num >= 1 && ($room_id_num == count($arr_design_pic))){
            foreach($arr_room_id as $i => $v){
                array_push($rooms, array(
                    'room_id' => $v,
                    'design_pic' => $arr_design_pic[$i]
                ));
            }
        }

        return $rooms;
    }

    /**
     * 更新设计方案
     */
    public function update(){
        $data = array();
        $this->checkLogin();

        $userId = $this->loginUid;
        $designerObj = new LibDesigner();
        $designerInfo = $designerObj->getDesignerByUid($userId);
        $designerId = $designerInfo['designer_id'];
        $data['designer_id'] = $designerId;

        $data['design_schema_id'] = Dapper_Http_Request::getParam('design_schema_id');
        $data['design_name'] = Dapper_Http_Request::getParam('name');
        $data['house_type_id'] = intval(Dapper_Http_Request::getParam('house_type_id'));
        $data['design_price'] = Dapper_Http_Request::getParam('price');
        $data['design_deposit'] = Dapper_Http_Request::getParam('deposit');
        $data['estimate_price'] = Dapper_Http_Request::getParam('estimate_price');
        $data['main_pic'] = Dapper_Http_Request::getParam('main_pic');

        if(!$data['house_type_id'] || !$data['design_name'] || !$data['design_price'] || !$data['design_deposit']){
            return $this->api_error(PARAM_ERROR, 'please provide house_type_id, name , price, deposit');
        }

        // 是否提供了 design_room 信息
        $designRooms = $this->_gatherDesignRoom();
        if(count($designRooms) < 1){
            return $this->api_error(PARAM_ERROR, 'please provide room_id[], design_pic[]');
        }

        // 传入的 house_id 是否合法
        $houseObj = new LibHouse();
        $houseInfo = $houseObj->getHouseById($data['house_type_id']);
        if(!$houseInfo){
            return $this->api_error(PARAM_ERROR, 'house_type_id not valid!');
        }

        // 满足条件，更新设计方案
        $designObj = new LibDesign();
        $designId = $data['design_schema_id'];
        $res = $designObj->updateDesignInfo($data,$designId);

        if(!$res){
            return $this->api_error(FAILED, 'update design schema failed!');
        }
        //$data['design_schema_id'] = $designId;

        // 删除该设计方案已有的效果图
        $designRoomObj = new LibDesignRoom();
        $delDesignRooms = $designRoomObj->getRoomsByDesignId($designId);
        if(is_array($delDesignRooms)){
            foreach($delDesignRooms as $designRoom){
                $delDesignRoomId = $designRoom['design_room_id'];
                $designRoomObj->delDesignRoomById($delDesignRoomId);
            }
        }

        //添加设计方案的效果图
        foreach($designRooms as &$room){
            $room['design_schema_id'] = $designId;
        }

        $addedDesignRoomId = $designRoomObj->addDesignRooms($designRooms);

        if(!$addedDesignRoomId){
            return $this->api_error(FAILED, 'create design room failed!');
        }

        $data['design_room'] = $designRooms;
        $this->api_success($data);
        // 添加设计图
    }


}
/*
$op = Dapper_Http_Request::getParam('op', false);
$designCtrl = LibFactory::getInstance('LibDesign');

if('add' == $op){ // 新建操作

$house_type_id = intval(Dapper_Http_Request::getParam('house_id', false));
$author_id = intval(Dapper_Http_Request::getParam('author_id', false));
$budget_id = intval(Dapper_Http_Request::getParam('budget_id', false));
$pic = Dapper_Http_Request::getParam('pic', '');
$design_price = intval(Dapper_Http_Request::getParam('design_price'), false);
$matl_price = intval(Dapper_Http_Request::getParam('matl_price'), false);
$cons_price = intval(Dapper_Http_Request::getParam('cons_price'), false);

$value = array(
'house_type_id' => $house_type_id,
'author_id' => $author_id,
'budget_id' => $budget_id,
'pic' => $pic,
'design_price' => $design_price,
'matl_price' => $matl_price,
'cons_price' => $cons_price
);

$ret = $designCtrl->addDesignInfo($value);

//            $tplData['errorCode'] = $ret ? SUCCESS : FAILED;
if($ret === false){
$tplData['errorCode'] = FAILED;
}else{
$tplData['errorCode'] = SUCCESS;

// 更新户型图下关联的设计方案数量
$houseCtrl = LibFactory::getInstance('LibHouse');
$houseCtrl->addDesignNum($house_type_id);
}


}else {
$tplData = array(
'errorCode' => FAILED,
'msg' => '参数错误',
);
}


$this->echo_json($tplData);
*/

?>
