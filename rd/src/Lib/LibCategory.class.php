<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-17
 * Time: 下午5:29
 */
class LibCategory{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 获得分类列表
     * @return mixed
     */
    public function getCategoryList(){
        $dal = new DBCategory();
        return $dal->getCategoryList();
    }

    /**
     * 根据id获得分类信息
     * @param $catId
     * @return bool|mixed
     */
    public function getCategoryById($catId){
        if(!$this->isId($catId)){
            return FALSE;
        }
        $dal = new DBCategory();
        return $dal->getCategoryById($catId);
    }

    /**根据id更新商品分类
     * @param array $value
     * @param $catId
     * @return bool|mixed
     */
    public function updateCategory($value=array(),$catId){
        if(!$value){
            return false;
        }

        if(!$this->isId($catId)){
            return false;
        }
        $dal = new DBCategory();
        return $dal->updateCategory($value,$catId);
    }

    /**
     * 新增分类
     * @param array $value
     * @return bool|mixed
     */
    public function addCategory($value=array()){
        if(!$value){
            return false;
        }

        $value['cat_layer'] = $this->_createCatLayer($value['cat_father']);  //生成新增分类的分类编码

        //print_r($value);
        $dal = new DBCategory();
        return $dal->addCategory($value);

    }

    /**
     * 生成新增分类的分类编号
     * @param $catFatherId
     * @return float
     */
    private function _createCatLayer($catFatherId){
        $dal = new DBCategory();

        //得到父分类的分类编码
        if($catFatherId == 0){
            $catFatherLayer = 0;
        }
        else{
            $catFatherInfo = $dal->getCategoryById($catFatherId);
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