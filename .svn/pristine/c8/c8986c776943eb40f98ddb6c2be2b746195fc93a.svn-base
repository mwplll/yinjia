<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-21
 * Time: 下午8:57
 */
class LibProvider{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 供应商列表
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getProviderList($start,$num){
        $dal = new DBProvider();
        return $dal->getProviderList($start,$num);
    }

    /**
     * 供应商总个数
     * @return mixed
     */
    public function getProviderCount(){
        $dal = new DBProvider();
        return $dal->getProviderCount();
    }

    /**
     * 新增供应商
     * @param array $value
     * @return bool
     */
    public function addProvider($value=array()){
        if(!$value){
            return false;
        }

        $dal = new DBProvider();
        $result = $dal->addProvider($value);
        return $result;
    }

    /**
     * 获取供应商信息
     * @param $providerId
     * @return bool|mixed
     */
    public function getProviderById($providerId){
        if(!$this->isId($providerId)){
            return false;
        }
        $dal = new DBProvider();
        return $dal->getProviderById($providerId);
    }

    /**
     * 更新供应商
     * @param array $value
     * @param $providerId
     * @return bool|mixed
     */
    public function updateProvider($value=array(),$providerId){
        if(!$value){
            return false;
        }

        if(!$this->isId($providerId)){
            return false;
        }
        $dal = new DBProvider();
        return $dal->updateProvider($value,$providerId);
    }

    /**
     * 批量删除供应商
     * @param $ids
     * @return mixed
     */
    public function delProvidersByIds($ids){
        $dal = new DBProvider();
        return $dal->delProvidersByIds($ids);
    }


}