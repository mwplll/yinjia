<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-21
 * Time: 下午8:53
 */
class DBProvider
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
     * 新增供应商
     * @param array $value
     * @return mixed
     */
    public function addProvider($value = array())
    {
        $tbname = 'wm_provider';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        return $ret;
    }

    /**
     * 根据id获得供应商信息
     * @param $providerId
     * @return mixed
     */
    public function getProviderById($providerId){
        $sql = "SELECT * FROM wm_provider WHERE wm_provider.provider_id = $providerId";

        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 更新供应商
     * @param $updateInfo
     * @param $providerId
     * @return mixed
     */
    public function updateProvider($updateInfo,$providerId)
    {
        $wh = array('provider_id' => $providerId);
        $tb_name = 'wm_provider';
        $sql = $this->db->makeUpdateSQL($tb_name, $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }


    /**
     * 供应商列表
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getProviderList($start,$num){
        $tbname = 'wm_provider';
        $sql = "SELECT * FROM $tbname where is_del = 0
                LIMIT $start,$num";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * 获得供应商总个数
     * @return mixed
     */
    public function getProviderCount(){
        $tbname = 'wm_provider';
        $sql = "SELECT count(*) as num FROM $tbname where is_del = 0";

        $result = $this->db->queryFirstRow($sql);
        return $result['num'];
    }

    /**
     * 批量删除供应商
     * @param $ids
     * @return mixed
     */
    public function delProvidersByIds($ids){
        $tbname = 'wm_provider';
        $sql = "UPDATE {$tbname} SET `is_del` = 1 WHERE provider_id in $ids";
        return $this->db->doQuery($sql);
    }


}