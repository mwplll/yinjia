<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-19
 * Time: 下午11:31
 */
class DBBrand
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
     * 新增品牌
     * @param array $value
     * @return mixed
     */
    public function addBrand($value = array())
    {
        $tbname = 'wm_brand';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 根据id获得品牌信息
     * @param $brandId
     * @return mixed
     */
    public function getBrandById($brandId){
        $sql = "SELECT * FROM wm_brand WHERE wm_brand.brand_id = $brandId";

        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 更新品牌
     * @param $updateInfo
     * @param $brandId
     * @return mixed
     */
    public function updateBrand($updateInfo,$brandId)
    {
        $wh = array('brand_id' => $brandId);
        $tb_name = 'wm_brand';
        $sql = $this->db->makeUpdateSQL($tb_name, $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }


    /**
     * 品牌列表
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getBrandList($start,$num){
        $tbname = 'wm_brand';
        $sql = "SELECT * FROM $tbname where is_del = 0
                ORDER BY brand_sort ASC
                LIMIT $start,$num";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * 获得品牌总个数
     * @return mixed
     */
    public function getBrandCount(){
        $tbname = 'wm_brand';
        $sql = "SELECT count(*) as num FROM $tbname where is_del = 0";

        $result = $this->db->queryFirstRow($sql);
        return $result['num'];
    }


}