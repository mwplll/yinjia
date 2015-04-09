<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午5:11
 */
class LibDesignPic{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 获得设计方案的效果图
     * @param $designSchemaId
     * @return bool|mixed
     */
    public function getDesignPicsByDesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }
        $dal = new DBDesignPic();
        $result = $dal->getDesignPicsByDesignId($designSchemaId);
        return $result;
    }

    /**
     * 批量删除设计方案的效果图
     * @param $designSchemaId
     * @return bool|mixed
     */
    public function delDesignPicsByDesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }
        $dal = new DBDesignPic();
        $result = $dal->delDesignPicsByDesignId($designSchemaId);
        return $result;
    }

    /**
     * 批量添加设计方案效果图
     * @param array $designPics
     * @return bool|mixed
     */
    public function addDesignPics($designPics=array()){
        if(!$designPics){
            return FALSE;
        }
        $dal = new DBDesignPic();
        $result = $dal->addDesignPics($designPics);
        return $result;
    }

    /**
     * 批量更新设计方案效果图
     * @param array $designPics
     * @return bool|mixed
     */
    public function updateDesignPics($designPics=array()){
        if(!$designPics){
            return FALSE;
        }
        $dal = new DBDesignPic();
        $result = $dal->updateDesignPics($designPics);
        return $result;
    }





}