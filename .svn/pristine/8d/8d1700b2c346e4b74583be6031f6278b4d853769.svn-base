<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-20
 * Time: 下午3:45
 */
class DBGoods
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    public function __destruct()
    {
        $this->db = null;
    }

    /**
     * 按条件查询相关的商品列表
     * @param $start
     * @param $num
     * @param array $wh
     * @param array $order
     * @return mixed
     */
    public function getGoodsList($start,$num,$wh=array(),$order=array()){
        $state = isset($wh['is_del']) ? " AND wm_goods.is_del = " . $wh['is_del'] . " " : " AND wm_goods.is_del <> 1 ";  //商品状态
        $period = isset($wh['period']) ? " AND wm_goods.period = " . $wh['period'] . " " : " ";  //建材所在的装修阶段
        $keywords = isset($wh['keywords']) ? " AND wm_goods.goods_name LIKE  '%".$wh['keywords']."%' " : " ";  //商品名称关键字搜索
        $brand = isset($wh['brand']) ? " AND wm_brand.brand_name LIKE  '%".$wh['brand']."%' " : " ";  //品牌关键字搜索
        $minStoreNum = isset($wh['min_store_num']) ? " AND wm_goods.store_num >= " . $wh['min_store_num'] . " " : " ";  //库存最小值
        $maxStoreNum = isset($wh['max_store_num']) ? " AND wm_goods.store_num <= " . $wh['max_store_num'] . " " : " ";//库存最大值
        $minCatLayer = isset($wh['min_cat_layer']) ? " AND wm_category.cat_layer >= " . $wh['min_cat_layer'] . " " : " ";  //分类下的商品筛选
        $maxCatLayer = isset($wh['max_cat_layer']) ? " AND wm_category.cat_layer < " . $wh['max_cat_layer'] . " " : " ";
        $sql = "SELECT wm_goods.goods_id,wm_goods.brand_id,wm_goods.goods_name,wm_goods.sell_price,wm_goods.store_num,wm_goods.is_del,wm_goods.sort,wm_goods.img,wm_goods.period,
                wm_category.cat_name
                FROM wm_category INNER JOIN wm_goods ON wm_goods.cat_id = wm_category.cat_id
                INNER JOIN wm_brand ON wm_goods.brand_id = wm_brand.brand_id
                $state $period $keywords $minStoreNum $maxStoreNum $minCatLayer $maxCatLayer $brand
                ORDER BY wm_goods.create_time DESC
                LIMIT $start,$num";
        //$sql = "SELECT * FROM wm_goods,wm_category WHERE wm_goods.cat_id = wm_category.cat_id AND wm_goods.is_del=3";
        //echo '$sql = '.$sql."\n";
        $res = $this->db->queryAllRows($sql);
        //print_r($res);
        return $res;
    }

    /**查询符合条件的商品总数
     * @param array $wh
     * @return mixed
     */
    public function getGoodsCount($wh=array()){
        $state = isset($wh['is_del']) ? " AND wm_goods.is_del=" . $wh['is_del'] . " " : " AND wm_goods.is_del <> 1 ";  //商品状态
        $period = isset($wh['period']) ? " AND wm_goods.period=" . $wh['period'] . " " : " ";  //建材所在的装修阶段
        $keywords = isset($wh['keywords']) ? " AND wm_goods.goods_name LIKE  '%".$wh['keywords']."%' " : " ";  //商品名称关键字搜索
        $brand = isset($wh['brand']) ? " AND wm_brand.brand_name LIKE  '%".$wh['brand']."%' " : " ";  //品牌关键字搜索
        $minStoreNum = isset($wh['min_store_num']) ? " AND wm_goods.store_num >= " . $wh['min_store_num'] . " " : " ";  //库存最小值
        $maxStoreNum = isset($wh['max_store_num']) ? " AND wm_goods.store_num <= " . $wh['max_store_num'] . " " : " ";//库存最大值
        $minCatLayer = isset($wh['min_cat_layer']) ? " AND wm_category.cat_layer >= " . $wh['min_cat_layer'] . " " : " ";
        $maxCatLayer = isset($wh['max_cat_layer']) ? " AND wm_category.cat_layer < " . $wh['max_cat_layer'] . " " : " ";
        $sql = "SELECT count(*) as num FROM wm_category INNER JOIN wm_goods ON wm_goods.cat_id = wm_category.cat_id
                INNER JOIN wm_brand ON wm_goods.brand_id = wm_brand.brand_id
                $state $period $keywords $minStoreNum $maxStoreNum $minCatLayer $maxCatLayer $brand
                ";
        //echo '$sql = '.$sql."\n";
        $result = $this->db->queryFirstRow($sql);
        return $result['num'];

    }

    /**
     * 通过商品id获得商品信息
     * @param $id
     * @return mixed
     */
    public function getGoodsById($id){
        $sql = "SELECT * FROM wm_goods WHERE wm_goods.goods_id = $id";
        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 添加商品基本信息,返回添加的商品id
     * @param array $value
     * @return mixed
     */
    public function addGoods($value = array())
    {
        $tbname = 'wm_goods';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 更新商品基本信息
     * @param $updateInfo
     * @param $goodsId
     * @return mixed
     */
    public function updateGoods($goodsId,$updateInfo=array())
    {
        $wh = array('goods_id' => $goodsId);
        $tb_name = 'wm_goods';
        $sql = $this->db->makeUpdateSQL($tb_name, $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 批量更新商品状态
     * @param $ids
     * @param $state
     * @return mixed
     */
    public function updateGoodsStateByIds($ids,$state){
        $tbname = 'wm_goods';
        $sql = "UPDATE {$tbname} SET `is_del` = $state WHERE goods_id in $ids";
        return $this->db->doQuery($sql);
    }



}

