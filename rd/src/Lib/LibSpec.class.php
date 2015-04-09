<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-20
 * Time: 下午9:42
 */
class LibSpec{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 规格列表
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getSpecList($start,$num){
        $dal = new DBSpec();
        return $dal->getSpecList($start,$num);
    }

    /**
     * 规格总数
     * @return mixed
     */
    public function getSpecCount(){
        $dal = new DBSpec();
        return $dal->getSpecCount();
    }

    /**
     * 根据id获得规格信息
     * @param $specId
     * @return bool|mixed
     */
    public function getSpecById($specId){
        if(!$this->isId($specId)){
            return false;
        }
        $dal = new DBSpec();
        return $dal->getSpecById($specId);
    }

    /**
     * 找出当前规格包含的图片
     * @param $specPics
     * @return bool|mixed
     */
    public function getSpecPicInSpec($specPics){
        $dal = new DBSpec();
        return $dal->getSpecPicInSpec($specPics);
    }

    /**
     * 增加规格
     * @param array $value
     * @return bool
     */
    public function addSpec($value=array()){
        if(!$value){
            return false;
        }

        $dal = new DBSpec();
        $result = $dal->addSpec($value);
        return $result;
    }

    /**
     * 更新规格
     * @param array $value
     * @param $specId
     * @return bool|mixed
     */
    public function updateSpec($value=array(),$specId){
        if(!$value){
            return false;
        }

        if(!$this->isId($specId)){
            return false;
        }
        $dal = new DBSpec();
        return $dal->updateSpec($value,$specId);
    }

    /**
     * 批量删除规格
     * @param $ids
     * @return mixed
     */
    public function delSpecsByIds($ids){
        $dal = new DBSpec();
        return $dal->delSpecsByIds($ids);
    }


    /**
     * 规格图片列表
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getSpecPicList($start,$num){
        $dal = new DBSpec();
        return $dal->getSpecPicList($start,$num);
    }

    /**
     * 规格图片总数
     * @return mixed
     */
    public function getSpecPicCount(){
        $dal = new DBSpec();
        return $dal->getSpecPicCount();
    }

    /**
     * 批量删除规格图片
     * @param $ids
     * @return mixed
     */
    public function delSpecPicsByIds($ids){
        $dal = new DBSpec();
        return $dal->delSpecPicsByIds($ids);
    }

    /**
     * 批量增加规格图片
     * @param $specPics
     * @return mixed
     */
    public function addSpecPics($specPics){
        foreach($specPics as &$specPic){
            $specPic['create_time'] = (int)time();
        }
        //print_r($specPics);
        $dal = new DBSpec();
        return $dal->addSpecPics($specPics);
    }

    /**
     * 更新规格图片
     * @param array $value
     * @param $specPicId
     * @return bool|mixed
     */
    public function updateSpecPic($value=array(),$specPicId){
        if(!$value){
            return false;
        }

        if(!$this->isId($specPicId)){
            return false;
        }
        $dal = new DBSpec();
        return $dal->updateSpecPic($value,$specPicId);
    }



}
