<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午3:57
 */
class designBaseEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "save":
                $this->save();
                break;
            case "like":
                $this->like();
                break;
            case "view":
                $this->view();
                break;
            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 设计方案基本信息保存操作
     * @return bool
     */
    public function save(){
        $data = array();
        if(!$this->checkLogin()){
            return $this->api_error(FAILED,'not login：未登陆，需要先登陆！');
        }

        // 验证是否为已实名认证的设计师
        $userId = $this->loginUid;
        //$userObj = new LibUser();
        $userInfo = $this->loginInfo();
        if(((int)$userInfo['is_special'] != 1) || ((int)$userInfo['is_checked'] != 1)){
            //echo '$designerInfo = '.$designerInfo."\n";
            return $this->api_error(PARAM_ERROR,"抱歉，您还不是设计师用户，或者还未通过设计师实名认证审核！");
        }
        else{
            $data['user_id'] = $userId;
        }

        $designSchemaId = intval(Dapper_Http_Request::getParam('id',NULL));
        $data['design_name'] = Dapper_Http_Request::getParam('name');
        $data['house_type_id'] = intval(Dapper_Http_Request::getParam('houseTypeId',NULL));
        //$data['design_price'] = Dapper_Http_Request::getParam('price',2999.00);
        //$data['design_deposit'] = Dapper_Http_Request::getParam('deposit',1499.00);
        $data['design_content'] = Dapper_Http_Request::getParam('content',NULL);

        $designSchemaObj = new LibDesignSchema();

        if(!$data['design_name'] || !$data['house_type_id']){
            return $this->api_error(PARAM_ERROR,'please provide name.houseTypeId');
        }

        //查询户型面积计算设计费
        $houseTypeId = $data['house_type_id'];
        $houseObj = new LibHouse();
        $houseInfo = $houseObj->getHouseById($houseTypeId);
        $houseArea = intval($houseInfo['gross_area']);
        $designPrice = 0.00;
        if($houseArea <= 120.00){
            $designPrice = 2999.00;
        }
        elseif($houseArea <= 150){
            $designPrice = 3999.00;
        }
        else{
            $designPrice = 7999.00;
        }

        $data['design_price'] = $designPrice;
        $data['design_deposit'] = $designPrice*0.5;


        if(!$designSchemaId){  //新增设计方案
            $res = $designSchemaObj->addDesignSchema($data);
        }
        else{  //更新设计方案
            $res = $designSchemaObj->updateDesignSchema($designSchemaId,$data);
        }

        if($res){
            return $this->api_success($res);
        }
        else{
            return $this->api_success(FAILED);
        }
    }

    /**
     * 点赞
     * @return bool
     */
    public function like(){
        $designSchemaId = intval(Dapper_Http_Request::getParam('id',NULL));
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }

        $designSchemaObj = new LibDesignSchema();
        $res = $designSchemaObj->addLikeNum($designSchemaId);

        if($res){
            return $this->api_success($res);
        }
        else{
            return $this->api_success(FAILED);
        }
    }

    /**
     * 浏览
     * @return bool
     */
    public function view(){
        $designSchemaId = intval(Dapper_Http_Request::getParam('id',NULL));
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }

        $designSchemaObj = new LibDesignSchema();
        $res = $designSchemaObj->addViewNum($designSchemaId);

        if($res){
            return $this->api_success($res);
        }
        else{
            return $this->api_success(FAILED);
        }
    }




}