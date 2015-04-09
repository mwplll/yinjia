<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午11:56
 */
class designMaterialEditApiAction extends baseAction{
    public function execute(){
        $act = Dapper_Http_Request::getParam('act');

        switch($act){
            case "save":
                $this->save();
                break;
            default:
                $this->api_error(PARAM_ERROR, "please specific your action with 'act' param!");
                break;
        }
    }

    public function save(){
        //$postJsonData = file_get_contents("php://input");
        //echo 'json test begin'."\n";
        /*$postJsonData = '{"id":"2",
                  "roomList":[
                    {"roomId":"47",
                     "roomArea":"12.00",
                     "roomName":"客厅",
                     "roomType":"1",
                     "materialList":[
                        {"materialId":"4",
                         "materialNo":"1-2",
                         "materialName":"马桶2",
                         "goodsId":"1",
                         "productsId":"2",
                         "num":"2",
                         "content":""
                        },
                        {"materialId":"",
                         "materialNo":"1-3",
                         "materialName":"瓷砖",
                         "goodsId":"2",
                         "productsId":"5",
                         "num":"1",
                         "content":""
                        }
                     ]
                    },
                    {"roomId":"",
                     "roomArea":"123.00",
                     "roomName":"餐厅",
                     "roomType":"2",
                     "materialList":[
                        {"materialId":"",
                         "materialNo":"2-2",
                         "materialName":"马桶3",
                         "goodsId":"1",
                         "productsId":"2",
                         "num":"2",
                         "content":""
                        },
                        {"materialId":"",
                         "materialNo":"2-3",
                         "materialName":"瓷砖5",
                         "goodsId":"2",
                         "productsId":"5",
                         "num":"1",
                         "content":""
                        }
                     ]
                    }
                  ]
                }';*/
        $designSchemaId = intval(Dapper_Http_Request::getParam('id',NULL));
        $roomList = Dapper_Http_Request::getParam('roomList',NULL);
        //$arrPostData = json_decode($postJsonData,true);
        //return $this->api_success($roomList);

        //echo '$arrPostData = ';
        //print_r($arrPostData);
        //$designSchemaId = $arrPostData['id'];
        //判断是否有设计方案id
        if(!$designSchemaId){
            return $this->api_error(PARAM_ERROR,"please provide design schema id");
        }

        //
        $designRoomObj = new LibDesignRoom();
        $designMaterialObj = new LibDesignMaterial();
        //将该设计方案下的所有房间、所有建材置为无效，初始化
        $designRoomObj->delDesignRoomsByDesignId($designSchemaId);
        $designMaterialObj->delMaterialByDesignId($designSchemaId);


        //$roomList = Dapper_Http_Request::getParam('roomList',NULL);
        if($roomList){
            $this->_saveDesignRooms($designSchemaId,$roomList);
        }

        return $this->api_success(TRUE);
    }

    /**
     * 保存房间建材清单信息
     * @param $designSchemaId
     * @param array $rooms
     * @return array|bool
     */
    private function _saveDesignRooms($designSchemaId,$rooms=array()){
        $designRoomObj = new LibDesignRoom();

        foreach($rooms as $room){
            //整理房间信息
            $roomId = $room['roomId'];
            $roomData['design_schema_id'] = $designSchemaId;
            $roomData['design_room_name'] = $room['roomName'];
            $roomData['design_room_area'] = $room['roomArea'];
            $roomData['design_room_Type'] = $room['roomType'];
            $materialList = $room['materialList'];
            if($roomId){  //更新房间
                $roomData['design_room_del'] = 0;
                $designRoomObj->updateDesignRoom($roomId,$roomData);
                if($materialList){
                    $this->_saveMaterials($designSchemaId,$roomId,$materialList);
                }
            }
            else{   //添加房间
                $lastRoomId = $designRoomObj->addDesignRoom($roomData);
                //print_r($materialList);
                if($materialList){
                    $this->_saveMaterials($designSchemaId,$lastRoomId,$materialList);
                }
            }
        }

        return TRUE;
    }

    /**
     * 整理建材清单
     * @param $designSchemaId
     * @param $designRoomId
     * @param array $materials
     * @return array|bool
     */
    private function _gatherMaterials($designSchemaId,$designRoomId,$materials=array()){
        if(!$materials){
            return FALSE;
        }

        //echo '_gatherMaterials $materials = ';
        //print_r($materials);
        //echo "\n";
        $newMaterials = array();
        $updateMaterials = array();
        foreach($materials as $material){
            if(isset($material['materialId']) && $material['materialId'] != NULL){
                array_push($updateMaterials,array(
                    "design_material_id" => $material['materialId'],
                    "design_schema_id" => $designSchemaId,
                    "design_room_id" => $designRoomId,
                    "design_material_number" => $material['materialNo'],
                    "design_material_name" => $material['materialName'],
                    "goods_id" => $material['goodsId'],
                    "products_id" => $material['productsId'],
                    "products_num" => $material['num'],
                    "designer_content" => $material['content']
                ));
            }
            else{
                array_push($newMaterials,array(
                    "design_schema_id" => $designSchemaId,
                    "design_room_id" => $designRoomId,
                    "design_material_number" => $material['materialNo'],
                    "design_material_name" => $material['materialName'],
                    "goods_id" => $material['goodsId'],
                    "products_id" => $material['productsId'],
                    "products_num" => $material['num'],
                    "designer_content" => $material['content']
                ));

            }
        }

        $gatherMaterials = array();
        $gatherMaterials['new'] = $newMaterials;
        $gatherMaterials['update'] = $updateMaterials;

        //echo '$gatherMaterial = ';
        //print_r($gatherMaterials);
        //echo "\n";

        return $gatherMaterials;
    }

    /**
     * 保存建材清单
     * @param $designSchemaId
     * @param $designRoomId
     * @param array $materials
     * @return bool
     */
    private function _saveMaterials($designSchemaId,$designRoomId,$materials=array()){
        //echo '_saveMaterials = '."\n";
        if(!$materials){
            return FALSE;
        }

        $materialsObj = new LibDesignMaterial();
        $gatherMaterials = $this->_gatherMaterials($designSchemaId,$designRoomId,$materials);

        if($gatherMaterials['new']){
            $materialsObj->addMaterials($gatherMaterials['new']);   //新增建材清单
            //echo 'add new material'."\n";
        }
        if($gatherMaterials['update']){
            $materialsObj->updateMaterials($gatherMaterials['update']);   //更新建材清单
            //echo 'add update material'."\n";
        }

        return TRUE;
    }


}