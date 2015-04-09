<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:31
 */
class DBArticle
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Dapper_Model_DB::getInstance('zjd');
    }

    public function __destruct()
    {
        $this->db = null;
    }

    /**
     * 满足一定条件的文章列表
     * @param int $start
     * @param int $num
     * @param array $wh
     * @return mixed
     */
    public function getArticleList($start=0,$num=15,$wh=array()){
        $category = isset($wh['cat_id']) ? " AND wm_article.cat_id = " . $wh['cat_id'] . " " : " ";
        $isDel = isset($wh['article_del']) ? " AND wm_article.article_del in " . $wh['article_del'] . " " : " ";
        $sql = "SELECT * FROM wm_article INNER JOIN wm_article_category WHERE wm_article.cat_id = wm_article_category.cat_id $category $isDel
                ORDER BY wm_article.top DESC, wm_article.sort ASC, wm_article.modify_time DESC
                LIMIT $start,$num";
        //echo '$sql = '.$sql."\n";
        $res = $this->db->queryAllRows($sql);
        //print_r($res);
        return $res;
    }

    /**
     * 满足一定条件的文章数量
     * @param array $wh
     * @return mixed
     */
    public function getArticleCount($wh=array()){
        $category = isset($wh['cat_id']) ? " AND wm_article.cat_id = " . $wh['cat_id'] . " " : " ";
        $isDel = isset($wh['article_del']) ? " AND wm_article.article_del in " . $wh['article_del'] . " " : " ";
        $sql = "SELECT count(*) as num FROM wm_article INNER JOIN wm_article_category WHERE wm_article.cat_id = wm_article_category.cat_id $category $isDel
                ";

        $result = $this->db->queryFirstRow($sql);
        return $result['num'];

    }

    /**
     * 根据Id提取文章
     * @param $id
     * @return mixed
     */
    public function getAtricleById($id){
        $sql = "SELECT * FROM wm_article INNER JOIN wm_article_category
                WHERE wm_article.cat_id = wm_article_category.cat_id AND wm_article.article_id = $id";

        $res = $this->db->queryFirstRow($sql);
        return $res;
    }

    /**
     * 新增文章
     * @param array $value
     * @return mixed
     */
    public function addArticle($value=array()){
        $tbName = 'wm_article';

        $ret = $this->db->makeInsertSQL($tbName,$value);
        if ($ret)
            $ret = $this->db->doQuery($ret);
        if ($ret)
            $ret = $this->db->getLastInsertID();
        return $ret;
    }

    /**
     * 更新文章
     * @param $id
     * @param array $value
     * @return mixed
     */
    public function updateArticle($id,$value=array()){
        $wh = array('article_id' => $id);
        $tbName = 'wm_article';
        $sql = $this->db->makeUpdateSQL($tbName, $value,$wh);
        return $this->db->doQuery($sql);
    }




}