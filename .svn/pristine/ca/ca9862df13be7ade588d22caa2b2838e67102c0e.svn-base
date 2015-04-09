<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-12
 * Time: 下午11:40
 */

class editBuildingApiAction1 extends baseAction{   //NOT USE
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "delete":
                $this->delete();
                break;
            case "add":
                $this->add();
                break;
            case "update":
                $this->update();
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
    public function delete(){
        $buildingObj = new LibBuilding();
        $buildId = Dapper_Http_Request::getParam('build_id');

        if(!$buildId){
            return $this->api_error(FAILED,'please provide build_id');
        }
        else{
            $data['build_enable'] = 0;  //删除操作为假删除，将enable置为0表示不显示
            $res = $buildingObj->updateBuilding($data,$buildId);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
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

        $buildData['city_id'] = Dapper_Http_Request::getParam('city_id');
        $buildData['area_id'] = Dapper_Http_Request::getParam('area_id');
        $buildData['building_name'] = Dapper_Http_Request::getParam('name');
        $companyData['company_name'] = Dapper_Http_Request::getParam('company');

        if(!$buildData['city_id'] || !$buildData['building_name'] || !$companyData['company_name']){
            return $this->api_error(PARAM_ERROR,'please provide city_id,company_id,name,company!');
        }
        //查询该开发商是否在开发商表中，是则获得开发商id，否则添加开发商
        $companyInfo = $companyObj->getCompanyByName($companyData['company_name']);
        if(!$companyInfo){  //该开发商不在开发商表中
            $companyId = $companyObj->addCompany($companyData);
            if(!$companyId){
                return $this->api_error(FAILED,'add company failed');
            }
            else{
                $buildData['company_id'] = $companyId;
            }

        }
        else{
            $buildData['company_id'] = $companyInfo['company_id'];
        }

        //添加楼盘表信息
        $res = $buildingObj->addBuilding($buildData);
        if(!$res)
            return $this->api_error(FAILED);
        else
            return $this->api_success($buildData);

    }

    /**
     * 更新楼盘信息，以及楼盘对应的开发商信息
     */
    public function update(){
        $buildingObj = new LibBuilding();
        $companyObj = new LibCompany();

        $buildData = array();
        $companyData = array();

        $buildId = intval(Dapper_Http_Request::getParam('build_id'));
        $buildData['city_id'] = Dapper_Http_Request::getParam('city_id');
        $buildData['area_id'] = Dapper_Http_Request::getParam('area_id');
        $buildData['company_id'] = intval(Dapper_Http_Request::getParam('company_id'));
        $buildData['building_name'] = Dapper_Http_Request::getParam('name');
        $companyId = $buildData['company_id'];
        $companyData['company_name'] = Dapper_Http_Request::getParam('company');

        if(!$buildData['city_id'] || !$buildData['company_id'] || !$buildData['building_name'] || !$companyData['company_name']){
            return $this->api_error(PARAM_ERROR,'please provide city_id,company_id,name,company!');
        }

        if(!$buildId){
            return $this->api_error(FAILED,'please provide build_id');
        }
        else{
            //print_r($buildData);
            $buildRes = $buildingObj->updateBuilding($buildData,$buildId);
        }

        if(!$companyId){
            return $this->api_error(FAILED,'please provide company_id');
        }
        else{
            $companyRes = $companyObj->updateCompany($companyData,$companyId);
        }

        if(!$buildRes || !$companyRes)
            return $this->api_error(FAILED);
        else
            return $this->api_success($buildRes && $companyRes);

    }


}