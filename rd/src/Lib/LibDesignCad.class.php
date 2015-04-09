<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午5:11
 */
class LibDesignCad{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 获得设计方案的施工图
     * @param $designSchemaId
     * @return bool|mixed
     */
    public function getDesignCadsByDesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }
        $dal = new DBDesignCad();
        $result = $dal->getDesignCadsByDesignId($designSchemaId);
        return $result;
    }

    /**
     * 批量删除设计方案的施工图
     * @param $designSchemaId
     * @return bool|mixed
     */
    public function delDesignCadsByDesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }
        $dal = new DBDesignCad();
        $result = $dal->delDesignCadsByDesignId($designSchemaId);
        return $result;
    }

    /**
     * 批量添加设计方案施工图
     * @param array $designCads
     * @return bool|mixed
     */
    public function addDesignCads($designCads=array()){
        if(!$designCads){
            return FALSE;
        }
        $dal = new DBDesignCad();
        $result = $dal->addDesignCads($designCads);
        return $result;
    }

    /**
     * 批量更新设计方案施工图
     * @param array $designCads
     * @return bool|mixed
     */
    public function updateDesignCads($designCads=array()){
        if(!$designCads){
            return FALSE;
        }
        $dal = new DBDesignCad();
        $result = $dal->updateDesignCads($designCads);
        return $result;
    }


}