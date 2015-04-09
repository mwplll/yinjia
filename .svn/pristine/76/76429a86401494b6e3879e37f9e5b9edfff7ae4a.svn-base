<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-3-18
 * Time: 下午7:48
 */
class designManualEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "select":
                $this->select();
                break;
            case "add":
                $this->add();
                break;
            case "update":
                $this->update();
                break;
            case "delManual":
                $this->delManual();
                break;
            case "del":
                $this->delDesignStyle();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 为设计方案选择施工报价方案
     * @return bool
     */
    public function select(){
        $designSchemaId = Dapper_Http_Request::getParam('id');
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,'please provide design schema id');
        }

        $designStyleId = Dapper_Http_Request::getParam('styleId');
        if(!$designStyleId){
            return $this->api_error(PARAM_ERROR,'please provide design style id');
        }
        $data['design_style_id'] = $designStyleId;

        $designSchemaObj = new LibDesignSchema();
        $res = $designSchemaObj->updateDesignSchema($designSchemaId,$data);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 添加施工报价方案
     * @return bool
     */
    public function add(){
        $styleData = array();
        $styleData['design_style_name'] = Dapper_Http_Request::getParam('name','');
        if(!$styleData['design_style_name']){
            return $this->api_error(PARAM_ERROR,'please provide design style name');
        }

        $manualObj = new LibManual();
        $designStyleId = $manualObj->addDesignStyle($styleData);  //添加报价方案

        $manualData = array();
        $manualList = Dapper_Http_Request::getParam('manualList','');
        if(!$manualList){
            return $this->api_error(PARAM_ERROR,'please provide manualName,price');
        }

        foreach($manualList as $manual){
            array_push($manualData,array(
                "design_style_id" => $designStyleId,
                "manual_name" => $manual['manualName'],
                "manual_del" => 0,
                "manual_price" => $manual['price']
            ));
        }

        $res = $manualObj->addManuals($manualData); //批量添加施工项目报价

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 更新施工报价方案
     * @return bool
     */
    public function update(){
        $res = TRUE;
        $styleData = array();
        $designStyleId = Dapper_Http_Request::getParam('id');
        $styleData['design_style_name'] = Dapper_Http_Request::getParam('name','');
        /*if(!$styleData['design_style_name'] | !$styleData['design_style_id']){
            return $this->api_error(PARAM_ERROR,'please provide design style name,id');
        }*/

        $manualObj = new LibManual();
        if($designStyleId){
            $res = $manualObj->updateDesignStyle($designStyleId,$styleData);  //更新报价方案
        }

        $manualData = array();
        $manualList = Dapper_Http_Request::getParam('manualList',array());
        /*if(!$manualList){
            return $this->api_error(PARAM_ERROR,'please provide manualName,price');
        }*/

        if($manualList){
            foreach($manualList as $manual){
                array_push($manualData,array(
                    "design_style_id" => $designStyleId,
                    "manual_name" => $manual['manualName'],
                    "manual_id" => $manual['manualId'],
                    "manual_del" => 0,
                    "manual_price" => $manual['price']
                ));
            }

            $res = $manualObj->updateManuals($manualData); //批量更新施工项目报价
        }


        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }

    /**
     * 删除报价方案
     * @return bool
     */
    public function delDesignStyle(){
        $styleData = array();
        $designStyleId = Dapper_Http_Request::getParam('id');
        if(!$designStyleId){
            return $this->api_error(PARAM_ERROR,'please provide id');
        }
        $styleData['design_style_del'] = 1;

        $manualObj = new LibManual();
        $res = $manualObj->updateDesignStyle($designStyleId,$styleData);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }

    /**
     * 删除施工报价项目
     * @return bool
     */
    public function delManual(){
        $manualData = array();
        $manualId = Dapper_Http_Request::getParam('id');
        if(!$manualId){
            return $this->api_error(PARAM_ERROR,'please provide id');
        }
        $manualData['manual_del'] = 1;

        $manualObj = new LibManual();
        $res = $manualObj->updateManual($manualId,$manualData);

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);
    }


}