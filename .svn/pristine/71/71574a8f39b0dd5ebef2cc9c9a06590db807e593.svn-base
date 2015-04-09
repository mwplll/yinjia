<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-7
 * Time: 下午6:49
 */
class LibOrder{

    /**
     * 根据订单号查询订单信息，包括订单信息，收货地址信息
     * @param $sn
     * @return mixed
     */
    public function getOrderBySn($sn){
        $dal = DBFactory::getInstance('DBOrder');
        return $dal->getOrderBySn($sn);
    }

    /**
     * 更新订单表
     * @param array $values
     * @param $sn
     * @return bool
     */
    public function updateOrder($values=array(),$sn){
        if(!$values){return FALSE;}
        $dal = DBFactory::getInstance('DBOrder');
        return $dal->updateOrder($values,$sn);
    }

    /**
     * 获取满足一定条件的设计师的订单列表
     * @param $designerId
     * @param array $wh
     * @param $start
     * @param $num
     * @return bool
     */
    public function getDesignerOrderList($wh=array(),$designerId,$start,$num){
        //if(!$wh){return FALSE;}
        $dal = DBFactory::getInstance('DBOrder');
        return $dal->getDesignerOrderList($wh,$designerId,$start,$num);
    }

    /**
     * 获取满足一定条件的设计师的订单个数
     * @param array $wh
     * @param $designerId
     * @return bool
     */
    public function getDesignerOrderCount($wh=array(),$designerId){
        //if(!$wh){return FALSE;}
        $dal = DBFactory::getInstance('DBOrder');
        return $dal->getDesignerOrderCount($wh,$designerId);
    }

    public function getOrderList($start,$num){
        $dal = new DBOrder();
        return $dal->getOrderList($start,$num);
    }

    public function getOrderCount(){
        $dal = new DBOrder();
        return $dal->getOrderCount();
    }

}

?>