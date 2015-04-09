<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午9:06
 */
class testDecodeJsonAction extends baseAction{
    public function execute(){
        $postData = file_get_contents("php://input");
        /*echo 'json test begin'."\n";
        $json = '{"id":"1",
                  "roomList":[
                    {"roomId":"12",
                     "roomName":"客厅"
                    },
                    {"roomId":"13",
                     "roomName":"餐厅"
                    }
                  ]
                }';
        $arr = json_decode($json,true);

        foreach($arr["roomList"] as $room){
            print_r($room);
            echo "\n";

        }*/
        //print($arr);
        //print_r($arr);
        //$arr = json_decode($postData,true);
        $this->api_success($postData);
    }
}