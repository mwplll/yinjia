<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-20
 * Time: 下午11:43
 */
class specPicListApiAction extends baseAction{
    public function execute(){
        $specObj = new LibSpec();

        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $specList = $specObj->getSpecPicList($start,$num);
        $totalCount = (int)$specObj->getSpecPicCount();
        $totalPage = ceil($totalCount / $num);

        //输出映射表
        $mapArr = array(
            'id' => 'spec_pic_id',
            'name' => 'pic_name',
            'pic' => 'spec_pic',
            'time' => 'create_time'
        );
        $picsData = $this->mapArrays($mapArr,$specList);

        $data = array(
            'picList' => $picsData,
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