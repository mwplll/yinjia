<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-8
 * Time: 下午2:25
 */
class designerOrderListApiAction extends baseAction{
    public function execute(){
        $this->checkLogin();
        $userId = $this->loginUid;

        $num = Dapper_Http_Request::getParam('num',10);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $designerObj = new LibDesigner();
        $designerInfo = $designerObj->getDesignerByUid($userId);
        $designId = $designerInfo['designer_id'];
        //print_r($designerInfo);

        $wh = array();
        $state = Dapper_Http_Request::getParam('state');
        switch($state){
            case "all":
                $wh['order_type'] = '(1'.','.'2)';
                break;
            case "pay_first":{
                $wh['order_type'] = '(1'.')';
                $wh['order_status'] =  1;
                break;
            }
            case "pic_first":{
                $wh['order_type'] = '(1'.')';
                $wh['order_status'] =  2;
                break;
            }
            case "pay_second":{
                $wh['order_type'] = '(2'.')';
                $wh['order_status'] =  1;
                break;
            }
            case "pic_second":{
                $wh['order_type'] = '(2'.')';
                $wh['order_status'] =  2;
                break;
            }
            case "send":{
                $wh['order_type'] = '(1'.','.'2)';
                $wh['order_status'] =  3;
                break;
            }
            case "complete":{
                $wh['order_type'] = '(1'.','.'2)';
                $wh['order_status'] =  11;
                break;
            }
            case "cancel":{
                $wh['order_type'] = '(1'.','.'2)';
                $wh['order_status'] =  10;
                break;
            }

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'state' param!");
                break;
        }


        if($wh){
            $orderObj = new LibOrder();
            $orderList = $orderObj->getDesignerOrderList($wh,$designId,$start,$num);
            //print_r($orderlist);
            foreach($orderList as &$v){
                //设计方案信息
                $designId = $v['design_schema_id'];
                $designObj = new LibDesign();
                $v['design_schema'] = $designObj->getDesignInfoByDesignID($designId);

                //户型图信息
                $designInfo = $v['design_schema'];
                $houseObj = new LibHouse();
                $houseTypeId = $designInfo['house_type_id'];
                $v['house_type'] = $houseObj->getHouseTypeInfoByHouseTypeID($houseTypeId);

                //用户信息
                $userId = $v['user_id'];
                $userObj = new LibUser();
                $v['user'] = $userObj->getUserById($userId);


            }

            $totalCount = (int)$orderObj->getDesignerOrderCount($wh,$designId);
            $totalPage = ceil($totalCount / $num);

            $res = array(
                'orderList' => $orderList,
                'pagination' => array(
                    'count' => $totalCount,
                    'page' => $totalPage
                ));

            //print_r($res);

            if($orderList === FALSE){
                return $this->api_error(FAILED);
            }
            else{
                return $this->api_success($res);
            }
        }
    }
}
?>