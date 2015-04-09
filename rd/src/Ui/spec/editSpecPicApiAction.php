<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-20
 * Time: 下午11:43
 */
class editSpecPicApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "delete":
                $this->delete();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    public function delete(){
        $specObj = new LibSpec();
        $ids = Dapper_Http_Request::getParam('ids');

        if(!$ids){
            return $this->api_error(FAILED,'please provide ids');
        }
        else{
            //输入数据库数据处理
            $specPicsIds = str_replace("[","(",$ids);
            $specPicsIds = str_replace("]",")",$specPicsIds);
            $res = $specObj->delSpecPicsByIds($specPicsIds);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }


}