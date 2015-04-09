<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-6
 * Time: 上午10:52
 */

class userAddrEditApiAction extends baseAction{

    public function execute()
    {
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "save":   //新增或者更新收货地址
                $this->save();
                break;
            case "default":
                $this->setDefault();
                break;
            case "del":
                $this->del();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }

    }

    /**
     * 新增或修改收货地址
     * @return bool
     */
    public function save(){
        if(!$this->checkLogin()){
            return $this->api_error(FAILED,'not login：未登陆，需要先登陆！');
        }

        $addrObj = new LibAddr();
        $data = array();

        $data['user_id'] = $this->loginUid;

        $addrId = Dapper_Http_Request::getParam('id');   //地址id，有id时为更新，没有为新增
        $data['accept_name'] = Dapper_Http_Request::getParam('name');    //收件人地址
        $data['area'] = Dapper_Http_Request::getParam('area');   //区
        $data['city'] = Dapper_Http_Request::getParam('city');   //市
        $data['province'] = Dapper_Http_Request::getParam('province');   //省
        $data['zip'] = Dapper_Http_Request::getParam('zip');   //邮政编码
        $data['telephone'] = Dapper_Http_Request::getParam('telephone');   //联系电话
        $data['address'] = Dapper_Http_Request::getParam('address');    //详细地址
        $data['is_default'] = Dapper_Http_Request::getParam('isDefault');    //详细地址
        $data['mobile'] = Dapper_Http_Request::getParam('mobile');   //座机号码

        //print_r($data);

        if(!$data['accept_name'] || !$data['area'] || !$data['zip'] || !$data['telephone'] || !$data['address']){
            return $this->api_error(PARAM_ERROR, '请完整填写收货地址、联系人、联系电话、邮编！');
        }

        if($data['is_default']){//如果要求设为默认地址，则首先将所有的地址都设为非默认地址
            $userId = $this->loginUid;
            $addrList = $addrObj->getAddrListByUserId($userId);
            foreach($addrList as $addr){
                $setDefaultToZero['is_default'] = 0;
                //$data['defa_addr'] = 0;
                $addrObj->updateAddr($addr['addr_id'],$setDefaultToZero);
            }
        }


        if(!$addrId){
            $res = $addrObj->addAddr($data);
        }
        else{
            $res = $addrObj->updateAddr($addrId,$data);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 设置默认收货地址
     * @return bool
     */
    public function setDefault(){
        if(!$this->checkLogin()){
            return $this->api_error(FAILED,'not login：未登陆，需要先登陆！');
        }

        $addrId = Dapper_Http_Request::getParam('id');
        $addrObj = new LibAddr();
        $userId = $this->loginUid;
        $res = TRUE;

        if(!$addrId){
            return $this->api_error(FAILED,'please provide addr id to set default');
        }
        else{
            $addrList = $addrObj->getAddrListByUserId($userId);
            foreach($addrList as $addr){
                //print_r($addr);
                if($addr['addr_id'] != $addrId){
                    $data['is_default'] = 0;
                    $addrObj->updateAddr($addr['addr_id'],$data);
                }
                else{
                    $data['is_default'] = 1;
                    $res = $addrObj->updateAddr($addrId,$data);
                }
            }
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);


    }

    /**
     * 删除收货地址
     * @return bool
     */
    public function del(){
        if(!$this->checkLogin()){
            return $this->api_error(FAILED,'not login：未登陆，需要先登陆！');
        }

        $addrObj = new LibAddr();

        $addrId = Dapper_Http_Request::getParam('id');

        if(!$addrId){
            return $this->api_error(FAILED,'please provide addr id');
        }
        else{
            $data['addr_del'] = 1;
            $res = $addrObj->updateAddr($addrId,$data);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }


}

?>