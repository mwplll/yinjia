<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-23
 * Time: 下午3:38
 */
class goodsInfoApiAction extends baseAction{
    public function execute(){
        $goodsObj = new LibGoods();
        $goodsId = Dapper_Http_Request::getParam('id');

        if(!$goodsId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $goodsInfo = $goodsObj->getGoodsById($goodsId);
        }

        //商品基本信息映射表
        $mapArr = array(
            'id' => 'goods_id',
            'name' => 'goods_name',
            'goodsSn' => 'goods_sn',
            'sellPrice' => 'sell_price',
            'marketPrice' => 'market_price',
            'costPrice' => 'cost_price',
            'weight' => 'weight',
            'storeNum' => 'store_num',
            'catId' => 'cat_id',
            'state' => 'is_del',
            'sort' => 'sort',
            'unit' => 'unit',
            'period' => 'period',
            'pic' => 'img',
            'providerId' => 'provider_id',
            'brandId' => 'brand_id',
            'seriesId' => 'series_id',
            'content' => 'content',
            'brandName' => 'brand_name'
        );
        $jsonData = $this->mapArray($mapArr,$goodsInfo);
        //print_r($jsonData);
        //货品信息映射表
        $mapArr = array(
            'productsId' => 'products_id',
            'productsSn' => 'products_sn',
            'sellPrice' => 'sell_price',
            'marketPrice' => 'market_price',
            'costPrice' => 'cost_price',
            'weight' => 'weight',
            'storeNum' => 'store_num',
            'specArray' => 'spec_array'
        );
        if($goodsInfo['productsList'])
            $jsonData['productsList'] = $this->mapArrays($mapArr,$goodsInfo['productsList']);
        else
            $jsonData['productsList'] = array();

        //商品图片映射表
        $mapArr = array(
            'pic' => 'pic'
        );
        if($goodsInfo['picList'])
            $jsonData['picList'] = $this->mapArrays($mapArr,$goodsInfo['picList']);
        else
            $jsonData['picList'] = array();
        //print_r($goodsInfo);
        //print_r($jsonData);

        if($goodsInfo === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($jsonData);

    }
}