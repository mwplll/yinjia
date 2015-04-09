<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-8
 * Time: 下午12:57
 */
class DBManual
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
     * @param array $wh
     * @return mixed
     */
    public function getManualList($wh=array()){
        $style = isset($wh['design_style_id']) ? " AND wm_manual.design_style_id = " . $wh['design_style_id'] . " " : " ";
        $sql = "SELECT * FROM wm_manual INNER JOIN wm_design_style WHERE wm_manual.manual_del = 0 AND wm_design_style.design_style_del = 0
                AND wm_manual.design_style_id = wm_design_style.design_style_id $style";

        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

    /**
     * 添加施工报价方案
     * @param array $value
     * @return mixed
     */
    public function addDesignStyle($value=array()){
        $tbName = 'wm_design_style';

        $ret = $this->db->makeInsertSQL($tbName,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 更新施工报价方案
     * @param $id
     * @param array $value
     * @return mixed
     */
    public function updateDesignStyle($id,$value=array()){
        $wh = array('design_style_id' => $id);
        $tbName = 'wm_design_style';
        $sql = $this->db->makeUpdateSQL($tbName, $value,$wh);
        return $this->db->doQuery($sql);
    }

    /**
     * 批量添加施工项目报价
     * @param array $manuals
     * @return mixed
     */
    public function addManuals($manuals = array()){
        $sql = $this->db->makeMutiInsertSQL('wm_manual', $manuals);
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
     * 批量更新施工项目报价
     * @param array $manuals
     * @return mixed
     */
    public function updateManuals($manuals=array()){
        $ids = '';
        foreach($manuals as $value){
            $ids.=$value['manual_id'].',';
        }
        $ids = substr($ids,0,-1);
        //echo 'ids = ';
        //print_r($ids);
        //echo "\n";


        $sql = "UPDATE wm_manual SET manual_name = CASE manual_id ";
        foreach($manuals as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['manual_id'],$value['manual_name']);
        }
        $sql.="END,manual_del = CASE manual_id ";
        foreach($manuals as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['manual_id'],$value['manual_del']);
        }
        $sql.="END,design_style_id = CASE manual_id ";
        foreach($manuals as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['manual_id'],$value['design_style_id']);
        }
        $sql.="END,manual_price = CASE manual_id ";
        foreach($manuals as $value){
            $sql.=sprintf("WHEN %d THEN '%.2f' ",$value['manual_id'],$value['manual_price']);
        }
        $sql.="END WHERE manual_id IN ($ids)";
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
    }

    /**
     * 更新一个施工项目
     * @param $id
     * @param array $value
     * @return mixed
     */
    public function updateManual($id,$value=array()){
        $wh = array('manual_id' => $id);
        $tbName = 'wm_manual';
        $sql = $this->db->makeUpdateSQL($tbName, $value,$wh);
        return $this->db->doQuery($sql);
    }


}