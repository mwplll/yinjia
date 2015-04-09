<?php


class LibDesignRoom
{
    /***********************************
     * utils
     ***********************************/
    /**
     * @param $id
     * @return bool
     */
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 获得设计方案的所有房间列表(含房间的材料)
     * @param $designSchemaId
     * @return bool|mixed
     */
    public function getDesignRoomListByDesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }
        $dal = new DBDesignRoom();
        $designRoomList = $dal->getDesignRoomListByDesignId($designSchemaId);

        $designMaterialDB = new DBDesignMaterial();
        if($designRoomList){
            foreach($designRoomList as &$designRoom){
                $designRoomId = $designRoom['design_room_id'];
                $designRoom['materialList'] = $designMaterialDB->getMaterialListByRoomId($designRoomId);
                if($designRoom['materialList']){
                    foreach($designRoom['materialList'] as &$material){
                        //商品信息
                        $goodsId = $material['goods_id'];
                        $goodsDB = new DBGoods();
                        $goodsInfo = $goodsDB->getGoodsById($goodsId);
                        $material['goods_name'] = $goodsInfo['goods_name'];
                        $material['unit'] = $goodsInfo['unit'];

                        //具体规格的货品信息
                        $productsId = $material['products_id'];
                        //echo '$productsId = '.$productsId."\n";
                        $productsDB = new DBProducts();
                        $productsInfo = $productsDB->getProductsById($productsId);
                        //echo '$productsInfo = ';
                        //print_r($productsInfo);
                        //echo "\n";
                        $material['sell_price'] = $productsInfo['sell_price'];
                    }
                }
            }
        }

        //print_r($designRoomList);
        return $designRoomList;
    }

    /**
     * 删除该设计方案的所有房间
     * @param $designSchemaId
     * @return bool|mixed
     */
    public function delDesignRoomsByDesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }

        $dal = new DBDesignRoom();
        return $dal->delDesignRoomsByDesignId($designSchemaId);

    }

    /**
     * 添加房间，返回房间id
     * @param array $value
     * @return bool|mixed
     */
    public function addDesignRoom($value=array()){
        if(!$value){
            return FALSE;
        }

        $dal = new DBDesignRoom();
        return $dal->addDesignRoom($value);
    }

    /**
     * 更新一个房间
     * @param $designRoomId
     * @param array $value
     * @return bool|mixed
     */
    public function updateDesignRoom($designRoomId,$value=array()){
        if(!$this->isId($designRoomId)){
            return FALSE;
        }
        if(!$value){
            return FALSE;
        }

        $dal = new DBDesignRoom();
        return $dal->updateDesignRoom($designRoomId,$value);
    }





}
