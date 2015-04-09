<?php


class LibDesign
{
    /***********************************
     * utils
     ***********************************/
    /**
     * @param $id
     * @return bool
     */
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 新建设计图， 同时更新关联的户型图下的设计图数量
     * @param array $value
     * @return bool
     */
    public function addDesignInfo($value=array(),$is_copy=0){
        if(!$value){
            return false;
        }

        $value['create_time'] = time();
        $value['modify_time'] = $value['create_time'];

        $db = DBFactory::getInstance('DBDesign');
        $result = $db->addDesignInfo($value);

        if($result & !$is_copy){
            // 更新 wm_house_type 户型图里面的 design_num
            $houseLib = LibFactory::getInstance('LibHouse');
            $houseLib->addDesignNum($value['house_type_id']);

        }
        // 更新 wm_building 里面的total_design_num

        return $result;
    }

    /**
     * 更新设计方案信息表
     * @param array $value
     * @param $designId
     * @return bool
     */
    public function updateDesignInfo($value=array(),$designId){
        if(!$value){
            return false;
        }

        //方案更新时间
        $value['modify_time'] = time();

        $db = DBFactory::getInstance('DBDesign');
        $result = $db->updateDesignInfo($value,$designId);

        return $result;
    }




    /**
     * 根据户型 ID 查找设计图
     * @param $house_id
     * @return bool
     */
    public function searchDesignByHouseTypeId($houseTypeId,$start,$num,$en)
    {
        if(!$this->isId($houseTypeId))
        {
            return false;
        }

        $dal = new DBDesign();
        $result = $dal->searchDesignByHouseTypeId($houseTypeId,$start,$num,$en);

        return $result;

    }

    /**
     * 获得设计方案列表
     * @param array $wh
     * @param int $start
     * @param int $num
     * @return mixed
     */
    public function getDesignList($wh=array(),$start=0,$num=15)
    {
        $dal = DBFactory::getInstance('DBDesign');
        $result = $dal->getDesignList($wh,$start,$num);
        return $result;
    }

    /**
     * 函数名：getDesignCount
     * 作者：maoweipeng
     * 日期：2015-01-13
     * 功能：获得满足$wh条件的设计方案数量
     * @param array $wh
     * @return mixed
     */
    public function getDesignCount($wh=array())
    {
        $dal = new DBDesign();
        $result = $dal->getDesignCount($wh);
        return $result;
    }

    /**
     * 查找用于设计方案主页面展示的设计方案
     * @param
     * @return array
     */
    public function searchDesignForDisplay()
    {
        $dal = DBFactory::getInstance('DBDesign');
        $result = $dal->searchDesignForDisplay();

        return $result;

    }

    public function getDesignInfoByDesignID($designId)
    {
        if(!$this->isId($designId))
        {
            return false;
        }

        $dal = DBFactory::getInstance('DBDesign');
        $result = $dal->getDesignInfoByDesignID($designId);

        $designPriceObj = new LibDesignSchemaPrice();
        $result['total_price'] = $designPriceObj->getDesignSchemaTotalPrice($designId);

        return $result;

    }

    public function getDesignInfoByIds($design_ids)
    {
        $dal = DBFactory::getInstance('DBDesign');
        $result = $dal->getDesignInfoByIds($design_ids);
        return $result;
    }
}



