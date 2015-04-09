<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-20
 * Time: 下午9:39
 */
class specListApiAction extends baseAction{
    public function execute(){
        $specObj = new LibSpec();

        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $specList = $specObj->getSpecList($start,$num);
        $totalCount = (int)$specObj->getSpecCount();
        $totalPage = ceil($totalCount / $num);

        //输出映射表
        $mapArr = array(
            'id' => 'spec_id',
            'name' => 'spec_name',
            'value' => 'spec_value',
            'type' => 'spec_type',
            'del' => 'is_del'
        );
        $specsData = $this->mapArrays($mapArr,$specList);

        $data = array(
            'specList' => $specsData,
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