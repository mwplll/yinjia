<?php

class buyDesignApiAction extends baseAction
{
    public function execute()
    {
        $this->checkLogin();

        $data = array();

        $data['user_id'] = $this->loginUid;

        $data['order_sn'] = $this->build_order_sn();   //生成订单号
        //print_r($data['order_sn']);

        $data['design_schema_id'] = Dapper_Http_Request::getParam('design_id');
        $data['addr_id'] = Dapper_Http_Request::getParam('addr_id');
        $data['order_type'] = Dapper_Http_Request::getParam('type');
        //$data['dorder_amout'] = Dapper_Http_Request::getParam('amout');

        if(!$data['design_schema_id'] || !$data['addr_id'] || !$data['order_type'] ){
            return $this->api_error(PARAM_ERROR, 'please provide design_id, addr_id,type!');
        }

        //查询得到订单金额
        $designObj = new LibDesign();
        $designInfo = $designObj->getDesignInfoByDesignID($data['design_schema_id']);
        //print_r($designInfo);
        if($data['order_type'] == 1){
            $data['order_amout'] = $designInfo['design_deposit'];
            $data['designer_id'] = $designInfo['designer_id'];
        }
        elseif($data['order_type'] == 2){
            $data['order_amout'] = (int)$designInfo['design_price'] - (int)$designInfo['design_deposit'];
            $data['designer_id'] = $designInfo['designer_id'];
        }
        else{;}


        $data['cp_design_schema_id'] = $this->cp_design_schema($data['design_schema_id']);
        //print_r($data);
        $uaObj = new LibUserAction($this->loginUid);

        $ret = $uaObj->buyDesign($data);
        if($ret === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success(array('sn'=>$data['order_sn']));
        }
    }

    /**
     * 生成订单号
     * @return string
     */
    public function build_order_sn(){
        return date('Ymd').substr(implode(NULL,array_map('ord',str_split(substr(uniqid(),7,13),1))),0,8);
    }

    /**
     * 复制设计方案
     * @param $designId
     * @return bool
     */
    public function cp_design_schema($designId){

        $cpDesignData = array();

        $designObj = new LibDesign();
        $designInfo = $designObj->getDesignInfoByDesignID($designId);


        //复制设计方案信息
        $cpDesignData = array_splice($designInfo,1);
        $cpDesignId = $designObj->addDesignInfo($cpDesignData,$is_copy=1);

        //复制设计方案效果图
        $designRoomObj = new LibDesignRoom();
        $designRooms = $designRoomObj->getRoomsByDesignId($designId);
        $i=0;
        //print_r($designRooms);
        foreach($designRooms as $room){
            $cpRooms[$i]['design_schema_id'] = $cpDesignId;
            $cpRooms[$i]['design_pic'] = $room['design_pic'];
            $cpRooms[$i]['room_id'] = $room['room_id'];
            $i++;
        }

        $addedDesignRoomId = $designRoomObj->addDesignRooms($cpRooms);
        if(!$addedDesignRoomId){
            return $this->api_error(FAILED, 'create design room failed!');
        }

        return $cpDesignId;

    }
}