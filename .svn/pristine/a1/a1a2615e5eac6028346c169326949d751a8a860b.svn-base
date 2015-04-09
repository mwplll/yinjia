<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-13
 * Time: 上午12:09
 */
class DBCompany
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }


    /**
     * 更新房地产开发商信息
     * @param array $value
     * @param $companyId
     * @return mixed
     */
    public function updateComapny($value=array(),$companyId){
        $wh = array('company_id' => $companyId);
        $tb_name = 'wm_company';
        $sql = $this->db->makeUpdateSQL($tb_name, $value,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 添加房地产开发商
     * @param $value
     * @return mixed
     */
    public function addCompany($value){
        $tbname = 'wm_company';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 根据公司名字查询公司
     * @param $companyName
     * @return mixed
     */
    public function getCompanyByName($companyName){
        $sql = "SELECT * FROM wm_company
                WHERE wm_company.company_name = '$companyName'";
        //echo '$sql = '.$sql;

        $result = $this->db->queryFirstRow($sql);
        //echo '$result = '.$result;
        return $result;
    }


}
