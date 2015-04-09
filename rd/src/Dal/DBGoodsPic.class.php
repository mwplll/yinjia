<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-25
 * Time: 下午1:24
 */
class DBGoodsPic
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
     * 根据商品id获得商品图片列表
     * @param $goodsId
     * @return mixed
     */
    public function getGoodsPicListByGoodsId($goodsId){
        $sql = "SELECT * FROM wm_goods_pic INNER JOIN wm_goods_pic_rel WHERE
                wm_goods_pic.pic_id = wm_goods_pic_rel.pic_id AND wm_goods_pic_rel.goods_id = $goodsId";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    public function searchPicByPic($id){
        $sql = "SELECT * FROM wm_goods_pic WHERE wm_goods_pic.pic_id = '$id'";
        //echo '$sql = '.$sql."\n";
        $res =  $this->db->queryFirstRow($sql);
        //echo '$res = '.$res."\n";
        return $res;
    }

    /**
     * 批量增加商品图库
     * @param $pics
     * @return mixed
     */
    public function addGoodsPics($pics){
        $sql = $this->db->makeMutiInsertSQL('wm_goods_pic', $pics);
        if($sql){
            $res = $this->db->doQuery($sql);
        }
        return $res;
    }

    public function addGoodsPicRels($goodsPicRels){
        $sql = $this->db->makeMutiInsertSQL('wm_goods_pic_rel', $goodsPicRels);
        if($sql){
            $res = $this->db->doQuery($sql);
        }
        return $res;
    }

    /**
     * 批量删除同一商品的商品图片关系
     * @param $goodsId
     * @return mixed
     */
    public function delGoodsPicRelsByGoodsId($goodsId){
        $tb_name = 'wm_goods_pic_rel';
        $sql = "DELETE FROM $tb_name WHERE goods_id = $goodsId";
        //echo '$sql = '.$sql;
        return $this->db->doQuery($sql);
    }

}