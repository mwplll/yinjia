<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:36
 */
class articleInfoApiAction extends baseAction{
    public function execute(){
        $articleObj = new LibArticle();
        $articleId = Dapper_Http_Request::getParam('id',NULL);

        if(!$articleId){
            return $this->api_error(FAILED,'please provide id');
        }
        else{
            $articleInfo = $articleObj->getArticleById($articleId);
        }
        //print_r($articleInfo);

        $mapArr = array(
            'id' => 'article_id',
            'title' => 'title',
            'content' => 'content',
            'summary' => 'summary',
            'author' => 'author',
            'pic' => 'pic',
            'modifyTime' => 'modify_time',
            'createTime' => 'create_time',
            'sort' => 'sort',
            'top' => 'top',
            'state' => 'article_del',
            'catId' => 'cat_id',
            'category' => 'cat_name'
        );
        if($articleInfo){
            $articleRes = $this->mapArray($mapArr,$articleInfo);
        }
        else{
            $articleRes = array();
        }

        //print_r($articleRes);
        if($articleInfo === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($articleRes);
        }
    }
}