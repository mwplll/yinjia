<?php


/**
 * Class editHouseApiAction
 * 编辑户型图
 * 添加户型图，同时设置每个房间的 room_id, 大小
 *
 */
class editHouseInfoApiAction extends baseAction {
    public function execute(){
        $action = Dapper_Http_Request::getParam('act');

        switch($action){
            case "add":
                $this->add();
                break;
            case "update":
                $this->update();
                break;
            case "enable":
                $this->enable();
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


        $data['house_typename'] = Dapper_Http_Request::getParam('name');
        $data['building_id'] = Dapper_Http_Request::getParam('building_id');
//        $data['city_id'] = Dapper_Http_Request::getParam('city_id');
        $data['usable_area'] = Dapper_Http_Request::getParam('usable_area');
        $data['gross_area'] = Dapper_Http_Request::getParam('gross_area');
        $data['pic'] = Dapper_Http_Request::getParam('pic');

        $arr_room_name = Dapper_Http_Request::getParam('room_name');

        if(!$data['house_typename'] || !$data['building_id'] || !$data['pic']){
            return $this->api_error(PARAM_ERROR, "请传入户型名，关联的楼盘地址 id，户型图地址");
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
        $tplData["data"] = $data;
        return $this->echo_json($tplData);
    }

    /**
     * 更新户型图
     * @return bool
     */
    public function update(){

        //1.更新户型信息总表的信息
        $data = array();
        $houseTypeId = Dapper_Http_Request::getParam('house_id');
        $data['house_typename'] = Dapper_Http_Request::getParam('name');
        $data['building_id'] = Dapper_Http_Request::getParam('building_id');
        $data['usable_area'] = Dapper_Http_Request::getParam('usable_area');   //套内面积
        $data['gross_area'] = Dapper_Http_Request::getParam('gross_area');    //建筑面积
        $data['pic'] = Dapper_Http_Request::getParam('pic');

        if(!$data['house_typename'] || !$data['building_id'] || !$data['pic'] || !$data['usable_area'] || !$data['gross_area'] || !$houseTypeId){
            return $this->api_error(PARAM_ERROR, "please provide house_id,name,building_id,usable_area,gross_area,pic");
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
    public function enable(){
        $data = array();

        $houseTypeId = Dapper_Http_Request::getParam('house_id');
        if(!$houseTypeId){
            return $this->api_error(PARAM_ERROR,'please provide house_id!');
        }
        //echo '$houseTypeId = '.$houseTypeId;
        //更新的户型信息字段
        $data['is_enable'] = intval(Dapper_Http_Request::getParam('enable_id',1));

        //如果是删除户型，先判断该户型下是否有有效的设计方案
        $designObj = new LibDesign();
        $designSchemaList = $designObj->searchDesignByHouseTypeId($houseTypeId,0,3,0);
        if($designSchemaList){
            return $this->api_error(CANNOT_DELETE,'该户型还有正在展示中的设计方案，请误删除！');
        }

        //print_r($data);

        $houseObj = new LibHouse();
        $res = $houseObj->updateHouse($data,$houseTypeId);

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }

    }

}
