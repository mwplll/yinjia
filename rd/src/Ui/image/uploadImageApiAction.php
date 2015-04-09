<?php

/**
 * Class uploadImageApiAction
 * 上传图片到 upyun，并返回图片的相对地址
 */
class uploadImageApiAction extends baseAction
{
    public function execute()
    {
        $type = Dapper_Http_Request::getParam('type', 'test');
        //print_r($_FILES);
        // TODO $_FILES name 值不固定
        //$imgFile = isset($_FILES['file']) ? $_FILES['file'] : false;
        foreach($_FILES as $v){
            //print_r($v);
            $imgFile = isset($v) ? $v : false;
        }
        //print_r($_FILES[0]);

        if(!$imgFile){
            return $this->api_error(PARAM_ERROR, 'please upload image file with name `file`');
        }

        $dir = '/test';

        switch($type){
            case 'avatar':
                $dir = '/user/avatar';
                break;
            case 'house_type':
                $dir = '/house/type';
                break;
            case 'design_room':
                $dir = '/design/room';
                break;
            case 'design_cad':
                $dir = '/design/cad';
                break;
            case 'cid_pic':
                $dir = '/designer/cid';
                break;
            case 'goods':
                $dir = '/goods/goods';
                break;
            case 'spec':
                $dir = '/goods/spec';
                break;
            case 'brand_logo':
                $dir = '/brand/logo';
                break;
            case 'article':
                $dir = '/article/pic';
                break;

        }

        $imgObj = new LibImage();
        $link = $imgObj->save($dir, $imgFile);


        $this->api_success(array('link'=> $link));
    }

}
