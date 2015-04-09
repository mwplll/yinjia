<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午7:39
 */
class uploadFileApiAction extends baseAction
{
    public function execute()
    {
        $type = Dapper_Http_Request::getParam('type', 'test');
        //print_r($_FILES);
        // TODO $_FILES name 值不固定
        //$imgFile = isset($_FILES['file']) ? $_FILES['file'] : false;
        foreach($_FILES as $v){
            //print_r($v);
            $file = isset($v) ? $v : false;
        }
        //print_r($_FILES[0]);

        if(!$file){
            return $this->api_error(PARAM_ERROR, 'please upload file with name `file`');
        }

        $dir = '/test';

        switch($type){
            case 'design_file':
                $dir = '/design/file';
                break;
            case 'design_pdf':
                $dir = '/design/pdf';
                break;
        }

        $fileObj = new LibFile();
        $link = $fileObj->save($dir, $file);


        $this->api_success(array('link'=> $link));
    }

}