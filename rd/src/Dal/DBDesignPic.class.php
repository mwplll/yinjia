<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午3:53
 */
class DBDesignPic
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
     * 批量添加效果图
     * @param $designPics
     * @return mixed
     */
    public function addDesignPics($designPics = array()){
        $sql = $this->db->makeMutiInsertSQL('wm_design_pic', $designPics);
        //echo '$sql = '.$sql;
        if($sql){
            $res = $this->db->doQuery($sql);
        }
        if($res){
            $res = $this->db->getLastInsertID();
        }
        return $res;
    }

    /**
     * 批量假删除设计方案的所有效果图
     * @param $designSchemaId
     * @return mixed
     */
    public function delDesignPicsByDesignId($designSchemaId){
        $tb_name = 'wm_design_pic';
        $sql = "UPDATE $tb_name SET design_pic_del = 1 WHERE design_schema_id = $designSchemaId";
        return $this->db->doQuery($sql);
    }

    /**
     * 批量更新设计方案的效果图
     * @param array $designPics
     * @return mixed
     */
    public function updateDesignPics($designPics=array()){
        $ids = '';
        foreach($designPics as $value){
            $ids.=$value['design_pic_id'].',';
        }
        $ids = substr($ids,0,-1);
        //echo 'ids = ';
        //print_r($ids);
        //echo "\n";


        $sql = "UPDATE wm_design_pic SET room_name = CASE design_pic_id ";
        foreach($designPics as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['design_pic_id'],$value['room_name']);
        }
        $sql.="END,design_pic_del = CASE design_pic_id ";
        foreach($designPics as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['design_pic_id'],0);
        }
        $sql.="END,design_pic = CASE design_pic_id ";
        foreach($designPics as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['design_pic_id'],$value['design_pic']);
        }
        $sql.="END WHERE design_pic_id IN ($ids)";
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
    }



    /**
     * 查询设计方案的所有效果图
     * @param $designSchemaId
     * @return mixed
     */
    public function getDesignPicsByDesignId($designSchemaId){
        $sql = "SELECT * FROM wm_design_pic WHERE wm_design_pic.design_schema_id = {$designSchemaId} AND wm_design_pic.design_pic_del = 0";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

}