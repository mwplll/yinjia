<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-7
 * Time: 下午6:50
 */
class DBOrder
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    /**
     * 通过订单号查询订单信息
     * @param $Sn
     * @return mixed
     */
    public function getOrderBySn($Sn){

        $sql = "SELECT * FROM wm_orders WHERE wm_orders.order_sn = $Sn";

        return $this->db->queryFirstRow($sql);
    }

    /**
     * 根据订单号更新订单信息
     * @param array $updateInfo
     * @param $sn
     * @return bool
     */
    public function updateOrder($updateInfo=array(),$sn){
        if(!$updateInfo){return FALSE;}

        $wh = array('order_sn' => $sn);
        $tb_name = 'wm_orders';
        $sql = $this->db->makeUpdateSQL($tb_name, $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 查询满足$wh条件的设计师的订单列表
     * @param array $wh
     * @param $designerId
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getDesignerOrderList($wh=array(),$designerId,$start,$num){

        $orderType = isset($wh['order_type']) ? " AND order_type in " . $wh["order_type"] . " " : " ";
        $orderState = isset($wh['order_status']) ? " AND order_status=" . $wh['order_status'] . " " : " ";

        $sql = "SELECT * FROM wm_orders WHERE designer_id = $designerId $orderType $orderState
                ORDER BY create_time DESC
                LIMIT $start,$num
                ";
        $result = $this->db->queryAllRows($sql);
        return $result;
    }

    /**
     * 获取满足$wh条件的设计师的订单个数
     * @param array $wh
     * @param $designerId
     * @return mixed
     */
    public function getDesignerOrderCount($wh=array(),$designerId){
        $orderType = isset($wh['order_type']) ? " AND order_type in " . $wh["order_type"] . " " : " ";
        $orderState = isset($wh['order_status']) ? " AND order_status=" . $wh['order_status'] . " " : " ";

        $sql = "SELECT count(*) as num FROM wm_orders WHERE designer_id = $designerId $orderType $orderState
                ORDER BY create_time DESC
                ";
        $result = $this->db->queryFirstRow($sql);
        return $result['num'];
    }


    public function getOrderList($start,$num){
        $sql = "SELECT * FROM wm_orders INNER JOIN wm_user WHERE wm_orders.user_id = wm_user.user_id
                ORDER BY wm_orders.create_time ASC
                LIMIT $start,$num";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    public function getOrderCount(){
        $sql = "SELECT count(*) as num FROM wm_orders INNER JOIN wm_user WHERE wm_orders.user_id = wm_user.user_id";

        $result = $this->db->queryFirstRow($sql);
        return $result['num'];
    }


}
