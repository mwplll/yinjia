<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-4
 * Time: 下午6:59
 */
class DBSeries
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
     * 查询品牌下的产品系列
     * @param $brandId
     * @return mixed
     */
    public function getSeriesListByBrandId($brandId){
        $tbname = 'wm_series';
        $sql = "SELECT * FROM $tbname where brand_id = $brandId AND is_del = 0";
        $res = $this->db->queryAllRows($sql);
        return $res;
    }

    public function addSerieses($Series){
        $sql = $this->db->makeMutiInsertSQL('wm_series', $Series);
        if($sql){
            $res = $this->db->doQuery($sql);
        }
        return $res;
    }

    /**
     * 批量假删除同一品牌下的所有系列
     * @param $brandId
     * @return mixed
     */
    public function delSeriesByBrandId($brandId){
        //$is_del = (int)1;
        $tb_name = 'wm_series';
        $sql = "UPDATE $tb_name SET is_del = 1 WHERE brand_id = $brandId";
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
    }

    /**
     * 批量更新同一品牌下的所有系列
     * @param $brandId
     * @param array $series
     * @return mixed
     */
    public function updateSeries($brandId,$series=array()){
        /*$series = array(
            array(
                "series_id" => 1,
                "series_name" => 'x系列'
            ),
            array(
                "series_id" => 2,
                "series_name" => 'y系列'
            )
        );
        $brandId = 1;*/
        //echo '$series = ';
        //print_r($series);
        //echo "\n";
        $ids = '';
        foreach($series as $value){
            $ids.=$value['series_id'].',';
        }
        $ids = substr($ids,0,-1);
        //echo 'ids = ';
        //print_r($ids);
        //echo "\n";


        $sql = "UPDATE wm_series SET series_name = CASE series_id ";
        foreach($series as $value){
            $sql.=sprintf("WHEN %d THEN '%s' ",$value['series_id'],$value['series_name']);
        }
        $sql.="END,is_del = CASE series_id ";
        foreach($series as $value){
            $sql.=sprintf("WHEN %d THEN %d ",$value['series_id'],0);
        }
        $sql.="END WHERE series_id IN ($ids)";
        //echo '$sql = '.$sql."\n";
        return $this->db->doQuery($sql);
    }

}