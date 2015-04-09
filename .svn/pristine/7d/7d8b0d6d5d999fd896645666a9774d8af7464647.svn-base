<?php
/**
 * Created by PhpStorm.
 * User: martian
 * Date: 15-3-14
 * Time: 上午11:35
 */
class articleCatListApiAction extends baseAction{

    public function execute(){
        $categoryObj = new LibArticleCat();
        $categoryList = $categoryObj->getArticleCatList();

        //数据库字段映射到json接口的字段
        $mapArr = array(
            'id' => 'cat_id',
            'name' => 'cat_name',
            'fatherId' => 'cat_father',
            'layer' => 'cat_layer',
            'state' => 'cat_del'
        );

        if($categoryList){
            $data = $this->mapArrays($mapArr,$categoryList);
        }
        else{
            $data = array();
        }

        //print_r($data);

        if($categoryList === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }
    }



}