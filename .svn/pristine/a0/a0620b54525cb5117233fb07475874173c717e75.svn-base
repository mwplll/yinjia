<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-6
 * Time: 下午4:42
 */
class editAdminDesignerApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "update":
                $this->update();
                break;
            case "del":
                $this->del();
                break;
            case "check":
                $this->check();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    public function del(){
        $designerObj = new LibDesigner();
        $userObj = new LibUser();
        $designerId = Dapper_Http_Request::getParam('designer_id');

        if(!$designerId){
            return $this->api_error(FAILED,'please provide designer_id');
        }
        else{
            $designer = $designerObj->getDesignerById($designerId);
            $userId = $designer['user_id'];

            $designerRes = $designerObj->delDesignerById($designerId);
            $userRes = $userObj->delUserById($userId);
        }

        if($designerRes === FALSE || $userRes === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($designerRes);
    }

    public function update(){
        $designerObj = new LibDesigner();
        $userObj = new LibUser();
        $designerId = Dapper_Http_Request::getParam('designer_id');

        $userData = array();
        $designerData = array();
        $userData['user_tel'] = Dapper_Http_Request::getParam('tel');
        $designerData['true_name'] = Dapper_Http_Request::getParam('name');
        $designerData['cid'] = Dapper_Http_Request::getParam('cid');

        if(!$designerId){
            return $this->api_error(FAILED,'please provide designer_id');
        }
        else{
            $designer = $designerObj->getDesignerById($designerId);
            $userId = $designer['user_id'];
            $userRes = $userObj->updateUser($userData,$userId);

            $designerRes = $designerObj->updateDesigner($designerData,$designerId);
        }

        if($designerRes === FALSE || $userRes === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($designerRes);
    }

    public function check(){
        $designerObj = new LibDesigner();
        $designerId = Dapper_Http_Request::getParam('designer_id');
        $isChecked = Dapper_Http_Request::getParam('is_ok',2);


        $designerData = array();
        $designerData['is_checked'] = $isChecked;
        if(!$isChecked){
            $designerData['fail_reason'] = Dapper_Http_Request::getParam('reason');
            if(!$designerData['fail_reason']){
                return $this->api_error(FAILED,'请填写审核失败原因！');
            }
        }

        if(!$designerId){
            return $this->api_error(FAILED,'please provide designer_id');
        }
        else{
            $designerRes = $designerObj->updateDesigner($designerData,$designerId);
        }

        if($designerRes === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($designerRes);
    }





}

?>