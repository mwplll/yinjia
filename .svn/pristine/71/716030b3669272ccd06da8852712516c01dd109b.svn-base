<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-1-17
 * Time: 下午5:08
 */
class categoryListApiAction extends baseAction{

    public function execute(){
        $categoryObj = new LibCategory();
        $categoryList = $categoryObj->getCategoryList();

        //数据库字段映射到json接口的字段
        $mapArr = array(
            'id' => 'cat_id',
            'name' => 'cat_name',
            'father_id' => 'cat_father',
            'layer' => 'cat_layer',
            'del' => 'del'
        );
        $data = $this->mapArrays($mapArr,$categoryList);
        //print_r($data);

        if($data === FALSE){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }
    }



}