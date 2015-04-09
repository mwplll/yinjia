<?php
class DBUserAction
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }


    /**
     * 创建收藏信息
     * @param array $value
     * @return mixed
     */
    public function addDesignCollection($value = array()){
        $tbName = 'wm_design_user';

        $ret = $this->db->makeInsertSQL($tbName, $value);
        if($ret){
            $ret = $this->db->doQuery($ret);
        }
        if($ret){
            $ret = $res = $this->db->getLastInsertID();
        }
        return $ret;
    }

    /**
     * 筛选出已经收藏的方案
     * @param $design_ids
     */
    public function filterDesignCollection($user_id, $design_ids){
//        if(!is_array($design_ids)){
//            return false;
//        }

        $tbName = 'wm_design_user';
        $ids = implode(',', $design_ids);
        $sql = "SELECT * FROM {$tbName} WHERE user_id = $user_id AND design_schema_id in ($ids) AND design_user_del = 0";
        //echo '$sql = '.$sql."\n";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

    /**
     * 将设计方案从收藏列表中删除
     * @param $user_id
     * @param $design_ids
     * @return mixed
     */
    public function delDesignCollection($user_id, $design_ids){

        $tbName = 'wm_design_user';
        $ids = implode(',', $design_ids);
        $sql = "UPDATE wm_design_user SET design_user_del = 1 WHERE user_id = $user_id AND design_schema_id in ($ids)";
        //echo '$sql = '.$sql."\n";
        $ret = $this->db->doQuery($sql);
        return $ret;
    }

    public function delMyDesignMaterial($user_id, $design_ids){

        $tbName = 'wm_material_user';
        $ids = implode(',', $design_ids);
        $sql = "UPDATE wm_material_user SET design_material_del = 1 WHERE user_id = $user_id AND design_schema_id in ($ids)";
        //echo '$sql = '.$sql."\n";
        $ret = $this->db->doQuery($sql);
        return $ret;
    }

    /**
     * 查询用户关联的收藏列表内容
     * @param $user_id
     * @return mixed
     */
    public function getDesignCollection($user_id){
        $tbName = 'wm_design_user';
        $sql = "SELECT design_schema_id FROM {$tbName} WHERE user_id = $user_id AND design_user_del = 0";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }


    /**
     * 生成购买订单
     * @param $values
     * @return mixed
     */
    public function createDesignOrder($values){
        $tbName = 'wm_orders';
        $sql = $this->db->makeInsertSql($tbName, $values);
        $ret = $this->db->doQuery($sql);

        if($ret){
            $ret = $this->db->getLastInsertID();
        }
        return $ret;
    }

    /**
     * 根据用户id查询订单列表
     */
    public function getDesignOrderByUid($uid)
    {
        //$tbName = 'wm_orders';
        $sql = "SELECT * FROM wm_orders WHERE wm_orders.user_id = {$uid} ORDER BY create_time DESC";
        $ret = $this->db->queryAllRows($sql);

        return $ret;
    }


    /**
     * 批量添加用户-设计方案建材清单
     * @param array $materials
     * @return mixed
     */
    public function addMyMaterials($materials = array()){
        $sql = $this->db->makeMutiInsertSQL('wm_material_user', $materials);
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
     * 获得用户的材料库
     * @param $designSchemaId
     * @param $userId
     * @return mixed
     */
    public function getMyMaterialListBydesignId($designSchemaId,$userId){
        $sql = "SELECT * FROM wm_material_user WHERE design_schema_id = {$designSchemaId} AND user_id = {$userId} AND design_material_del = 0";
        $ret = $this->db->queryAllRows($sql);
        return $ret;
    }

    /**
     * 批量更新用户建材清单
     * @param array $materials
     * @return mixed
     */
    public function updateMyMaterials($materials=array()){
        $ids = '';
        foreach($materials as $value){
            $ids.=$value['material_user_id'].',';
        }
        $ids = substr($ids,0,-1);   //需要更新的id
        //echo 'ids = ';
        //print_r($ids);
        //echo "\n";

        $sql = "UPDATE wm_material_user SET goods_id = CASE material_user_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['material_user_id'],$value['goods_id']);
        }
        $sql.="END,products_id = CASE material_user_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['material_user_id'],$value['products_id']);
        }
        $sql.="END,products_num = CASE material_user_id ";
        foreach($materials as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['material_user_id'],$value['products_num']);
        }
        $sql.="END WHERE material_user_id IN ($ids)";
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
    }
}