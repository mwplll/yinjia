<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午7:45
 */
class LibFile{
    public function __construct(){
        $this->upyun = new LibUpyunForFile();
    }

    public function save($path, $file){
        $tmpPath = $file['tmp_name'];

        $ext =  pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = md5_file($tmpPath);
        $uploadPath = "$path/$fileName.$ext";

        $fp = fopen($tmpPath, 'r');

        $ret = $this->upyun->writeFile($uploadPath, $fp, true);

        $ReturnPath = $uploadPath;
        return $ReturnPath;
    }
}