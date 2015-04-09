<?php


/**
 * Class editHouseApiAction
 * 编辑户型图
 * 添加户型图，同时设置每个房间的 room_id, 大小
 *
 */
class houseEditApiAction extends baseAction {
    public function execute(){
        $action = Dapper_Http_Request::getParam('act');

        switch($action){
            case "add":
                $this->add();
                break;
            case "update":
                $this->update();
                break;
            case "del":
                $this->del();
                break;
            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }

    }


    /**
     * 处理传入的 room_area 和 room_name 数组，拼装成 rooms 数组供创建 rooms
     * @return array
     */
    /*private function _gatherRooms($house_id){
        $arr_room_name = Dapper_Http_Request::getParam('room_name');
        $arr_room_area = Dapper_Http_Request::getParam('room_size');


        $rooms = array();

        foreach($arr_room_name as $i=>$v){
            array_push($rooms, array(
                "room_name" => $v,
                "room_area" => $arr_room_area[$i],
                "house_type_id" => $house_id
            ));
        }
        return $rooms;
    }*/

    /**
     * 对已存在的房间，更新房间信息；对新增的房间，则创建房间
     * @param $houseId
     * @return bool
     */
    /*private function _updateRooms($houseId){
        $arr_room_id = Dapper_Http_Request::getParam('room_id',NULL);
        $arr_room_name = Dapper_Http_Request::getParam('room_name');
        $arr_room_area = Dapper_Http_Request::getParam('room_size');

        //print_r($arr_room_area);

        $room = array();
        $houseObj = new LibHouse();

        $room_id_num = count($arr_room_id);
        if($room_id_num >= 1 ){
        foreach($arr_room_name as $i=>$v){
            $room['room_name'] = $v;
            $room['room_area'] = $arr_room_area[$i];
            $room['house_type_id'] = $houseId;
            //print_r($room);
            if($arr_room_id[$i]){
                $roomId = $arr_room_id[$i];
                $res = $houseObj->updateRoom($room,$roomId);
            }
            else{
                $res = $houseObj->addRoom($room);
            }

        }
        }
        return $res;
    }*/

    /**
     * 添加户型图
     */
    public function add(){
        $data = array();


        $data['house_type_name'] = Dapper_Http_Request::getParam('name');
        $data['building_id'] = Dapper_Http_Request::getParam('buildingId');
//        $data['city_id'] = Dapper_Http_Request::getParam('city_id');
        $data['usable_area'] = Dapper_Http_Request::getParam('usableArea');
        $data['gross_area'] = Dapper_Http_Request::getParam('grossArea');
        $data['pic'] = Dapper_Http_Request::getParam('pic');

        //$arr_room_name = Dapper_Http_Request::getParam('room_name');

        if(!$data['house_type_name'] || !$data['building_id'] || !$data['pic'] || !$data['usable_area'] || !$data['gross_area']){
            return $this->api_error(PARAM_ERROR, "Please provide the house type name,building id,pic,usable area,gross area!");
        }

        /*if(count($arr_room_name) < 1){
            return $this->api_error(PARAM_ERROR, "请传入户型关联的房间名和面积");
        }*/


        // 插入数据
        $houseObj = new LibHouse();
        $data['house_type_id'] = $houseObj->addHouse($data);
        if(!$data['house_type_id']){
            return $this->api_error(FAILED, "创建户型失败");
        }

        /*$data['house_type_id'] = $res;
        $rooms = $this->_gatherRooms($res);
        // 添加户型记录成功，添加房间记录
        $houseObj->addRooms($rooms);*/


        $tplData["errorCode"] = SUCCESS;
        $tplData["data"] = $data['house_type_id'];
        return $this->echo_json($tplData);
    }

    /**
     * 更新户型图
     * @return bool
     */
    public function update(){

        //1.更新户型信息总表的信息
        $data = array();
        $houseTypeId = Dapper_Http_Request::getParam('id');
        $data['house_type_name'] = Dapper_Http_Request::getParam('name');
        $data['building_id'] = Dapper_Http_Request::getParam('buildingId');
        $data['usable_area'] = Dapper_Http_Request::getParam('usableArea');   //套内面积
        $data['gross_area'] = Dapper_Http_Request::getParam('grossArea');    //建筑面积
        $data['pic'] = Dapper_Http_Request::getParam('pic');

        if(!$data['house_type_name'] || !$data['building_id'] || !$data['pic'] || !$data['usable_area'] || !$data['gross_area'] || !$houseTypeId){
            return $this->api_error(PARAM_ERROR, "please provide house id,name,buildingId,usableArea,grossArea,pic");
        }

        $houseObj = new LibHouse();
        $houseRes = $houseObj->updateHouse($data,$houseTypeId);

        //2.更新该户型关联的房间信息
        //$roomRes = $this->_updateRooms($houseTypeId);
        //$roomRes = 1;
        if(!$houseRes){
            return $this->api_error(FAILED);
        }else{
            return $this->api_success($houseRes);
        }

    }

    /**
     * 对户型进行假删除、控制是否在前台显示/不显示操作
     * @return bool
     */
    public function del(){
        $data = array();

        $houseTypeId = Dapper_Http_Request::getParam('id');
        if(!$houseTypeId){
            return $this->api_error(PARAM_ERROR,'please provide house id!');
        }
        //echo '$houseTypeId = '.$houseTypeId;
        //更新的户型信息字段
        $data['house_del'] = intval(Dapper_Http_Request::getParam('state',0));

        $houseObj = new LibHouse();
        //如果是删除户型，先判断该户型下是否有设计方案
        if($data['house_del'] == 1){
            $houseInfo = $houseObj->getHouseById($houseTypeId);
            if(!$houseInfo || (intval($houseInfo['design_num']) != 0)){
                return $this->api_error(CANNOT_DELETE,'The house is not exist or the house has design schemas,it can not be deleted!');
            }
        }

        //print_r($data);
        $res = $houseObj->updateHouse($data,$houseTypeId);

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }

    }

}
