<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-17
 * Time: 下午5:11
 */

class DBCategory
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
     * 获得分类列表,包括前台显示和不显示的，不包括已删除的
     * @return mixed
     */
    public function getCategoryList(){
        $tbname = 'wm_category';
        $sql = "SELECT * FROM $tbname where del in (0,2)";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * 根据id更新分类表
     * @param $value
     * @param $catId
     * @return mixed
     */
    public function updateCategory($value=array(),$catId)
    {
        $wh = array('cat_id' => $catId);
        $tb_name = 'wm_category';
        $sql = $this->db->makeUpdateSQL($tb_name, $value,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 根据id获得分类信息
     * @param $catId
     * @return mixed
     */
    public function getCategoryById($catId){
        $tbname = 'wm_category';
        $sql = "SELECT * FROM $tbname where cat_id = $catId";
        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 新增分类
     * @param array $value
     * @return mixed
     */
    public function addCategory($value = array())
    {
        $tbname = 'wm_category';

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
        $sql = "SELECT max(cat_layer) as maxCatLayer FROM wm_category WHERE cat_father = $catFatherId AND del <> 1";
        //echo 'sql=  '.$sql."\n";
        $res = $this->db->queryFirstRow($sql);
        return $res['maxCatLayer'];

    }


}