<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-20
 * Time: 下午3:44
 */

class LibGoods
{
    /***********************************
     * utils
     ***********************************/
    /**
     * @param $id
     * @return bool
     */
    public function isId($id)
    {
        if(!is_numeric($id) || $id<0)
            return false;
        return true;
    }

    /**根据商品ID获取有关商品的所有信息，包括基本信息、额外信息、图片、用户评价
     * @param $goodsId
     * @return array|bool
     */
    public function getGoodsById($goodsId){
        if(!$this->isId($goodsId))
        {
            return false;
        }

        $return = $this->getGoodsInfoById($goodsId);
        $return['productsList'] = $this->getProductsListByGoodId($goodsId);
        $return['picList'] = $this->getGoodsPicListByGoodsId($goodsId);

        $dal = new DBBrand();
        if($return['brand_id']){
            $brandInfo = $dal->getBrandById($return['brand_id']);
            $return['brand_name'] = $brandInfo['brand_name'];
            $return['eng_name'] = $brandInfo['eng_name'];
        }

        if($return)
            return $return;
        else
            return FALSE;
    }

    /**根据商品的ID获取商品的基本信息
     * @param $goodsId
     * @return bool
     */
    public function getGoodsInfoById($goodsId){
        if(!$this->isId($goodsId))
        {
            return false;
        }

        $dal = new DBGoods();
        $result = $dal->getGoodsById($goodsId);

        return $result;
    }

    /**
     * 根据商品id获得货品列表
     * @param $goodsId
     * @return bool|mixed
     */
    public function getProductsListByGoodId($goodsId){
        if(!$this->isId($goodsId))
        {
            return false;
        }

        $dal = new DBProducts();
        $result = $dal->getProductsListByGoodsId($goodsId);
        return $result;
    }


    /**根据商品的ID获取商品的图片信息
     * @param $goodsId
     * @return bool
     */
    public function getGoodsPicListByGoodsId($goodsId){
        if(!$this->isId($goodsId))
        {
            return false;
        }

        $dal = new DBGoodsPic();
        $result = $dal->getGoodsPicListByGoodsId($goodsId);

        return $result;
    }

    /**
     * 查询符合条件的商品列表
     * @param $start
     * @param $num
     * @param array $wh
     * @param array $order
     * @return bool|mixed
     */
    public function getGoodsList($start,$num,$wh=array(),$order=array()){
        if(isset($wh['cat_id']) && $wh['cat_id']!=0){  //获得该分类下的所有子分类的cat_layer
            $catId = (int)$wh['cat_id'];
            //echo '$catId = '.$catId;
            $catObj = new LibCategory();
            $catInfo = $catObj->getCategoryById($catId);
            if(!$catInfo){
                return FALSE;
            }
            else{
                $catLayer = (int)$catInfo['cat_layer'];
                $wh['min_cat_layer'] = $catLayer;
                //echo '$catLayer = '.$catLayer;
                //if(is_numeric($catLayer)){echo "is int"."\n";}
                $mod = 0;
                for($i=0; $mod ==0 ;$i++){
                    $catLayer = $catLayer / 100;
                    $mod = $catLayer % 100;
                    //echo '$i = '.$i."\n";
                    //echo '$catLayer = '.$catLayer."\n";
                    //echo '$mod = '.$mod."\n";
                }
                $catLayer = $catLayer + 1;
                for(;$i > 0;$i--){
                    $catLayer = $catLayer * 100;
                    //echo '$i = '.$i."\n";
                    //echo '$catLayer = '.$catLayer."\n";

                }
                $wh['max_cat_layer'] = $catLayer;
            }
        }

        $dal = new DBGoods();
        return $dal->getGoodsList($start,$num,$wh,$order);
    }

    /**
     * 查询满足一定条件的商品总数
     * @param array $wh
     * @return bool|mixed
     */
    public function getGoodsCount($wh=array()){
        if(isset($wh['cat_id']) && $wh['cat_id']!=0){  //获得该分类下的所有子分类的cat_layer
            $catId = (int)$wh['cat_id'];
            //echo '$catId = '.$catId;
            $catObj = new LibCategory();
            $catInfo = $catObj->getCategoryById($catId);
            if(!$catInfo){
                return FALSE;
            }
            else{
                $catLayer = (int)$catInfo['cat_layer'];
                $wh['min_cat_layer'] = $catLayer;
                $mod = 0;
                for($i=0; $mod ==0 ;$i++){
                    $catLayer = $catLayer / 100;
                    $mod = $catLayer % 100;
                }
                $catLayer = $catLayer + 1;
                for(;$i > 0;$i--){
                    $catLayer = $catLayer * 100;
                }
                $wh['max_cat_layer'] = $catLayer;
            }
        }
        $dal = new DBGoods();
        return $dal->getGoodsCount($wh);
    }

    /**
     * 添加商品基本信息，返回添加的商品Id
     * @param array $value
     * @return bool|mixed
     */
    public function addGoods($value=array()){
        if(!$value){
            return false;
        }

        if(!$this->isId($value['brand_id']) || !$this->isId($value['cat_id']) || !$this->isId($value['provider_id'])){
            return FALSE;
        }

        $value['create_time'] = (int)time();

        $dal = new DBGoods();
        return $dal->addGoods($value);
    }

    /**
     * 更新商品基本信息
     * @param $goodsId
     * @param array $value
     * @return bool|mixed
     */
    public function updateGoods($goodsId,$value=array()){
        if(!$value){
            return FALSE;
        }

        if(!$this->isId($goodsId)){
            return FALSE;
        }

        $dal = new DBGoods();
        return $dal->updateGoods($goodsId,$value);
    }

    public function searchPicByPicId($picId){
        $dal = new DBGoodsPic();
        return $dal->searchPicByPic($picId);
    }

    private function _checkPicExist($picId){
        //echo '$picId = '.$picId."\n";
        if($this->searchPicByPicId($picId)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /**
     * 批量添加商品图库,如果有新的图片添加，则返回新添加的图片；如果没有，返回FALSE
     * @param $pics
     * @return mixed
     */
    public function addGoodsPics($pics){
        if(!$pics){
            return FALSE;
        }
        $picsForAdd = array();
        foreach($pics as $pic){
            //echo '$pic = ';
            //print_r($pic);
            //echo "\n";
            if(!($this->_checkPicExist($pic['pic_id']))){
                array_push($picsForAdd,$pic);
            }
            //print_r($picsForAdd);

        }

        if(!$picsForAdd){
            return FALSE;
        }
        $dal = new DBGoodsPic();
        //echo '$picsForAdd = ';
        //print_r($picsForAdd);
        //echo "\n";
        $res = $dal->addGoodsPics($picsForAdd);
        return $res ? $picsForAdd : $res;
    }

    /**
     * 批量添加商品-图片关系
     * @param $goodsId
     * @param $pics
     * @return bool
     */
    public function addGoodsPicRels($goodsId,$pics){
        if(!$this->isId($goodsId)){
            return FALSE;
        }
        if(!$pics){
            return FALSE;
        }

        $dal = new DBGoodsPic();
        $dal->delGoodsPicRelsByGoodsId($goodsId);  //删除已经存在的商品图片关系
        $goodsPicRels = array();
        foreach($pics as $pic){
            array_push($goodsPicRels,array(
                "goods_id" => $goodsId,
                "pic_id" => MD5($pic['pic'])
            ));
        }

        $res = $dal->addGoodsPicRels($goodsPicRels);
        return $res;


    }

    /**
     * 添加商品的不同货品
     * @param $goodsId
     * @param $products
     * @return bool|mixed
     */
    public function addProducts($goodsId,$products){
        if(!$this->isId($goodsId)){
            return FALSE;
        }
        if(!$products){
            return FALSE;
        }

        $dal = new DBProducts();
        $dal->delProductsBy($goodsId); //删除该商品已存在的货品
        $res = $dal->addProducts($products);
        return $res;
    }

    public function updateGoodsStateByIds($ids,$state){
        $dal = new DBGoods();
        return $dal->updateGoodsStateByIds($ids,$state);
    }

}


?>