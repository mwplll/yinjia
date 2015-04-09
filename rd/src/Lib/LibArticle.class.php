<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:34
 */
class LibArticle{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * @param int $start
     * @param int $num
     * @param array $wh
     * @return mixed
     */
    public function getArticleList($start=0,$num=15,$wh=array()){
        $dal = new DBArticle();
        return $dal->getArticleList($start,$num,$wh);
    }

    /**
     * @param array $wh
     * @return mixed
     */
    public function getArticleCount($wh=array()){
        $dal = new DBArticle();
        return $dal->getArticleCount($wh);
    }

    /**
     * @param array $value
     * @return bool|mixed
     */
    public function addArticle($value=array()){
        if(!$value){
            return FALSE;
        }

        $value['modify_time'] = time();
        $value['create_time'] = time();
        $dal = new DBArticle();
        return $dal->addArticle($value);
    }

    /**
     * @param $id
     * @param array $value
     * @return bool|mixed
     */
    public function updateArticle($id,$value=array()){
        if(!$this->isId($id)){
            return FALSE;
        }

        if(!$value){
            return FALSE;
        }

        $value['modify_time'] = time();
        $dal = new DBArticle();
        return $dal->updateArticle($id,$value);
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function getArticleById($id){
        if(!$this->isId($id)){
            return FALSE;
        }

        $dal = new DBArticle();
        return $dal->getAtricleById($id);
    }


}