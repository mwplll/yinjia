<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-7
 * Time: 下午8:06
 */
class designOrderStatusApiAction extends baseAction{
    public function execute(){
        $this->checkLogin();
        $orderObj = new LibOrder();
        $data = array();
        $res = FALSE;

        $act = Dapper_Http_Request::getParam('act');
        if(!$act){
            return $this->api_error(PARAM_ERROR,"please provide act");
        }

        $orderSn = Dapper_Http_Request::getParam('sn');
        if(strlen($orderSn) != 16){
            return $this->api_error(PARAM_ERROR,"please provide sn with 16 figures");
        }

        switch($act){
            case "confirm":
                $data['order_status'] = 4;
                break;
            case "cancel":
                $data['order_status'] = 10;
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }

        if($data)
            $res = $orderObj->updateOrder($data,$orderSn);

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }

    }

}

?>