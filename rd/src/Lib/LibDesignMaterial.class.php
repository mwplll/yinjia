<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午11:57
 */
class LibDesignMaterial
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
     * 获得房间的材料列表
     * @param $designRoomId
     * @return bool|mixed
     */
    public function getMaterialListByRoomId($designRoomId){
        if(!$this->isId($designRoomId)){
            return FALSE;
        }
        $dal = new DBDesignMaterial();
        return $dal->getMaterialListByRoomId($designRoomId);
    }

    /**
     * 获得设计方案的材料清单信息
     * @param $designSchemaId
     * @return bool|mixed
     */
    public function getMaterialListBydesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }
        $dal = new DBDesignMaterial();
        $materialList = $dal->getMaterialListBydesignId($designSchemaId);
        //print_r($materialList);

        if($materialList){
            foreach($materialList as &$material){
                //商品信息
                $goodsId = $material['goods_id'];
                $goodsDB = new DBGoods();
                $goodsInfo = $goodsDB->getGoodsById($goodsId);
                $material['goods_name'] = $goodsInfo['goods_name'];
                $material['unit'] = $goodsInfo['unit'];
                $material['period'] = $goodsInfo['period'];

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

        //print_r($materialList);
        return $materialList;

    }


    /**
     * 将一个房间的所有建材列表置为无效
     * @param $roomId
     * @return bool|mixed
     */
    public function delMaterialByRoomId($roomId){
        if(!$this->isId($roomId)){
            return FALSE;
        }

        $dal = new DBDesignMaterial();
        return $dal->delMaterialByRoomId($roomId);
    }

    /**
     * 将一个方案的所有建材置为无效
     * @param $designSchemaId
     * @return bool
     */
    public function delMaterialByDesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }

        $dal = new DBDesignMaterial();
        return $dal->delMaterialByDesignId($designSchemaId);
    }

    /**
     * 批量添加建材清单
     * @param array $value
     * @return bool|mixed
     */
    public function addMaterials($value=array()){
        if(!$value){
            return FALSE;
        }

        $dal = new DBDesignMaterial();
        return $dal->addMaterials($value);
    }

    /**
     * 批量更新建材清单
     * @param array $value
     * @return bool|mixed
     */
    public function updateMaterials($value=array()){
        if(!$value){
            return FALSE;
        }

        $dal = new DBDesignMaterial();
        return $dal->updateMaterials($value);
    }




}
