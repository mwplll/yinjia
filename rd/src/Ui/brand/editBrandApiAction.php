<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:40
 */

class editBrandApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "delete":
                $this->delete();
                break;
            case "save":
                $this->save();
                break;
            case "sort":
                $this->sort();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }


    /**
     * 删除品牌
     * @return bool
     */
    public function delete(){
        $brandObj = new LibBrand();
        $brandId = Dapper_Http_Request::getParam('id');

        if(!$brandId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $data['is_del'] = 1;  //删除操作为假删除，将is_del置为1表示删除
            $res = $brandObj->updateBrand($data,$brandId);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }

    /**
     * 品牌排序
     * @return bool
     */
    public function sort(){
        $brandObj = new LibBrand();
        $brandId = Dapper_Http_Request::getParam('id');
        $sort = (int)Dapper_Http_Request::getParam('sort');

        if(!$brandId || !$sort){
            return $this->api_error(FAILED,'please provide id,sort');
        }
        else{
            $data['brand_sort'] = $sort;
            $res = $brandObj->updateBrand($data,$brandId);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }


    /**
     * 保存品牌
     * @return bool
     */
    public function save(){
        $brandObj = new LibBrand();


        $addData = array();
        $updateData = array();

        $brandId = Dapper_Http_Request::getParam('id');
        $addData['brand_name'] = Dapper_Http_Request::getParam('name');
        $addData['eng_name'] = Dapper_Http_Request::getParam('enName');
        $addData['brand_logo'] = Dapper_Http_Request::getParam('logo');
        $addData['brand_desc'] = Dapper_Http_Request::getParam('content');
        $addData['brand_sort'] = Dapper_Http_Request::getParam('sort');
        $addData['brand_url'] = Dapper_Http_Request::getParam('url');

        if(!$addData['brand_name']){
            return $this->api_error(PARAM_ERROR,'please provide name ');
        }

        if(!$brandId){
            $res = $brandObj->addBrand($addData);
            $brandId = $res;  //品牌添加成功返回Id
            $this->_addSeries($brandId);
        }
        else{
            $updateData = $addData;
            $res = $brandObj->updateBrand($updateData,$brandId);
            $brandObj->delSeriesByBrandId($brandId);
            $this->_updateSeries($brandId);  //更新该品牌下已有的系列
            $this->_addSeries($brandId);
        }

        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    private function _gatherSeries(){
        $seriesNameArr = Dapper_Http_Request::getParam('seriesName',NULL);
        $seriesIdArr = Dapper_Http_Request::getParam('seriesId',NULL);

        $newSeries = array();    //新增的系列
        $updateSeries = array();   //需要更新的系列
        $num = count($seriesNameArr);
        //echo 'count($arrGoodsPics) = '.count($arrGoodsPics)."\n";
        if(($num >= 1) && ($num == count($seriesIdArr))){
            foreach($seriesNameArr as $k => $v){
                if(isset($seriesIdArr[$k]) && $seriesIdArr[$k] != NULL){
                    array_push($updateSeries,array(
                        "series_id" => $seriesIdArr[$k],
                        "series_name" => $v
                    ));
                }
                else{
                    array_push($newSeries,array(
                        "series_name" => $v
                    ));
                }
            }

            $series = array();
            $series['new'] = $newSeries;
            $series['update'] = $updateSeries;
            return $series;
        }
        return FALSE;
}

    private function _updateSeries($brandId){
        $series = $this->_gatherSeries();
        $brandObj = new LibBrand();

        if($series['update']){
            $addRes = $brandObj->updateSeries($brandId,$series['update']);
            //echo 'update series'."\n";
            return $addRes;
        }
        return FALSE;
    }

    private function _addSeries($brandId){
        $series = $this->_gatherSeries();
        $brandObj = new LibBrand();

        if($series['new']){
            foreach($series['new'] as &$value){
                $value['brand_id'] = $brandId;
            }
            $updateRes = $brandObj->addSeries($series['new']);
            //echo 'add series'."\n";
            return $updateRes;
        }

        return FALSE;

    }




}