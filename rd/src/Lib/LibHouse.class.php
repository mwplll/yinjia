<?php
class LibHouse
{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 查询满足条件的户型列表
     * @param int $start
     * @param int $num
     * @param array $wh
     * @return mixed
     */
    public function getHouseList($start=0,$num=15,$wh=array()){
        $dal = new DBHouse();
        return $dal->getHouseList($start,$num,$wh);
    }

    /**
     * 查找满足条件的户型个数
     * @param array $wh
     * @return mixed
     */
    public function getHouseCount($wh=array()){
        $dal = new DBHouse();
        return $dal->getHouseCount($wh);
    }
    /**
     * 添加户型记录
     * @param $houseInfo
     * @return mixed
     */
    public function addHouse($houseInfo){
        $dal = new DBHouse();
        return $dal->addHouse($houseInfo);
    }

    /**
     * 根据id更新户型信息
     * @param array $value
     * @param $houseTypeId
     * @return bool
     */
    public function updateHouse($value=array(),$houseTypeId){
        if(!$value){
            return FALSE;
        }
        $dal = new DBHouse();
        return $dal->updateHouse($value,$houseTypeId);
    }


    /**
     *根据id查询户型信息
     * @param $house_id
     * @return mixed
     */
    public function getHouseById($house_id){
        $dal = new DBHouse();
        return $dal->getHouseById($house_id);
    }

    public function addRooms($rooms){
        $dal = DBFactory::getInstance('DBHouse');
        return $dal->addRooms($rooms);
    }

    public function addRoom($room){
        $dal = DBFactory::getInstance('DBHouse');
        return $dal->addRoom($room);
    }

    public function updateRoom($value=array(),$roomId){
        if(!$value){
            return FALSE;
        }

        if(!$this->isId($roomId)){
            return FALSE;
        }
        $dal = DBFactory::getInstance('DBHouse');
        return $dal->updateRoom($value,$roomId);
    }

    /**
     * 根据房间id删除房间
     * @param $roomId
     * @return mixed
     */
    public function deleteRoomById($roomId){
        $dal = DBFactory::getInstance('DBHouse');
        return $dal->deleteRoomById($roomId);
    }


    /**
     * 根据户型 id 查询户型信息及每个房间信息
     * @param $house_id
     */
    public function getRoomsByHouseId($house_id){
        if(!$this->isId($house_id)){
            return FALSE;
        }
        $dal = DBFactory::getInstance('DBHouse');
        return $dal->getRoomsByHouseId($house_id);
    }


    /**
     * 增加某个户型图下关联的设计图数量，同时更新所属楼盘下的设计图数量
     * @param $house_id
     * @param int $num
     * @return mixed
     */
    public function addDesignNum($house_id,$num=1)
    {
        if(!$this->isId($house_id))
        {
            return false;
        }

        $db = new DBHouse();
        $result = $db->addDesignNum($house_id, $num);


        // 更新所属楼盘的 total_design_num
        $houseInfo = $db->getHouseById($house_id);
        if($houseInfo){
            $buId = intval($houseInfo['building_id']);
            $buDal = new DBBuilding();
            $buDal->addDesignNum($buId,$num);
        }

        return $result;
    }

    /**
     * 根据户型 ID 查找户型图信息
     * @param $house_type_id
     * @return mixed
     */
    public function searchDesignByHouseId($house_type_id)
    {
        if(!$this->isId($house_type_id))
        {
            return false;
        }

        $dal = DBFactory::getInstance('DBDesign');
        $result = $dal->getHousetypeInfoByHousetypeID($house_type_id);

        return $result;

    }

    /**
     * 根据户型 ID 查找户型图信息
     * @param $house_type_id
     * @return mixed
     */
    public function getHouseTypeInfoByHouseTypeID($house_type_id)
    {
        if(!$this->isId($house_type_id))
        {
            return false;
        }

        $dal = DBFactory::getInstance('DBHouse');
        $result = $dal->getHouseTypeInfoByHouseTypeID($house_type_id);

        return $result;

    }

    /**根据城市ID搜索该城市的楼盘列表
     * @param $city_id
     * @return bool
     */
    public function getBuildingListByCityId($city_id)
    {
        if(!$this->isId($city_id))
        {
            return false;
        }

        $dal = DBFactory::getInstance('DBHouse');
        $result = $dal->getBuildingListByCityId($city_id);

        return $result;

    }

    /**根据楼盘ID搜索该楼盘的户型
     * @param $building_id
     * @return bool
     */
    public function getHouseTypeListByBuildingId($buildingId)
    {
        if(!$this->isId($buildingId))
        {
            return false;
        }

        $dal = DBFactory::getInstance('DBHouse');
        $result = $dal->getHouseTypeListByBuildingId($buildingId);

        return $result;

    }




}
