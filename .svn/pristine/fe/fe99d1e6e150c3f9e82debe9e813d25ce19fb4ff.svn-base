<?php

class LibUserAction
{
    protected $uid = null;

    public function __construct($uid)
    {
        $this->uid = $uid;
    }


    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }


    /**
     * 收藏设计方案
     * @param $user_id
     * @param $design_id
     */
    public function collectDesign($design_id){
        if(!$this->isId($design_id)){
            return false;
        }

        //如果是非正常上架的方案，直接返回
        $isChecked = $this->isCheckedDesign($design_id);
        if(!$isChecked){
            return FALSE;
        }
        // 如果已经收藏过该户型，直接返回
        $isCollected = $this->isCollectedDesign($design_id);
        if($isCollected){
            return $isCollected;
        }else{
            $value = array(
                'user_id' => $this->uid,
                'design_schema_id' => $design_id
            );

            $dal = new DBUserAction();
            $ret = $this->createMyMaterials($design_id);  //创建用户个人的设计方案材料库
            $ret = $dal->addDesignCollection($value);
            return $ret;
        }
    }


    /**
     * 检查某设计方案是否已经被收藏
     * @param $design_id
     */
    public function isCollectedDesign($design_id){
        $ret = $this->filterCollectedDesign(array($design_id));
        //echo '$design_id = '.$design_id;
        //echo '$ret = '.$ret;
        //echo 'count($ret) = '.count($ret).$ret;
        if(count($ret) == 1){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 判断是否是正常上架的方案
     * @param $designId
     * @return bool
     */
    public function isCheckedDesign($designId){
        $dal = new DBDesignSchema();
        $designInfo = $dal->getDesignBaseInfoById($designId);
        if($designInfo['design_schema_del'] == 0 ){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /**
     * 筛选出被收藏的户型
     * @param $design_ids
     */
    public function filterCollectedDesign($design_ids){

        $dal = new DBUserAction();
        $designCollectionList = $dal->filterDesignCollection($this->uid, $design_ids);
        //print_r($designCollectionList);
        return $designCollectionList;


    }

    public function delCollectedDesign($design_ids){
        $dal = new DBUserAction();
        $res = $this->delMyDesignMaterial($design_ids);
        return $dal->delDesignCollection($this->uid, $design_ids);
    }

    public function delMyDesignMaterial($design_ids){
        $dal = new DBUserAction();
        return $dal->delMyDesignMaterial($this->uid, $design_ids);
    }

    /**
     * 用户收藏的设计方案列表信息
     * @return mixed
     */
    public function getDesignCollection(){
        $dal = new DBUserAction();
        $ret = $dal->getDesignCollection($this->uid);

        if($ret){
            $ids =array();
            foreach ($ret as $v){
                array_push($ids, $v['design_schema_id']);
            }
            $designDal = new DBDesignSchema();
            $ret = $designDal->getDesignInfoByIds($ids);
        }

        return $ret;
    }



    public function buyDesign($values=array()){
        if(!$values){
            return FALSE;
        }

        $values['order_status'] = 1;
        $values['create_time'] = time();

        $uaDal = DBFactory::getInstance('DBUserAction');
        return $uaDal->createDesignOrder($values);
    }


    public function getDesignOrder()
    {
        $uaDal = new DBUserAction;

        return $uaDal->getDesignOrderByUid($this->uid);
    }

    /**
     * 创建用户-设计方案材料库
     * @param array $designId
     * @return bool|mixed
     */
    public function createMyMaterials($designId){
        $materialList = array();
        if(!$this->isId($designId)){
            return FALSE;
        }
        else{
            $designMaterialObj = new DBDesignMaterial();
            $materialList = $designMaterialObj->getMaterialListBydesignId($designId);
            if(!$materialList){
                return FALSE;
            }
            else{
                foreach($materialList as &$material){
                    unset($material['design_material_id']);
                    $material['user_id'] = $this->uid;
                }
            }
        }

        $dal = new DBUserAction();
        return $dal->addMyMaterials($materialList);
    }

    /**
     * 获得设计方案的材料清单信息
     * @param $designSchemaId
     * @return bool|mixed
     */
    public function getMyMaterialListBydesignId($designSchemaId){
        if(!$this->isId($designSchemaId)){
            return FALSE;
        }
        $dal = new DBUserAction();
        $materialList = $dal->getMyMaterialListBydesignId($designSchemaId,$this->uid);
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
     * 批量更新用户的建材清单
     * @param array $value
     * @return bool|mixed
     */
    public function updateMyMaterials($value=array()){
        if(!$value){
            return FALSE;
        }

        $dal = new DBUserAction();
        return $dal->updateMyMaterials($value);
    }
}