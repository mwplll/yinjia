<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:39
 */
class providerListApiAction extends baseAction{
    public function execute(){
        $providerObj = new LibProvider();

        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $providerList = $providerObj->getProviderList($start,$num);
        $totalCount = (int)$providerObj->getProviderCount();
        $totalPage = ceil($totalCount / $num);

        //输出映射表
        $mapArr = array(
            'id' => 'provider_id',
            'name' => 'provider_name',
            'del' => 'is_del'
        );
        $providerList = $this->mapArrays($mapArr,$providerList);

        $data = array(
            'providerList' => $providerList,
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