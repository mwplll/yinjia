<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 下午9:23
 */
class designCommentEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "del":
                $this->del();
                break;
            case "save":
                $this->save();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 删除操作
     * @return bool
     */
    public function del(){
        $commentObj = new LibDesignComment();
        $commentId = Dapper_Http_Request::getParam('id',NULL);
        $wh['design_comment_del'] = 1;

        if(!$commentId){
            return $this->api_error(PARAM_ERROR,'please provide id');
        }

        $res = $commentObj->updateDeisgnComment($commentId,$wh);

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }
    }

    /**
     * 保存操作
     * @return bool
     */
    public function save(){
        $commentObj = new LibDesignComment();

        $data=array();//新增评论数据
        $data['design_schema_id'] = intval(Dapper_Http_Request::getParam('designSchemaId',NULL));
        $data['content'] = Dapper_Http_Request::getParam('content',NULL);
        $data['point'] = intval(Dapper_Http_Request::getParam('point',NULL));

        if(!$data['design_schema_id'] | !$data['content']){
            return $this->api_error(PARAM_ERROR,"please provide designSchemaId,content");
        }

        if(!$data['point']){
            $data['point'] = 5;
        }

        $this->checkLogin();  //判断是否是登录用户
        $data['user_id'] = $this->loginUid;
        if(!$data['user_id']){
            return $this->api_error(PARAM_ERROR,"您还没有登录，只有登录后的用户才能发表评论哦");
        }

        $commentId = $commentObj->addDeisgnComment($data);

        if($commentId){
            $designSchemaObj = new LibDesignSchema();
            $designSchemaObj->addCommentNum($data['design_schema_id']);
        }

        if($commentId === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($commentId);
        }

    }




}