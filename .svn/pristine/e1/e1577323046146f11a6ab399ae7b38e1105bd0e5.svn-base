<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 下午9:23
 */
class designCommentListApiAction extends baseAction{
    public function execute(){
        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $wh = array();  //查询条件
        $wh['design_schema_id'] = Dapper_Http_Request::getParam('designSchemaId',NULL);

        $designCommentObj = new LibDesignComment();
        $designCommentList = $designCommentObj->getDesignCommentList($start,$num,$wh);
        $totalCount = (int)$designCommentObj->getDesignCommentCount($wh);
        $totalPage = ceil($totalCount / $num);
        //print_r($designCommentList);

        //获得设计方案名称
        if($designCommentList){
            foreach($designCommentList as &$designComment){
                $designSchemaId = $designComment['design_schema_id'];
                $designSchemaObj = new LibDesignSchema();
                $designBaseInfo = $designSchemaObj->getDesignBaseInfoById($designSchemaId);
                $designComment['design_name'] = $designBaseInfo['design_name'];
                $designComment['house_type_id'] = $designBaseInfo['house_type_id'];
            }
        }

        $mapArr = array(
            'id' => 'design_comment_id',
            'designSchemaId' => 'design_schema_id',
            'designName' => 'design_name',
            'houseTypeId' => 'house_type_id',
            'userId' => 'user_id',
            'userName' => 'user_name',
            'avatar' => 'user_avatar',
            'content' => 'content',
            'time' => 'comment_time',
            'point' => 'point'
        );

        if($designCommentList){
            $commentRes = $this->mapArrays($mapArr,$designCommentList);
        }
        else{
            $commentRes = array();
        }

        $data = array(
            'commentList' => $commentRes,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));

        //print_r($data);
        if($designCommentList === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }


    }


}