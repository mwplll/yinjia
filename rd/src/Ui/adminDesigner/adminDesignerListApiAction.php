<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-6
 * Time: 下午4:40
 */
class adminDesignerListApiAction extends baseAction{
    public function execute(){
        $designerObj = new LibDesigner();
        $state = intval(Dapper_Http_Request::getParam('state'));
        $wh = array();
        switch($state){
            case 2:
                $wh['is_checked'] = 2;
                break;
            case 0:
                $wh['is_checked'] = 0;
                break;
            case 1:
                $wh['is_checked'] = 1;
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'state' param,0,1,or 2!");
                break;
        }

        $num = Dapper_Http_Request::getParam('num',10);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        //echo '$wh = '.$wh['is_checked'];
        if($wh){
            $DesignerList = $designerObj->getDesignerList($start,$num,$wh);
            $totalCount = (int)$designerObj->getDesignerCount($wh);
            $totalPage = ceil($totalCount / $num);

            $data = array(
                'designerlist' => $DesignerList,
                'pagination' => array(
                    'count' => $totalCount,
                    'page' => $totalPage
                ));
            //print_r($data);

            if($data === NULL){
                return $this->api_error(FAILED);
            }
            else{
                return $this->api_success($data);
            }
        }

    }

}

?>