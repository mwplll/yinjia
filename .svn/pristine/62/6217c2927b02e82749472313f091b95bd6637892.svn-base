<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午3:52
 */
class DBDesignSchema
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    public function __destruct()
    {
        $this->db = null;
    }

    /**
     * 根据id获得设计方案基础信息
     * @param $designId
     * @return mixed
     */
    public function getDesignBaseInfoById($designId)
    {
        $tbName = 'wm_design_schema';

        $sql = "SELECT * FROM {$tbName} WHERE design_schema_id = {$designId}";
        $ret = $this->db->queryFirstRow($sql);
        return $ret;
    }

    /**
     * 添加设计方案
     * @param array $value
     * @return mixed
     */
    public function addDesignSchema($value = array())
    {
        $tbname = 'wm_design_schema';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 根据id更新设计方案
     * @param $designId
     * @param array $value
     * @return mixed
     */
    public function updateDesignSchema($designId,$value = array())
    {
        $tbname = 'wm_design_schema';
        $wh = array('design_schema_id' => $designId);

        $sql = $this->db->makeUpdateSQL($tbname, $value,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 设计方案列表
     * @param $start
     * @param $num
     * @param array $wh
     * @param array $order
     * @return mixed
     */
    public function getDesignSchemaList($start,$num,$wh=array(),$order=array()){
        //$state = isset($wh['design_schema_del']) ? " AND wm_design_schema.design_schema_del = " . $wh['design_schema_del'] . " " : " AND wm_design_schema.design_schema_del <> 1 ";  //设计方案状态
        $houseType = isset($wh['house_type_id']) ? " AND wm_design_schema.house_type_id = " . $wh['house_type_id'] . " " : " ";  //户型id
        $designer = isset($wh['user_id']) ? " AND wm_design_schema.user_id = " . $wh['user_id'] . " " : " ";  //设计师用户id
        $keywords = isset($wh['keywords']) ? " AND wm_design_schema.design_name LIKE  '%".$wh['keywords']."%' " : " ";  //设计方案名称关键字搜索
        $city = isset($wh['city_id']) ? " AND wm_city.city_id = " . $wh['city_id'] . " " : " ";
        $area = (isset($wh['area_id']) && ($wh['area_id'] != NULL))? " AND wm_building.area_id = " . $wh['area_id'] . " " : " ";
        $building = isset($wh['building_id']) ? " AND wm_building.building_id = " . $wh['building_id'] . " " : " ";
        $recommend = isset($wh['design_schema_recommend']) ? " AND wm_design_schema.design_schema_recommend in " . $wh['design_schema_recommend'] . " " : " ";
        $isDel = isset($wh['design_schema_del']) ? " AND wm_design_schema.design_schema_del in " . $wh['design_schema_del'] . " " : " ";
        $sort = " wm_design_schema.".$order['sort'];
        $turn = $order['turn'] ? "DESC" : "ASC";
        $sql = "SELECT * FROM wm_design_schema,wm_user,wm_building,wm_city,wm_area,wm_house_type
                WHERE wm_design_schema.user_id = wm_user.user_id
                AND wm_design_schema.house_type_id = wm_house_type.house_type_id
                AND wm_house_type.building_id = wm_building.building_id
                AND wm_building.city_id = wm_city.city_id
                AND wm_building.area_id = wm_area.area_id
                $designer $keywords $houseType $city $area $building $isDel $recommend
                ORDER BY  $sort $turn
                LIMIT $start,$num";
        //echo '$sql = '.$sql."\n";
        $res = $this->db->queryAllRows($sql);
        //print_r($res);
        return $res;
    }

    /**
     * 符合条件的设计方案个数
     * @param array $wh
     * @return mixed
     */
    public function getDesignSchemaCount($wh=array()){
        //$state = isset($wh['design_schema_del']) ? "  wm_design_schema.design_schema_del = " . $wh['design_schema_del'] . " " : "  wm_design_schema.design_schema_del <> 1 ";  //设计方案状态
        $houseType = isset($wh['house_type_id']) ? " AND wm_design_schema.house_type_id = " . $wh['house_type_id'] . " " : " ";  //户型id
        $designer = isset($wh['user_id']) ? " AND wm_design_schema.user_id = " . $wh['user_id'] . " " : " ";  //设计师id
        $keywords = isset($wh['keywords']) ? " AND wm_design_schema.design_name LIKE  '%".$wh['keywords']."%' " : " ";  //设计方案名称关键字搜索
        $city = isset($wh['city_id']) ? " AND wm_city.city_id = " . $wh['city_id'] . " " : " ";
        $area = (isset($wh['area_id']) && ($wh['area_id'] != NULL))? " AND wm_building.area_id = " . $wh['area_id'] . " " : " ";
        $building = isset($wh['building_id']) ? " AND wm_building.building_id = " . $wh['building_id'] . " " : " ";
        $recommend = isset($wh['design_schema_recommend']) ? " AND wm_design_schema.design_schema_recommend in " . $wh['design_schema_recommend'] . " " : " ";
        $isDel = isset($wh['design_schema_del']) ? " AND wm_design_schema.design_schema_del in " . $wh['design_schema_del'] . " " : " ";

        $sql = "SELECT count(*) as num FROM wm_design_schema,wm_user,wm_building,wm_city,wm_area,wm_house_type
                WHERE wm_design_schema.user_id = wm_user.user_id
                AND wm_design_schema.house_type_id = wm_house_type.house_type_id
                AND wm_house_type.building_id = wm_building.building_id
                AND wm_building.city_id = wm_city.city_id
                AND wm_building.area_id = wm_area.area_id
                $designer $keywords $houseType $city $area $building $isDel $recommend
                ";
        //echo '$sql = '.$sql."\n";
        $res = $this->db->queryFirstRow($sql);
        //print_r($res);
        return $res['num'];

    }

    /**
     * 添加评论数
     * @param $id
     * @param int $num
     * @return mixed
     */
    public function addCommentNum($id, $num = 1){
        $tbName = 'wm_design_schema';

        $sql = "UPDATE {$tbName} SET comment_num = comment_num + $num WHERE design_schema_id = {$id}";
        $res = $this->db->doQuery($sql);
        return $res;
    }

    /**
     * 添加浏览数
     * @param $id
     * @param int $num
     * @return mixed
     */
    public function addViewNum($id, $num = 1){
        $tbName = 'wm_design_schema';

        $sql = "UPDATE {$tbName} SET view_num = view_num + $num WHERE design_schema_id = {$id}";
        $res = $this->db->doQuery($sql);
        return $res;
    }

    /**
     * 添加喜欢数
     * @param $id
     * @param int $num
     * @return mixed
     */
    public function addLikeNum($id, $num = 1){
        $tbName = 'wm_design_schema';

        $sql = "UPDATE {$tbName} SET like_num = like_num + $num WHERE design_schema_id = {$id}";
        $res = $this->db->doQuery($sql);
        return $res;
    }

    /**
     * 根据传入的设计id数组,查询设计信息
     * @param $design_ids
     * @return mixed
     */
    public function getDesignInfoByIds($design_ids)
    {
        $values = implode(',', $design_ids);
        $tbName = 'wm_design_schema';

        $sql = "SELECT * FROM wm_user INNER JOIN {$tbName} WHERE design_schema_id IN ($values) AND wm_design_schema.user_id = wm_user.user_id";
        //echo '$sql = '.$sql."\n";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

    /**
     * 获得该设计师用户当前的设计方案最大编号
     * @param $userId
     * @return mixed
     */
    public function getMaxDesignSn($userId){
        $sql = "SELECT max(design_sn) AS maxDesignSn FROM wm_design_schema WHERE user_id = $userId";
        $result = $this->db->queryFirstRow($sql);
        return $result['maxDesignSn'];
    }




}