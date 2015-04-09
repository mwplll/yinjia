<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-25
 * Time: 下午3:24
 */
class editGoodsApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "state":
                $this->updateState();
                break;
            case "save":
                $this->save();
                break;
            case "saveContent":
                $this->saveContent();
                break;
            case "sort":
                $this->sort();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    public function save(){
        $goodsId = intval(Dapper_Http_Request::getParam('goodsId',NULL));
        $data['brand_id'] = intval(Dapper_Http_Request::getParam('brandId',-1));
        $data['series_id'] = intval(Dapper_Http_Request::getParam('seriesId',-1));
        $data['cat_id'] = intval(Dapper_Http_Request::getParam('catId',-1));
        $data['provider_id'] = intval(Dapper_Http_Request::getParam('providerId',1));
        $data['goods_name'] = Dapper_Http_Request::getParam('name');
        $data['sell_price'] = Dapper_Http_Request::getParam('goodsSellPrice');
        $data['market_price'] = Dapper_Http_Request::getParam('goodsMarketPrice');
        $data['cost_price'] = Dapper_Http_Request::getParam('goodsCostPrice');
        $data['img'] = Dapper_Http_Request::getParam('mainPic');
        $data['weight'] = Dapper_Http_Request::getParam('weight',0.00);
        $data['sort'] = intval(Dapper_Http_Request::getParam('sort',99));
        $data['store_num'] = intval(Dapper_Http_Request::getParam('goodsStoreNum',0));
        $data['is_del'] = intval(Dapper_Http_Request::getParam('state',0));
        $data['period'] = intval(Dapper_Http_Request::getParam('period',10));
        $data['unit'] = Dapper_Http_Request::getParam('unit');
        $data['goods_sn'] = Dapper_Http_Request::getParam('goodsSn');
        $data['content'] = Dapper_Http_Request::getParam('content');

        if(!$data['goods_name']){
            return $this->api_error(PARAM_ERROR,'请提供商品名称，并控制在50个字以内！');
        }

        /*if(!$data['brand_id']){
            return $this->api_error(PARAM_ERROR,'请选择商品品牌！');
        }*/

        if(!$data['cat_id']){
            return $this->api_error(PARAM_ERROR,'请选择商品分类！');
        }

        /*if(!$data['period']){
            return $this->api_error(PARAM_ERROR,'请选择建材所用的装修阶段！');
        }*/

        //is_del 0为上架，1为删除，2为下架，3为待审
        if($data['is_del'] == 0){
            $data['up_time'] = (int)time();
        }

        if($data['is_del'] == 2){
            $data['down_time'] = (int)time();
        }

        //如果有上传新的商品图片，添加到商品图库中
        $this->_addGoodsPics();

        $goodsObj = new LibGoods();
        if(!$goodsId){
            $addData = $data;
            //$addData['goods_sn'] = 'YJ'.uniqid().rand(10000,99999);
            //echo '$addData = ';
            //print_r($addData);
            //echo "\n";
            //$res = TRUE;
            $newGoodsId = $goodsObj->addGoods($addData);    //添加商品基本信息
            $this->_addGoodsPicRels($newGoodsId);   //添加商品图片关系
            $this->_addProducts($newGoodsId,$addData['goods_sn']); //添加商品的具体货品
            $res = $newGoodsId;
        }
        else{
            $updateData = $data;
            $this->_addGoodsPicRels($goodsId);  //添加商品图片关系
            $this->_addProducts($goodsId);  //添加商品的具体某一规格的货品
            $res = $goodsObj->updateGoods($goodsId,$updateData);   //更新商品基本信息
        }

        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 更新商品详情
     * @return bool
     */
    public function saveContent(){
        $goodsId = intval(Dapper_Http_Request::getParam('id',NULL));
        $data['content'] = Dapper_Http_Request::getParam('content');

        if(!$data['content'] || !$goodsId){
            return $this->api_error(PARAM_ERROR,'please at least provide id,content');
        }

        $goodsObj = new LibGoods();
        $res = $goodsObj->updateGoods($goodsId,$data);

        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }

    public function updateState(){
        $goodsObj = new LibGoods();
        $ids = Dapper_Http_Request::getParam('ids');
        $state = Dapper_Http_Request::getParam('state');

        if(!$ids || !isset($state)){
            return $this->api_error(FAILED,'please provide ids,state');
        }
        else{
            $ids = str_replace("[","(",$ids);
            $ids = str_replace("]",")",$ids);
            $res = $goodsObj->updateGoodsStateByIds($ids,$state);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }

    public function sort(){
        $goodsId = intval(Dapper_Http_Request::getParam('id',NULL));
        $data['sort'] = Dapper_Http_Request::getParam('sort');

        if(!$data['sort'] || !$goodsId){
            return $this->api_error(PARAM_ERROR,'please at least provide id,sort');
        }

        $goodsObj = new LibGoods();
        $res = $goodsObj->updateGoods($goodsId,$data);

        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    private function _gatherProducts(){
        $arrSellPrice = Dapper_Http_Request::getParam('sellPrice',NULL);
        $arrMArketPrice = Dapper_Http_Request::getParam('marketPrice',NULL);
        $arrCostPrice = Dapper_Http_Request::getParam('costPrice',NULL);
        $arrStoreNum = Dapper_Http_Request::getParam('storeNum',NULL);
        $arrWeight = Dapper_Http_Request::getParam('weight',NULL);
        $arrSpecArray = Dapper_Http_Request::getParam('specArray',NULL);
        $arrProductsSn = Dapper_Http_Request::getParam('productsSn',NULL);

        $products = array();
        $picNum = count($arrSellPrice);
        if($picNum >= 1 && ($picNum == count($arrMArketPrice)) && ($picNum == count($arrProductsSn))&& ($picNum == count($arrCostPrice))&& ($picNum == count($arrStoreNum)) && ($picNum == count($arrWeight))&& ($picNum == count($arrSpecArray))){
            foreach($arrSellPrice as $i => $v){
                array_push($products, array(
                    'sell_price' => $v,
                    'market_price' => $arrMArketPrice[$i],
                    'cost_price' => $arrCostPrice[$i],
                    'store_num' => $arrStoreNum[$i],
                    'weight' => $arrWeight[$i],
                    'spec_array' => $arrSpecArray[$i],
                    'products_sn' => $arrProductsSn[$i]
                ));
            }
        }
        else{
            return $this->api_error(PARAM_ERROR,'请提供货品的销售价、市场价、成本价、库存、重量、规格');
        }

        return $products;
    }

    /**
     * 整理商品图片
     * @return array
     */
    private function _gatherGoodsPic(){
        $arrGoodsPics = Dapper_Http_Request::getParam('pic',NULL);

        $goodsPics = array();
        //echo 'count($arrGoodsPics) = '.count($arrGoodsPics)."\n";
        if(count($arrGoodsPics) >= 1){
            //echo 'it has run and $arrGoodsPics not NULL';
            foreach($arrGoodsPics as $k => $v){
                if($v){
                    array_push($goodsPics,array("pic" => $v));
                }
            }
            return $goodsPics;
        }

        return FALSE;
    }

    /**
     * 批量添加/更新商品图片
     * @return bool|mixed
     */
    private function _addGoodsPics(){
        $goodsPics = $this->_gatherGoodsPic();
        if($goodsPics){
            foreach($goodsPics as &$pic){
                $pic['pic_id'] = MD5($pic['pic']);
            }

            $goodsObj = new LibGoods();
            return $goodsObj->addGoodsPics($goodsPics);
        }

        return FALSE;
    }

    /**
     * 批量添加/更新商品-图片关系
     * @param $goodsId
     * @return bool
     */
    private function _addGoodsPicRels($goodsId){
        $goodsPics = $this->_gatherGoodsPic();
        if($goodsPics){
            foreach($goodsPics as &$pic){
                $pic['pic_id'] = MD5($pic['pic']);
            }

            $goodsObj = new LibGoods();
            return $goodsObj->addGoodsPicRels($goodsId,$goodsPics);
        }

        return FALSE;

    }

    /**
     * 批量添加同一商品的不同货品
     * @param $goodsId
     * @param $goodsSn
     * @return bool|mixed
     */
    private function _addProducts($goodsId,$goodsSn=NULL){
        $products = $this->_gatherProducts();
        $goodsObj = new LibGoods();
        $goodsInfo = $goodsObj->getGoodsById($goodsId);
        $brandEngName = $goodsInfo['eng_name'];

        $i=1;
        if($products){
            foreach($products as &$product){
                $product['goods_id'] = $goodsId;
                if($goodsSn){
                    $product['products_sn'] = 'YJ-'.$brandEngName.'-'.$goodsSn.'-'.$i;
                }
                $i=$i+1;
            }

            $goodsObj = new LibGoods();
            return $goodsObj->addProducts($goodsId,$products);
        }

        return FALSE;

    }



}