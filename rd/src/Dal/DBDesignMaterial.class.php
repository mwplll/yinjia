<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午11:57
 */
class DBDesignMaterial
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
     * 获得一个房间的所有材料列表
     * @param $designRoomId
     * @return mixed
     */
    public function getMaterialListByRoomId($designRoomId){
        $sql = "SELECT * FROM wm_design_material WHERE design_room_id = {$designRoomId} AND design_material_del = 0";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

    /**
     * 获得一个设计方案的所有材料列表
     * @param $designSchemaId
     * @return mixed
     */
    public function getMaterialListBydesignId($designSchemaId){
        $sql = "SELECT * FROM wm_design_material WHERE design_schema_id = {$designSchemaId} AND design_material_del = 0";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

    /**
     * 假删除该房间下的所有材料
     * @param $roomId
     * @return mixed
     */
    public function delMaterialByRoomId($roomId){
        $tbName = 'wm_design_material';
        $sql = "UPDATE {$tbName} SET design_material_del = 1 WHERE design_room_id = $roomId";
        return $this->db->doQuery($sql);
    }

    /**
     * 将一个设计方案的所有建材置为无效
     * @param $designSchemaId
     * @return mixed
     */
    public function delMaterialByDesignId($designSchemaId){
        $tbName = 'wm_design_material';
        $sql = "UPDATE {$tbName} SET design_material_del = 1 WHERE design_schema_id = $designSchemaId";
        return $this->db->doQuery($sql);
    }

    /**
     * 批量添加建材清单
     * @param array $materials
     * @return mixed
     */
    public function addMaterials($materials = array()){
        $sql = $this->db->makeMutiInsertSQL('wm_design_material', $materials);
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
     * 批量更新建材清单
     * @param array $materials
     * @return mixed
     */
    public function updateMaterials($materials=array()){
        $ids = '';
        foreach($materials as $value){
            $ids.=$value['design_material_id'].',';
        }
        $ids = substr($ids,0,-1);   //需要更新的id
        //echo 'ids = ';
        //print_r($ids);
        //echo "\n";


        $sql = "UPDATE wm_design_material SET design_schema_id = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['design_material_id'],$value['design_schema_id']);
        }
        $sql.="END,design_material_del = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['design_material_id'],0);
        }
        $sql.="END,design_room_id = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['design_material_id'],$value['design_room_id']);
        }
        $sql.="END,design_material_number = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['design_material_id'],$value['design_material_number']);
        }
        $sql.="END,design_material_name = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['design_material_id'],$value['design_material_name']);
        }
        $sql.="END,goods_id = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['design_material_id'],$value['goods_id']);
        }
        $sql.="END,products_id = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['design_material_id'],$value['products_id']);
        }
        $sql.="END,products_num = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['design_material_id'],$value['products_num']);
        }
        $sql.="END,designer_content = CASE design_material_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['design_material_id'],$value['designer_content']);
        }
        $sql.="END WHERE design_material_id IN ($ids)";
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
    }





}