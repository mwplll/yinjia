<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:36
 */
class articleListApiAction extends baseAction{
    public function execute(){
        $articleObj = new LibArticle();

        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $wh = array();  //查询条件
        $wh['cat_id'] = Dapper_Http_Request::getParam('catId',NULL);
        $states = Dapper_Http_Request::getParam('states');
        if(!$states){
            $states = array(0);
        }

        $articleDel = '(';
        foreach($states as $k=>$v){
            $articleDel = $articleDel.$v.',';
        }
        $articleDel = substr($articleDel,0,-1);
        $articleDel = $articleDel.')';
        $wh['article_del'] = $articleDel;

        $articleList = $articleObj->getArticleList($start,$num,$wh);
        $totalCount = (int)$articleObj->getArticleCount($wh);
        $totalPage = ceil($totalCount / $num);

        //输出映射表
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
        if($articleList){
            $articleRes = $this->mapArrays($mapArr,$articleList);
        }
        else{
            $articleRes = array();
        }

        $data = array(
            'articleList' => $articleRes,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));

        //print_r($data);
        if($articleList === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }
    }
}