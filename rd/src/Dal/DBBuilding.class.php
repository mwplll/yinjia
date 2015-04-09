<?php

class DBBuilding
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    /**
     * 增加楼盘下的设计方案数量
     * @param $building_id
     * @param int $num
     * @return mixed
     */
    public function addDesignNum($building_id, $num=1)
    {
        $tbname = 'wm_building';

        $sql = "UPDATE {$tbname} SET total_design_num = total_design_num + $num WHERE building_id = {$building_id}";

        $res = $this->db->doQuery($sql);

        return $res;

    }

    /**
     * 获取一定$wh条件下的楼盘列表
     * @param array $wh
     * @param int $start
     * @param int $num
     * @return mixed
     */
    public function getBuildingList($start=0,$num=15,$wh=array()){
        //echo '$wh[]='.$wh['city_id'];
        $city_id = isset($wh['city_id']) ? " AND wm_building.city_id = " . $wh['city_id'] . " " : " ";
        $recommend = isset($wh['building_recommend']) ? " AND wm_building.building_recommend = " . $wh['building_recommend'] . " " : " ";
        $area_id = (isset($wh['area_id']) && ($wh['area_id'] != NULL))? " AND wm_building.area_id = " . $wh['area_id'] . " " : " ";
        $sql = "SELECT * FROM wm_building,wm_city,wm_company,wm_area
                WHERE wm_building.city_id = wm_city.city_id
                AND wm_building.company_id = wm_company.company_id
                AND wm_building.area_id = wm_area.area_id
                AND wm_building.building_del = 0 $city_id $area_id $recommend
                ORDER BY wm_building.building_id DESC, wm_building.total_design_num DESC
                LIMIT $start,$num";
        //echo '$sql = '.$sql;

        $res = $this->db->queryAllRows($sql);
        return $res;

    }

    /**
     * 获取满足wh条件的楼盘数量
     * @param array $wh
     * @return mixed
     */
    public function getBuildingCount($wh=array()){
        $city_id = isset($wh['city_id']) ? " AND wm_building.city_id = " . $wh['city_id'] . " " : " ";
        $recommend = isset($wh['building_recommend']) ? " AND wm_building.building_recommend = " . $wh['building_recommend'] . " " : " ";
        $area_id = (isset($wh['area_id']) && ($wh['area_id'] != NULL))? " AND wm_building.area_id = " . $wh['area_id'] . " " : " ";
        $sql = "SELECT count(*) as num FROM wm_building,wm_city,wm_company,wm_area
                WHERE wm_building.city_id = wm_city.city_id
                AND wm_building.company_id = wm_company.company_id
                AND wm_building.area_id = wm_area.area_id
                AND wm_building.building_del = 0 $city_id $area_id $recommend
                ";
        //echo '$sql = '.$sql."\n";
        $result = $this->db->queryFirstRow($sql);
        return $result['num'];

    }

    /**
     * 根据Id获得楼盘信息
     * @param $buildId
     * @return mixed
     */
    public function getBuildingById($buildId){
        $sql = "SELECT * FROM wm_building,wm_city,wm_company,wm_area
                WHERE wm_building.building_id = $buildId
                AND wm_building.city_id = wm_city.city_id
                AND wm_building.area_id = wm_area.area_id
                AND wm_building.company_id = wm_company.company_id";
        //echo '$sql = '.$sql;
        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 更新楼盘信息
     * @param $value
     * @param $buildId
     * @return mixed
     */
    public function updateBuilding($value,$buildId){
        $wh = array('building_id' => $buildId);
        $tb_name = 'wm_building';
        $sql = $this->db->makeUpdateSQL($tb_name, $value,$wh);
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
        //echo 'sql return = '.$this->db->doQuery($sql)."\n";
    }

    /**
     * 删除楼盘
     * @param $buildId
     * @return mixed
     */
    /*public function deleteBuilding($buildId){
        $tb_name = 'wm_building';
        $sql = "DELETE FROM $tb_name WHERE building_id = $buildId";
        return $this->db->doQuery($sql);
    }*/

    /**
     * 增加楼盘
     * @param $value
     * @return mixed
     */
    public function addBuilding($value){
        $tbname = 'wm_building';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

}

?>
