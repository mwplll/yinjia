<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-19
 * Time: 下午11:36
 */
class LibBrand{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 品牌列表
     * @param $start
     * @param $num
     * @return mixed
     */
    public function getBrandList($start,$num){
        $dal = new DBBrand();
        $brandList = $dal->getBrandList($start,$num);
        //print_r($brandList);
        if($brandList){
            foreach($brandList as &$brand){
                //print_r($brand);
                $seriesDB = new DBSeries();
                $brand['seriesList'] = $seriesDB->getSeriesListByBrandId($brand['brand_id']);
                //print_r($brand['seriesList']);
            }
            //print_r($brandList);
        }

        return $brandList;
    }

    /**
     * 品牌总个数
     * @return mixed
     */
    public function getBrandCount(){
        $dal = new DBBrand();
        return $dal->getBrandCount();
    }

    /**
     * 新增品牌
     * @param array $value
     * @return bool
     */
    public function addBrand($value=array()){
        if(!$value){
            return false;
        }

        $value['brand_sort'] = 0;
        $dal = new DBBrand();
        $result = $dal->addBrand($value);
        return $result;
    }

    /**
     * 获取品牌信息
     * @param $brandId
     * @return bool|mixed
     */
    public function getBrandById($brandId){
        if(!$this->isId($brandId)){
            return false;
        }
        $dal = new DBBrand();
        $return =  $dal->getBrandById($brandId);
        if($return){
            $seriesDB = new DBSeries();
            $return['seriesList'] = $seriesDB->getSeriesListByBrandId($brandId);
        }

        return $return;
    }

    /**
     * 更新品牌
     * @param array $value
     * @param $brandId
     * @return bool|mixed
     */
    public function updateBrand($value=array(),$brandId){
        if(!$value){
            return false;
        }

        if(!$this->isId($brandId)){
            return false;
        }
        $dal = new DBBrand();
        return $dal->updateBrand($value,$brandId);
    }

    /**
     * 批量添加商品系列
     * @param $series
     * @return bool
     */
    public function addSeries($series){
        if(!$series){
            return FALSE;
        }

        $dal = new DBSeries();
        $res = $dal->addSerieses($series);
        return $res;
    }

    /**
     * 批量更新同一品牌下的商品系列
     * @param $brandId
     * @param array $series
     * @return bool|mixed
     */
    public function updateSeries($brandId,$series=array()){
        if(!$this->isId($brandId)){
            return FALSE;
        }
        if(!$series){
            return FALSE;
        }

        $dal = new DBSeries();

        $res = $dal->updateSeries($brandId,$series);
        return $res;

    }

    /**
     * 批量假删除该品牌下的系列
     * @param $brandId
     * @return bool|mixed
     */
    public function delSeriesByBrandId($brandId){
        if(!$this->isId($brandId)){
            return FALSE;
        }

        $dal = new DBSeries();
        $res = $dal->delSeriesByBrandId($brandId);
        return $res;
    }




}