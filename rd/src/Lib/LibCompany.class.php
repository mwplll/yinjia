<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-13
 * Time: 上午1:01
 */
class LibCompany{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 更新房地产开发商的信息
     * @param $value
     * @param $companyId
     * @return bool|mixed
     */
    public function updateCompany($value,$companyId){
        if(!$value){
            return FALSE;
        }
        if(!$this->isId($companyId)){
            return FALSE;
        }
        $dal = new DBCompany();
        return $dal->updateComapny($value,$companyId);
    }

    /**
     * 根据公司名字查询公司信息
     * @param $companyName
     * @return mixed
     */
    public function getCompanyByName($companyName){
        $db = new DBCompany();
        return $db->getCompanyByName($companyName);
    }

    /**
     * 添加房地产开发商
     * @param array $value
     * @return bool|mixed
     */
    public function addCompany($value=array()){
        if(!$value){
            return FALSE;
        }
        $db = new DBCompany();
        return $db->addCompany($value);
    }


}