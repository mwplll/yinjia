<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:31
 */
class DBArticleCat
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
     * 文章分类列表
     * @return mixed
     */
    public function getArticleCatList(){
        $tbName = 'wm_article_category';
        $sql = "SELECT * FROM $tbName where cat_del in (0,2)";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * 更新文章分类
     * @param $catId
     * @param array $value
     * @return mixed
     */
    public function updateArticleCat($catId,$value=array())
    {
        $wh = array('cat_id' => $catId);
        $tb_name = 'wm_article_category';
        $sql = $this->db->makeUpdateSQL($tb_name, $value,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 根据id获得分类信息
     * @param $catId
     * @return mixed
     */
    public function getArticleCatById($catId){
        $tbname = 'wm_article_category';
        $sql = "SELECT * FROM $tbname where cat_id = $catId";
        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 新增分类
     * @param array $value
     * @return mixed
     */
    public function addArticleCat($value = array())
    {
        $tbname = 'wm_article_category';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        return $ret;
    }

    /**
     * 获得父分类下子分类的cat_layer的最大值
     * @param $catFatherId
     * @return mixed
     */
    public function getMaxChildrenCatLayer($catFatherId){
        $sql = "SELECT max(cat_layer) as maxCatLayer FROM wm_category WHERE cat_father = $catFatherId AND cat_del <> 1";
        //echo 'sql=  '.$sql."\n";
        $res = $this->db->queryFirstRow($sql);
        return $res['maxCatLayer'];

    }


}