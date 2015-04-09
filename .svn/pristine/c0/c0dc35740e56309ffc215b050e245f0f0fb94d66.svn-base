<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-8
 * Time: 下午1:13
 */
class DBCity
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
     * get city
     * @param $id
     * @return mixed
     */
    public function getCityById($id){
        $sql = "SELECT * FROM wm_city WHERE city_id = {$id}";
        $ret = $this->db->queryFirstRow($sql);
        return $ret;
    }
}