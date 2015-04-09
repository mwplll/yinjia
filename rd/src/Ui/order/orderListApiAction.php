<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-28
 * Time: 下午9:28
 */
class orderListApiAction extends baseAction{
    public function execute(){
        $orderObj = new LibOrder();

        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $orderList = $orderObj->getOrderList($start,$num);
        $totalCount = (int)$orderObj->getOrderCount();
        $totalPage = ceil($totalCount / $num);

        //输出映射表
        $mapArr = array(
            'id' => 'order_id',
            'user' => 'user_name',
            'sn' => 'order_sn',
            'amount' => 'order_amout',
            'type' => 'order_type',
            'status' => 'order_status',
            'createTime' => 'create_time'

        );
        $brandsData = $this->mapArrays($mapArr,$orderList);

        $data = array(
            'orderList' => $brandsData,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));
        //print_r($data);

        //echo 'time = '.time()."\n";
        //echo 'now = '.date('Y-m-d H:i:s',time())."\n";
        if($data === NULL){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }
    }
}