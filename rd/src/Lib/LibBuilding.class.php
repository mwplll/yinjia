<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:40
 */
class LibBuilding{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 按一定条件查询获得楼盘列表
     * @param array $wh
     * @param int $start
     * @param int $num
     * @return bool
     */
    public function getBuildingList($start=0,$num=15,$wh=array()){
        $dal = new DBBuilding();
        return $dal->getBuildingList($start,$num,$wh);
    }

    /**
     * 获取满足wh条件的楼盘总数
     * @param array $wh
     * @return bool
     */
    public function getBuildingCount($wh=array()){
        $dal = new DBBuilding();
        return $dal->getBuildingCount($wh);
    }

    /**
     * 通过id获取楼盘信息
     * @param $buildId
     * @return bool
     */
    public function getBuildingById($buildId){
        if(!$this->isId($buildId)){
            return FALSE;
        }
        $dal = new DBBuilding();
        return $dal->getBuildingById($buildId);
    }

    /**
     * 根据楼盘id删除楼盘信息
     * @param $buildId
     * @return bool
     */
    public function deleteBuilding($buildId){
        if(!$this->isId($buildId)){
            return FALSE;
        }
        $dal = DBFactory::getInstance('DBBuilding');
        return $dal->deleteBuilding($buildId);
    }

    /**
     * 更新楼盘信息
     * @param $value
     * @param $buildId
     * @return bool
     */
    public function updateBuilding($value,$buildId){
        if(!$value){
            return FALSE;
        }
        if(!$this->isId($buildId)){
            return FALSE;
        }
        $dal = new DBBuilding();
        //$dal = DBFactory::getInstance('DBBuilding');
        return $dal->updateBuilding($value,$buildId);
    }

    /**
     * 添加楼盘信息
     * @param $value
     * @return bool|mixed
     */
    public function addBuilding($value){
        if(!$value){
            return FALSE;
        }
        $dal = new DBBuilding();
        return $dal->addBuilding($value);
    }


}

