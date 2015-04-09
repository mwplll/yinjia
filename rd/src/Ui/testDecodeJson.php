<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午8:51
 */
class testDecodeJson extends baseAction{
    public function execute(){
        $postData = file_get_contents("php://input");
        $json = '{"a":"php","b":"mysql","c":3}';
        $arr = json_decode($json,true);
        print_r($postData);
        //$this->api_success($arr);
    }
}