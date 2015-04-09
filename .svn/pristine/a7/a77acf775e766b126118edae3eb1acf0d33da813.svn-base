<?php
/**
 * 创建设计图 API
 */


class editDesignApiAction extends baseAction
{
    public function execute()
    {
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "add":
                $this->add();
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
     * 检查一个户型下的全部房间图是否被全部提供了
     */
    private function _checkDesignRoom($house_id, $design_rooms){
        $houseObj = LibFactory::getInstance('LibHouse');
        $rooms = $houseObj->getRoomsByHouseId($house_id);

        $needIds = array();
        foreach ($rooms as $v){
            array_push($needIds, $v['room_id']);
        }

        $curIds = array();
        foreach ($design_rooms as $v){
            array_push($curIds, $v['room_id']);
        }


        return count($needIds) == count($curIds) && count(array_diff($needIds, $curIds)) == 0;
    }
    /**
     * 添加设计方案
     */
    public function add(){
//        echo json_encode($this->loginInfo());
        $data = array();
        $this->checkLogin();

        // TODO  验证是否为设计师
        /*if(!$this->loginUid){
            return $this->api_error(USER_UNLOGIN ,"not login");
        }*/
        $userId = $this->loginUid;
        $designerObj = new LibDesigner();
        $designerInfo = $designerObj->getDesignerByUid($userId);
        $designerId = $designerInfo['designer_id'];
        $data['designer_id'] = $designerId;

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
        $houseObj = LibFactory::getInstance('LibHouse');
        $houseInfo = $houseObj->getHouseById($data['house_type_id']);
        if(!$houseInfo){
            return $this->api_error(PARAM_ERROR, 'house_type_id not valid!');
        }

        // 数据库中 house 下的 room 是否和传入的 design_room 相匹配 测试是否同步到服务器
        // TODO 调试时去除，用于检测提交的设计图是否和需要的一致
//        if(!$this->_checkDesignRoom($data['house_type_id'], $designRooms)){
//            return $this->api_error(PARAM_ERROR, 'provided design rooms doesn\'t match related rooms');
//        }

        // 满足条件，创建设计方案
        $designObj = new LibDesign();
        $designId = $designObj->addDesignInfo($data);


        if(!$designId){
            return $this->api_error(FAILED, 'create new design schema failed!');
        }
        $data['design_schema_id'] = $designId;

        foreach($designRooms as &$room){
            $room['design_schema_id'] = $designId;
        }

        $designRoomObj = new LibDesignRoom();
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
