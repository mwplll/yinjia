<?php

class LibImage{



    public function __construct(){
        $this->upyun = new LibUpyun();
    }


    /**
     * 将 FILES 数组中的文件对象上传到服务器
     * @param $path
     * @param $file
     */
    public function save($path, $file){
        $tmpPath = $file['tmp_name'];

        $ext =  pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = md5_file($tmpPath);
        $uploadPath = "$path/$fileName.$ext";

        $fp = fopen($tmpPath, 'r');

        $ret = $this->upyun->writeFile($uploadPath, $fp, true);

        $ReturnPath = $uploadPath;

        //return $uploadPath;
        return $ReturnPath;
    }



}
/*
 *
 *
        $avator = isset($_FILES['avator']) ? $_FILES['avator'] : false;

        $tplData['data'] = array();

        if($avator){
            $upyunObj = new LibUpyun();
            $uploadFilePath = $avator['tmp_name'];
            $uploadFileName = $avator['name'];

            $fp = fopen($uploadFilePath, 'r');
            $ret = $upyunObj->writeFile('/test/avator/' . $uploadFilePath, $fp, true);

            if($ret){
                $tplData['data']['avator'] = 'http://zjd90.b0.upaiyun.com/test/avator/' . $uploadFileName;
            }

            echo json_encode($ret);
        }
 */
