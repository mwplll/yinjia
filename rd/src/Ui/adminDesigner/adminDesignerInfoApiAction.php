<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-6
 * Time: 下午4:41
 */
class adminDesignerInfoApiAction extends baseAction{
    public function execute(){
        $designerObj = new LibDesigner();
        $designerId = Dapper_Http_Request::getParam('designer_id');

        if(!$designerId){
            return $this->api_error(FAILED,'please provide designer_id');
        }
        else{
            $res = $designerObj->getDesignerById($designerId);
        }

        if($res === FALSE)
            return $this->api_error(FAILED);
        else
            return $this->api_success($res);

    }
}

?>