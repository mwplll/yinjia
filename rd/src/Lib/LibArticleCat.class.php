<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:33
 */
class LibArticleCat{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 文章分类列表
     * @return mixed
     */
    public function getArticleCatList(){
        $dal = new DBArticleCat();
        return $dal->getArticleCatList();
    }

    /**
     * 根据id获得分类信息
     * @param $catId
     * @return bool|mixed
     */
    public function getArticleCatById($catId){
        if(!$this->isId($catId)){
            return FALSE;
        }
        $dal = new DBArticleCat();
        return $dal->getArticleCatById($catId);
    }

    /**根据id更新分类
     * @param array $value
     * @param $catId
     * @return bool|mixed
     */
    public function updateArticleCat($catId,$value=array()){
        if(!$value){
            return false;
        }

        if(!$this->isId($catId)){
            return false;
        }
        $dal = new DBArticleCat();
        return $dal->updateArticleCat($catId,$value);
    }

    /**
     * 新增分类
     * @param array $value
     * @return bool|mixed
     */
    public function addArticleCat($value=array()){
        if(!$value){
            return false;
        }

        $value['cat_layer'] = $this->_createCatLayer($value['cat_father']);  //生成新增分类的分类编码

        //print_r($value);
        $dal = new DBArticleCat();
        return $dal->addArticleCat($value);

    }

    /**
     * 生成新增分类的分类编号
     * @param $catFatherId
     * @return float
     */
    private function _createCatLayer($catFatherId){
        $dal = new DBArticleCat();

        //得到父分类的分类编码
        if($catFatherId == 0){
            $catFatherLayer = 0;
        }
        else{
            $catFatherInfo = $dal->getArticleCatById($catFatherId);
            $catFatherLayer = (int)$catFatherInfo['cat_layer'];
        }

        $maxChildrenCatLayer = $dal->getMaxChildrenCatLayer($catFatherId);
        //$maxChildrenCatLayer = '0500000000';
        //echo '$maxChildrenCatLayer = '.$maxChildrenCatLayer;

        if($maxChildrenCatLayer){ //如果该父分类已经有子分类了,则新增的子分类编码为原有的子分类编码的最大值加1
            $catLayer = (int)$maxChildrenCatLayer;
            $mod = 0;
            for($i=0; $mod ==0 ;$i++){
                $catLayer = $catLayer / 100;
                $mod = $catLayer % 100;
            }
            $catLayer = $catLayer + 1;
            for(;$i > 0;$i--){
                $catLayer = $catLayer * 100;
            }
        }
        else{ //如果该父分类还没有子分类，由父分类编码得到子分类的编码
            if($catFatherLayer == 0){
                $catLayer = 100000000;
            }
            else{
                $catLayer = $catFatherLayer;
                $mod = 0;
                for($i=0; $mod ==0 ;$i++){
                    $catLayer = $catLayer / 100;
                    $mod = $catLayer % 100;
                }
                $catLayer = $catLayer*100 + 1;
                for(;$i > 1;$i--){
                    $catLayer = $catLayer * 100;
                }
            }
        }

        return $catLayer; //返回新增分类的分类编码


    }


}