<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:36
 */
class articleEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "del":
                $this->del();
                break;
            case "save":
                $this->save();
                break;
            case "sort":
                $this->sort();
                break;
            case "top":
                $this->top();
                break;

            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    /**
     * 删除、使前台显示、前台不显示文章
     * @return bool
     */
    public function del(){
        $articleObj = new LibArticle();
        $articleId = Dapper_Http_Request::getParam('id',NULL);
        $wh['article_del'] = intval(Dapper_Http_Request::getParam('state',0));

        if(!$articleId){
            return $this->api_error(PARAM_ERROR,'please provide id');
        }

        $res = $articleObj->updateArticle($articleId,$wh);

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }
    }

    /**
     * 排序
     * @return bool
     */
    public function sort(){
        $articleObj = new LibArticle();
        $articleId = Dapper_Http_Request::getParam('id',NULL);
        $wh['sort'] = intval(Dapper_Http_Request::getParam('sort',99));

        if(!$articleId){
            return $this->api_error(PARAM_ERROR,'please provide id');
        }

        $res = $articleObj->updateArticle($articleId,$wh);

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }
    }

    /**
     * 置顶
     * @return bool
     */
    public function top(){
        $articleObj = new LibArticle();
        $articleId = Dapper_Http_Request::getParam('id',NULL);
        $wh['top'] = intval(Dapper_Http_Request::getParam('top',0));

        if(!$articleId){
            return $this->api_error(PARAM_ERROR,'please provide id');
        }

        $res = $articleObj->updateArticle($articleId,$wh);

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }
    }

    /**
     * 保存文章
     * @return bool
     */
    public function save(){
        $articleObj = new LibArticle();
        $articleId = Dapper_Http_Request::getParam('id',NULL);

        $data['cat_id'] = intval(Dapper_Http_Request::getParam('catId',NULL));
        $data['title'] = Dapper_Http_Request::getParam('title',NULL);
        $data['content'] = Dapper_Http_Request::getParam('content',NULL);
        $data['summary'] = Dapper_Http_Request::getParam('summary',NULL);
        $data['author'] = Dapper_Http_Request::getParam('author','系统管理员');
        $data['pic'] = Dapper_Http_Request::getParam('pic',NULL);
        $data['article_del'] = intval(Dapper_Http_Request::getParam('state',0));
        $data['sort'] = intval(Dapper_Http_Request::getParam('sort',99));
        $data['top'] = intval(Dapper_Http_Request::getParam('top',0));

        if(!$data['cat_id'] | !$data['title'] | !$data['summary'] | !$data['pic']){
            return $this->api_error(PARAM_ERROR,"please provide catId,title,summary,pic! ");
        }

        if($articleId){
            $res = $articleObj->updateArticle($articleId,$data);
        }
        else{
            $res = $articleObj->addArticle($data);
        }

        if($res === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($res);
        }

    }

}