<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:39
 */

class brandInfoApiAction extends baseAction{
    public function execute(){
        $brandObj = new LibBrand();
        $brandId = Dapper_Http_Request::getParam('id');

        if(!$brandId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $brandInfo = $brandObj->getBrandById($brandId);
        }

        $mapArr = array(
            'id' => 'brand_id',
            'name' => 'brand_name',
            'enName' => 'eng_name',
            'logo' => 'brand_logo',
            'content' => 'brand_desc',
            'sort' => 'brand_sort',
            'url' => 'brand_url',
            'del' => 'is_del'
        );
        $jsonData = $this->mapArray($mapArr,$brandInfo);

        //品牌下的系列信息
        $mapArr = array(
            'seriesId' => 'series_id',
            'seriesName' => 'series_name',
        );

        if($brandInfo['seriesList'])
            $jsonData['seriesList'] = $this->mapArrays($mapArr,$brandInfo['seriesList']);
        else
            $jsonData['seriesList'] = array();

        //print_r($jsonData);

        if($brandInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($jsonData);

    }
}