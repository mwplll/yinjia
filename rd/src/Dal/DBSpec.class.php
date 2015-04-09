<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-20
 * Time: 下午9:43
 */
class DBSpec
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
     * 规格列表
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getSpecList($start,$num){
        $tbname = 'wm_spec';
        $sql = "SELECT * FROM $tbname where is_del = 0
                LIMIT $start,$num";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * 规格总数
     * @return mixed
     */
    public function getSpecCount(){
        $tbname = 'wm_spec';
        $sql = "SELECT count(*) as num FROM $tbname where is_del = 0";

        $result = $this->db->queryFirstRow($sql);
        return $result['num'];
    }

    /**
     * 根据id查询规格
     * @param $specId
     * @return mixed
     */
    public function getSpecById($specId){
        $sql = "SELECT * FROM wm_spec WHERE wm_spec.spec_id = $specId";

        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 增加规格
     * @param array $value
     * @return mixed
     */
    public function addSpec($value = array())
    {
        $tbname = 'wm_spec';

        $ret = $this->db->makeInsertSQL($tbname,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if($ret){
            $ret = $this->db->getLastInsertID();
        }
        return $ret;
    }

    /**
     * 更新规格
     * @param $updateInfo
     * @param $specId
     * @return mixed
     */
    public function updateSpec($updateInfo,$specId)
    {
        $wh = array('spec_id' => $specId);
        $tb_name = 'wm_spec';
        $sql = $this->db->makeUpdateSQL($tb_name, $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 批量删除规格图片
     * @param $ids
     * @return mixed
     */
    public function delSpecsByIds($ids){
        $tbname = 'wm_spec';
        $sql = "UPDATE {$tbname} SET `is_del` = 1 WHERE spec_id in $ids";
        return $this->db->doQuery($sql);
    }

    /**
     * 找出在当前规格中用到的规格图
     * @param $specPics
     * @return mixed
     */
    public function getSpecPicInSpec($specPics){
        $tbname = 'wm_spec_pic';
        $sql = "SELECT * FROM $tbname where spec_pic in $specPics";
        //echo '$sql = '.$sql;
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * 规格图片列表
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getSpecPicList($start,$num){
        $tbname = 'wm_spec_pic';
        $sql = "SELECT * FROM $tbname
                LIMIT $start,$num";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    /**
     * 规格图片总数
     * @return mixed
     */
    public function getSpecPicCount(){
        $tbname = 'wm_spec_pic';
        $sql = "SELECT count(*) as num FROM $tbname";

        $result = $this->db->queryFirstRow($sql);
        return $result['num'];
    }

    /**
     * 增加一系列规格图片
     * @param array $value
     * @return mixed
     */
    public function addSpecPics($value = array())
    {
        $tbname = 'wm_spec_pic';

        $ret = $this->db->makeMutiInsertSQL($tbname,$value);
        //echo '$ret = '.$ret;
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if($ret){
            $ret = $this->db->getLastInsertID();
        }
        return $ret;
    }

    /**
     * 批量删除规格图片i
     * @param $Ids
     * @return mixed
     */
    public function delSpecPicsByIds($Ids){
        $tbname = 'wm_spec_pic';
        $sql = "DELETE FROM {$tbname} WHERE spec_pic_id in $Ids";
        return $this->db->doQuery($sql);
    }

    /**
     * 更新规格图片
     * @param $updateInfo
     * @param $specPicId
     * @return mixed
     */
    public function updateSpecPic($updateInfo,$specPicId)
    {
        $wh = array('spec_pic_id' => $specPicId);
        $tb_name = 'wm_spec_pic';
        $sql = $this->db->makeUpdateSQL($tb_name, $updateInfo,$wh);
        return $this->db->doQuery($sql);
    }




}