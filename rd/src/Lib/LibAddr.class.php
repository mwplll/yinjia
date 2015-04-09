<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-5
 * Time: 下午10:52
 */
class LibAddr{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    public function getAddrListByUserId($userId){
        $dal = new DBAddr();
        return $dal->getAddrListByUserId($userId);
    }

    /**
     * 新增收货地址
     * @param array $value
     * @return bool
     */
    public function addAddr($value=array()){
        if(!$value){
            return false;
        }

        $db = DBFactory::getInstance('DBAddr');
        $result = $db->addAddr($value);

        return $result;
    }


    /**
     * 根据地址id获取地址信息
     * @param $addrId
     * @return mixed
     */
    public function getAddrByAddrId($addrId){
        if(!$this->isId($addrId)){
            return false;
        }
        $dal = DBFactory::getInstance('DBAddr');
        return $dal->getAddrByAddrId($addrId);
    }

    /**
     * 更新收件地址
     * @param $addrId
     * @param array $value
     * @return bool|mixed
     */
    public function updateAddr($addrId,$value=array()){
        if(!$value){
            return false;
        }

        if(!$this->isId($addrId)){
            return false;
        }
        $dal = new DBAddr();
        return $dal->updateAddr($addrId,$value);
    }

    /**
     * 根据地址id删除相应的表
     * @param $addrId
     * @return bool
     */
    public function delAddrByAddrId($addrId){
        if(!$this->isId($addrId)){
            return false;
        }
        $dal = DBFactory::getInstance('DBAddr');
        return $dal->delAddrByAddrId($addrId);
    }

}

?>