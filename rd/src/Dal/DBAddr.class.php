<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-5
 * Time: 下午10:55
 */

class DBAddr
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    /**
     * 获取用户的收件地址列表
     * @param $userId
     * @return mixed
     */
    public function getAddrListByUserId($userId){
        $sql = "SELECT * FROM wm_addr WHERE wm_addr.user_id = $userId AND wm_addr.addr_del = 0";

        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    public function addAddr($value = array())
    {
        $tbname = 'wm_addr';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        return $ret;
    }

    public function getAddrByAddrId($addrId){
        $sql = "SELECT * FROM wm_addr WHERE wm_addr.addr_id = $addrId";

        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 根据地址Id更新相应的地址
     * @param $updateInfo
     * @param $addrId
     * @return mixed
     */
    public function updateAddr($addrId,$updateInfo=array())
    {
        $wh = array('addr_id' => $addrId);
        $tb_name = 'wm_addr';
        $sql = $this->db->makeUpdateSQL($tb_name, $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }

}


?>