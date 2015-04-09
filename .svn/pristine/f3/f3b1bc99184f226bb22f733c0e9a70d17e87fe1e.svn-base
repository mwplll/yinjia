<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:39
 */
class brandListApiAction extends baseAction{
    public function execute(){
        $brandObj = new LibBrand();

        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $brandList = $brandObj->getBrandList($start,$num);
        $totalCount = (int)$brandObj->getBrandCount();
        $totalPage = ceil($totalCount / $num);

        //输出映射表
        $mapArr = array(
            'id' => 'brand_id',
            'name' => 'brand_name',
            'enName' => 'eng_name',
            'logo' => 'brand_logo',
            'content' => 'brand_desc',
            'sort' => 'brand_sort',
            'url' => 'brand_url',
            'del' => 'is_del',
            'seriesList' => 'seriesList',
        );
        $brandsData = $this->mapArrays($mapArr,$brandList);

        //品牌下的产品系列信息
        $mapArr = array(
            'seriesId' => 'series_id',
            'seriesName' => 'series_name'
        );

        foreach($brandsData as &$brand){
            if($brand['seriesList'])
                $brand['seriesList'] = $this->mapArrays($mapArr,$brand['seriesList']);
            else
                $brand['seriesList'] = array();

        }

        $data = array(
            'brandlist' => $brandsData,
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