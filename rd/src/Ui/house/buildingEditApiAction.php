<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:40
 */

class buildingEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "del":
                $this->del();
                break;
            case "add":
                $this->add();
                break;
            case "update":
                $this->update();
                break;
            case "recommend":
                $this->recommend();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 删除楼盘操作
     * @return bool
     */
    public function del(){
        $buildingObj = new LibBuilding();
        $buildId = Dapper_Http_Request::getParam('id');

        if(!$buildId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $data['building_del'] = 1;
            $res = $buildingObj->updateBuilding($data,$buildId);
        }

        if($res === FALSE)
            return $this->api_error(FAILED,'delete building failed!');
        else
            return $this->api_success($res);
    }

    /**
     * 新增楼盘操作
     * @return bool
     */
    public function add(){
        $buildingObj = new LibBuilding();
        $companyObj = new LibCompany();

        $buildData = array();
        $companyData = array();

        $buildData['city_id'] = Dapper_Http_Request::getParam('cityId');
        $buildData['area_id'] = Dapper_Http_Request::getParam('areaId');
        $buildData['building_name'] = Dapper_Http_Request::getParam('name');
        $companyData['company_name'] = Dapper_Http_Request::getParam('company');

        //判断所需的必要参数是否都提交
        if(!$buildData['city_id'] || !$buildData['area_id'] || !$buildData['building_name'] || !$companyData['company_name']){
            return $this->api_error(PARAM_ERROR,'please provide cityId,areaId,name,company!');
        }
        //查询该开发商是否在开发商表中，是则获得开发商id，否则添加开发商
        $companyInfo = $companyObj->getCompanyByName($companyData['company_name']);
        if(!$companyInfo){  //该开发商不在开发商表中
            $companyId = $companyObj->addCompany($companyData);
            if(!$companyId){
                return $this->api_error(FAILED,'add new company failed');
            }
            else{
                $buildData['company_id'] = $companyId;
            }

        }
        else{
            $buildData['company_id'] = $companyInfo['company_id'];
        }

        //添加楼盘信息
        $res = $buildingObj->addBuilding($buildData);
        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 更新楼盘信息，以及楼盘对应的开发商信息
     */
    public function update(){
        $buildingObj = new LibBuilding();
        $companyObj = new LibCompany();

        $buildData = array();
        $companyData = array();

        $buildId = intval(Dapper_Http_Request::getParam('id'));
        $buildData['city_id'] = Dapper_Http_Request::getParam('cityId');
        $buildData['area_id'] = Dapper_Http_Request::getParam('areaId');
        $buildData['company_id'] = intval(Dapper_Http_Request::getParam('companyId'));
        $buildData['building_name'] = Dapper_Http_Request::getParam('name');
        $companyId = $buildData['company_id'];
        $companyData['company_name'] = Dapper_Http_Request::getParam('company');

        if(!$buildId || !$buildData['city_id'] || !$buildData['area_id'] || !$buildData['company_id'] || !$buildData['building_name'] || !$companyData['company_name']){
            return $this->api_error(PARAM_ERROR,'please provide id,cityId,areaId,companyId,name,company!');
        }

        if(!$buildId){
            return $this->api_error(FAILED,'please provide building id!');
        }
        else{
            //print_r($buildData);
            $buildRes = $buildingObj->updateBuilding($buildData,$buildId);  //默认不改变房产公司id
        }

        if(!$companyId){
            return $this->api_error(FAILED,'please provide company id!');
        }
        else{
            $companyRes = $companyObj->updateCompany($companyData,$companyId);
        }

        if(!$buildRes || !$companyRes)
            return $this->api_error(FAILED);
        else
            return $this->api_success($buildRes && $companyRes);

    }

    /**
     * 设为推荐楼盘
     */
    public function recommend(){
        $buildingObj = new LibBuilding();

        $buildId = intval(Dapper_Http_Request::getParam('id',0));
        if(!$buildId){
            return $this->api_error(FAILED,'please provide building id!');
        }

        $data = array();
        $data['building_recommend'] = intval(Dapper_Http_Request::getParam('recommend',0));
        $res = $buildingObj->updateBuilding($data,$buildId);

        if(!$res)
            return $this->api_error(FAILED,'set the building as recommended building failed!');
        else
            return $this->api_success($res);

    }


}