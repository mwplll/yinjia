<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-13
 * Time: 下午4:18
 */
class designListApiAction extends baseAction{
    public function execute(){
        $designObj = new LibDesign();
        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $wh=array();
        $designList = $designObj->getDesignList($wh,$start,$num);
        $totalCount = (int)$designObj->getDesignCount();
        $totalPage = ceil($totalCount / $num);

        $data = array(
            '$designlist' => $designList,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));
        //print_r($data);

        if($data === NULL){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }
    }
}