<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-25
 * Time: 下午12:41
 */
class DBProducts
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
     * 根据商品id获得货品列表
     * @param $goodsId
     * @return mixed
     */
    public function getProductsListByGoodsId($goodsId){
        $tbname = 'wm_products';
        $sql = "SELECT * FROM $tbname where goods_id = $goodsId";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProductsById($id){
        $tbname = 'wm_products';
        $sql = "SELECT * FROM $tbname WHERE products_id = $id";
        //echo '$sql = '.$sql."\n";
        $res = $this->db->queryFirstRow($sql);
        //print_r($res);
        return $res;
    }

    /**
     * 批量添加货品
     * @param $products
     * @return mixed
     */
    public function addProducts($products){
        $sql = $this->db->makeMutiInsertSQL('wm_products', $products);
        //echo '$sql = '.$sql."\n";
        if($sql){
            $res = $this->db->doQuery($sql);
        }
        return $res;
    }

    /**
     * 批量删除同一商品的货品
     * @param $goodsId
     * @return mixed
     */
    public function delProductsBy($goodsId){
        $tb_name = 'wm_products';
        $sql = "DELETE FROM $tb_name WHERE goods_id = $goodsId";
        //echo '$sql = '.$sql;
        return $this->db->doQuery($sql);
    }

}