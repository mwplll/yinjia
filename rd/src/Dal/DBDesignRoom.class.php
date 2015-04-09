<?php
/**
 * dal数据访问层
 *
 * 用户数据操作类(示例)
 * @package		User
 * @author		zhaoshunyao <zhaoshunyao@baidu.com>
 */

class DBDesignRoom
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    /**
     * 获得一个设计方案的所有房间列表
     * @param $designSchemaId
     * @return mixed
     */
    public function getDesignRoomListByDesignId($designSchemaId){
        $sql = "SELECT * FROM wm_design_room WHERE design_schema_id = {$designSchemaId} AND design_room_del = 0";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

    /**
     * 添加一个房间
     * @param $value
     * @return mixed
     */
    public function addDesignRoom($value){
        $tbName = 'wm_design_room';

        $ret = $this->db->makeInsertSQL($tbName,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 更新一个房间
     * @param $updateInfo
     * @param $roomId
     * @return mixed
     */
    public function updateDesignRoom($roomId,$updateInfo=array())
    {
        $wh = array('design_room_id' => $roomId);
        $tb_name = 'wm_design_room';
        $sql = $this->db->makeUpdateSQL($tb_name, $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }


    /**
     * 假删除该设计方案的所有房间
     * @param $designSchemaId
     * @return mixed
     */
    public function delDesignRoomsByDesignId($designSchemaId){
        $tb_name = 'wm_design_room';
        $sql = "UPDATE $tb_name SET design_room_del = 1 WHERE design_schema_id = $designSchemaId";
        return $this->db->doQuery($sql);
    }

}
