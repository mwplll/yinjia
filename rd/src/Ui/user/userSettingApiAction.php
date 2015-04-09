<?php

class userSettingApiAction extends baseAction
{
    public function execute(){
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



        $this->echo_json($tplData);
    }
}
