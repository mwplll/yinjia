<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午3:53
 */
class DBDesignCad
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
     * 批量添加施工图
     * @param array $designCads
     * @return mixed
     */
    public function addDesignCads($designCads = array()){
        $sql = $this->db->makeMutiInsertSQL('wm_design_cad', $designCads);
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
     * @param $designSchemaId
     * @return mixed
     */
    public function delDesignCadsByDesignId($designSchemaId){
        $tb_name = 'wm_design_cad';
        $sql = "UPDATE $tb_name SET design_cad_del = 1 WHERE design_schema_id = $designSchemaId";
        return $this->db->doQuery($sql);
    }

    /**
     * @param array $designCads
     * @return mixed
     */
    public function updateDesignCads($designCads=array()){
        $ids = '';
        foreach($designCads as $value){
            $ids.=$value['design_cad_id'].',';
        }
        $ids = substr($ids,0,-1);
        //echo 'ids = ';
        //print_r($ids);
        //echo "\n";


        $sql = "UPDATE wm_design_cad SET cad_name = CASE design_cad_id ";
        foreach($designCads as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['design_cad_id'],$value['cad_name']);
        }
        $sql.="END,design_cad_del = CASE design_cad_id ";
        foreach($designCads as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['design_cad_id'],0);
        }
        $sql.="END,design_cad = CASE design_cad_id ";
        foreach($designCads as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['design_cad_id'],$value['design_cad']);
        }
        $sql.="END WHERE design_cad_id IN ($ids)";
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
    }

    /**
     * @param $designSchemaId
     * @return mixed
     */
    public function getDesignCadsByDesignId($designSchemaId){
        $sql = "SELECT * FROM wm_design_cad WHERE wm_design_cad.design_schema_id = {$designSchemaId} AND wm_design_cad.design_cad_del = 0";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }
}