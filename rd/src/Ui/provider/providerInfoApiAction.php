<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:39
 */

class providerInfoApiAction extends baseAction{
    public function execute(){
        $providerObj = new LibProvider();
        $providerId = Dapper_Http_Request::getParam('id');

        if(!$providerId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $res = $providerObj->getProviderById($providerId);
        }

        $mapArr = array(
            'id' => 'provider_id',
            'name' => 'provider_name',
            'del' => 'is_del'
        );
        $jsonData = $this->mapArray($mapArr,$res);

        //print_r($jsonData);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($jsonData);

    }
}