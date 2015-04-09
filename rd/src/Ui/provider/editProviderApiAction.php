<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:40
 */

class editProviderApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "delete":
                $this->delete();
                break;
            case "save":
                $this->save();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }


    /**
     * 删除操作
     * @return bool
     */
    public function delete(){
        $providerObj = new LibProvider();
        $provIds = Dapper_Http_Request::getParam('ids');

        if(!$provIds){
            return $this->api_error(FAILED,'please provide ids');
        }
        else{
            $provIds = str_replace("[","(",$provIds);
            $provIds = str_replace("]",")",$provIds);  //删除操作为假删除，将is_del置为1表示删除
            $res = $providerObj->delProvidersByIds($provIds);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 保存操作
     * @return bool
     */
    public function save(){
        $providerObj = new LibProvider();


        $addData = array();
        $updateData = array();

        $providerId = Dapper_Http_Request::getParam('id');
        $addData['provider_name'] = Dapper_Http_Request::getParam('name');

        if(!$addData['provider_name']){
            return $this->api_error(PARAM_ERROR,'please provide name ');
        }

        if(!$providerId){
            $res = $providerObj->addProvider($addData);
        }
        else{
            $updateData = $addData;
            $res = $providerObj->updateProvider($updateData,$providerId);
        }

        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }


}