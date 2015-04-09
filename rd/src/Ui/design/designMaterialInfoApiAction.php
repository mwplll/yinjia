<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午11:56
 */
class designMaterialInfoApiAction extends baseAction{
    public function execute(){
        $designRoomObj = new LibDesignRoom();
        $designSchemaId = Dapper_Http_Request::getParam('id');

        if(!$designSchemaId){
            return $this->api_error(FAILED,'please provide id');
        }

        $designRoomList = $designRoomObj->getDesignRoomListByDesignId($designSchemaId);

        if($designRoomList === FALSE){
            return $this->api_error(FAILED);
        }
        elseif(!$designRoomList){   //查询不到返回空
            return $this->api_success($designRoomList);
        }

        $mapArr = array(
            'roomId' => 'design_room_id',
            'roomName' => 'design_room_name',
            'roomArea' => 'design_room_area',
            'roomType' => 'design_room_type',
            'materialList' => 'materialList'
        );
        $designRoomList = $this->mapArrays($mapArr,$designRoomList);  //映射输出房间列表

        foreach($designRoomList as &$designRoom){
            if($designRoom['materialList']){
                $mapArr = array(
                    'materialId' => 'design_material_id',
                    'materialNo' => 'design_material_number',
                    'materialName' => 'design_material_name',
                    'goodsId' => 'goods_id',
                    'goodsName' => 'goods_name',
                    'unit' => 'unit',
                    'productsId' => 'products_id',
                    'sellPrice' => 'sell_price',
                    'num' => 'products_num',
                    'content' => 'designer_content'
                );
                $designRoom['materialList'] = $this->mapArrays($mapArr,$designRoom['materialList']);   //映射输出每个房间的材料列表
            }
            else{
                $designRoom['materialList'] = array();
            }

        }

        //print_r($designRoomList);
        if(!$designRoomList)
            return $this->api_error(FAILED);
        else
            return $this->api_success($designRoomList);

    }
}