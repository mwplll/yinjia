<?php
/**
 * dal数据访问层
 *
 * 用户数据操作类(示例)
 * @package		User
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 */

class DBHouse
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    /**
     * 添加一个户型
     * @param $value
     * @return bool
     */
    public function addHouse($value){
        $tbName = 'wm_house_type';
        $sql = $this->db->makeInsertSQL($tbName, $value);
        $res = false;
        if($sql){
            $res = $this->db->doQuery($sql);
        }
        if($res){
            $res = $this->db->getLastInsertID();
        }else{
            Dapper_Log::fatal($this->db->getErrMsg(), 'dal');
        }

        return $res;
    }

    /**
     * 更新户型信息表
     * @param $value
     * @param $houseTypeId
     * @return mixed
     */
    public function updateHouse($value,$houseTypeId)
    {
        $wh = array('house_type_id' => $houseTypeId);
        $tb_name = 'wm_house_type';
        $sql = $this->db->makeUpdateSQL($tb_name, $value,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 更新单个房间信息
     * @param $value
     * @param $roomId
     * @return mixed
     */
    public function updateRoom($value,$roomId)
    {
        $wh = array('room_id' => $roomId);
        $tb_name = 'wm_room';
        $sql = $this->db->makeUpdateSQL($tb_name, $value,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 添加房间
     * @param array $value
     * @return mixed
     */
    public function addRoom($value = array())
    {
        $tbname = 'wm_room';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        return $ret;
    }

    /**
     * 根据id查询户型信息
     * @param $house_id
     * @return mixed
     */
    public function getHouseById($house_id){
        $sql = "SELECT * FROM wm_house_type,wm_building,wm_area,wm_city,wm_company WHERE wm_house_type.building_id = wm_building.building_id
                AND wm_house_type.house_type_id = {$house_id}
                AND wm_building.area_id = wm_area.area_id
                AND wm_building.city_id = wm_city.city_id
                AND wm_building.company_id = wm_company.company_id";
        //$sql = "SELECT * FROM wm_house_type,wm_building WHERE house_type_id = $house_id";
        //echo '$sql = '.$sql."\n";
        return $this->db->queryFirstRow($sql);
    }


    public function getHouseList($start = 0,$num = 15 ,$wh=array())
    {
       // $where = 'WHERE ';
        $city = isset($wh['city_id']) ? " AND wm_city.city_id = " . $wh['city_id'] . " " : " ";
        $area = (isset($wh['area_id']) && ($wh['area_id'] != NULL))? " AND wm_building.area_id = " . $wh['area_id'] . " " : " ";
        $building = isset($wh['building_id']) ? " AND wm_building.building_id = " . $wh['building_id'] . " " : " ";
        $isDel = isset($wh['house_del']) ? " AND wm_house_type.house_del in " . $wh['house_del'] . " " : " ";
        //$keywords = isset($wh['keywords']) ? " AND ( wm_house_type.house_typename LIKE  '%".$wh['keywords']."%' " : " ";
        //$searchBuilding = isset($wh['keywords']) ? " OR wm_building.building_name LIKE  '%".$wh['keywords']."%' )" : " ";
        //$minarea = isset($wh['minarea']) ? " AND wm_house_type.gross_area >= " . $wh['minarea'] . " " : " ";
        //$maxarea = isset($wh['maxarea']) ? " AND wm_house_type.gross_area < " . $wh['maxarea'] . " " : " ";

        $sql = "SELECT * FROM wm_house_type ,wm_building ,wm_city,wm_area,wm_company WHERE
            wm_house_type.building_id = wm_building.building_id
            AND wm_building.city_id = wm_city.city_id
            AND wm_building.area_id = wm_area.area_id
            AND wm_building.company_id = wm_company.company_id $city $area $isDel $building
            ORDER BY wm_house_type.design_num DESC
            limit $start , $num ";
        //echo '$sql = '.$sql;
        $result = $this->db->queryAllRows($sql);
        /*if(!$result){
            Dapper_Log::warning($sql, 'dal');
        }*/
        return $result;
    }

    public function getHouseCount($wh=array()){
        // $where = 'WHERE ';
        $city = isset($wh['city_id']) ? " AND wm_city.city_id = " . $wh['city_id'] . " " : " ";
        $area = (isset($wh['area_id']) && ($wh['area_id'] != NULL))? " AND wm_building.area_id = " . $wh['area_id'] . " " : " ";
        $building = isset($wh['building_id']) ? " AND wm_building.building_id = " . $wh['building_id'] . " " : " ";
        $isDel = isset($wh['house_del']) ? " AND wm_house_type.house_del in " . $wh['house_del'] . " " : " ";
        //$keywords = isset($wh['keywords']) ? " AND ( wm_house_type.house_typename LIKE  '%".$wh['keywords']."%' " : " ";
        //$searchBuilding = isset($wh['keywords']) ? " OR wm_building.building_name LIKE  '%".$wh['keywords']."%' )" : " ";
        //$minarea = isset($wh['minarea']) ? " AND wm_house_type.gross_area >= " . $wh['minarea'] . " " : " ";
        //$maxarea = isset($wh['maxarea']) ? " AND wm_house_type.gross_area < " . $wh['maxarea'] . " " : " ";

        $sql = "SELECT count(*) as num
            FROM wm_house_type ,wm_building ,wm_city,wm_area,wm_company WHERE
            wm_house_type.building_id = wm_building.building_id
            AND wm_building.city_id = wm_city.city_id
            AND wm_building.area_id = wm_area.area_id
            AND wm_building.company_id = wm_company.company_id $city $area $isDel $building";
        $result = $this->db->queryFirstRow($sql);
        return $result['num'];
    }

    public function addRooms($rooms){
        $sql = $this->db->makeMutiInsertSQL('wm_room', $rooms);
        if($sql){
            $res = $this->db->doQuery($sql);
        }
        if($res){
            $res = $this->db->getLastInsertID();
        }
        return $res;
    }

    /**
     * 根据房间id删除房间信息行
     * @param $roomId
     * @return mixed
     */
    public function deleteRoomById($roomId){
        $tb_name = 'wm_room';
        $sql = "DELETE FROM $tb_name WHERE room_id = $roomId";
        return $this->db->doQuery($sql);
    }

    /**
     * 查询户型图下关联的房间图
     * @param $house_id
     */
    public function getRoomsByHouseId($house_id){
        $sql = "SELECT room_id, room_name, room_area FROM wm_room WHERE house_type_id = $house_id";

        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * 根据户型ID提取户型列表
     * @param int $housetypeID
     * @return mixed
     */
    public function getHouseTypeInfoByHouseTypeID($housetypeID)
    {
        $sql = "SELECT * FROM wm_house_type,wm_building,wm_city WHERE
            wm_house_type.building_id = wm_building.building_id AND wm_building.city_id = wm_city.city_id
            AND wm_house_type.house_type_id = $housetypeID
             ";

        $result = $this->db->queryFirstRow($sql);
        if(!$result){
            Dapper_Log::fatal($this->db->getErrMsg(), 'dal');
        }
        return $result;
    }

    /**
     * 条件查询的示范API，参考 $wh 的设计
     * @param $type
     * @param $id
     * @param int $page
     * @param int $size
     * @param array $wh
     * @param bool $isGroup
     * @return mixed
     */
    public function getEventBySubjectId($type, $id, $page = 0, $size = 6, $wh = array(), $isGroup = false)
    {
        $start = $page * $size;
        $status = isset($wh['status']) ? "AND status in (" . $wh["status"] . ") " : "AND status in ({$this->status}) ";
        $charge = isset($wh['charge']) ? " AND charge_type=" . $wh['charge'] . " " : " ";
        $expire = isset($wh['expire']) ? " AND expire_status=" . $wh['expire'] . " " : " ";

        $group = $isGroup ? " GROUP BY tour_key " : "";

        $sql = "SELECT * FROM event_info WHERE subject_id = $id AND is_display = 1 AND subject_type=$type $status $charge $expire $group ORDER BY event_id DESC LIMIT {$start},{$size}";
        $is_display = isset($wh['is_display']) ? $wh['is_display'] : 1;
        if (strcasecmp($is_display, 'all') && in_array($is_display, array(1, 0))) {
            $sql = "SELECT * FROM event_info WHERE subject_id = $id AND is_display = $is_display AND subject_type=$type $status $charge $expire $group ORDER BY event_id DESC LIMIT {$start},{$size}";
        } else {
            $sql = "SELECT * FROM event_info WHERE subject_id = $id AND subject_type=$type $status $charge $expire $group ORDER BY event_id DESC LIMIT {$start},{$size}";
        }

        $result = $this->db->queryAllRows($sql);
        return $result;
    }

    /**
     * 增加户型图下关联的设计方案
     * @param int $num
     */
    public function addDesignNum($house_type_id, $num = 1){
        $tbname = 'wm_house_type';

        $sql = "UPDATE {$tbname} SET design_num = design_num + $num WHERE house_type_id = {$house_type_id}";

        $res = $this->db->doQuery($sql);

        return $res;
    }


    public function getBuildingListByCityId($cityId){

        $tbname = 'wm_building';

        $sql = "SELECT * FROM  {$tbname}  WHERE city_id = {$cityId}";

        $result = $this->db->queryAllRows($sql);

        return $result;
    }

    public function getHouseTypeListByBuildingId($buildingId){

        $tbname = 'wm_house_type';

        $sql = "SELECT * FROM  {$tbname}  WHERE building_id = {$buildingId}";
        //echo '$sql = '.$sql;

        $result = $this->db->queryAllRows($sql);

        return $result;
    }

}

?>
