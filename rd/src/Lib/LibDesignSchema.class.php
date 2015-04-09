<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 15-2-7
 * Time: 下午3:55
 */
class LibDesignSchema{
    public function isId($id)
    {
        if(!is_numeric($id) || $id<=0)
            return false;
        return true;
    }

    /**
     * 根据Id获得设计方案基本信息
     * @param $id
     * @return bool|mixed
     */
    public function getDesignBaseInfoById($id){
        if(!$this->isId($id)){
            return FALSE;
        }

        $dal = new DBDesignSchema();
        return $dal->getDesignBaseInfoById($id);
    }

    /**
     * 添加设计方案
     * @param array $value
     * @return bool|mixed
     */
    public function addDesignSchema($value=array()){
        if(!$value){
            return FALSE;
        }

        $value['create_time'] = time();
        $value['modify_time'] = time();
        $value['design_schema_del'] = 2;
        $dal = new DBDesignSchema();
        $maxDesignSn = intval($dal->getMaxDesignSn($value['user_id']));

        //echo '$maxDesignerSn = '.$maxDesignerSn."\n";
        $newDesignSn = str_pad(($maxDesignSn+1),4,"0",STR_PAD_LEFT);
        $value['design_sn'] = $newDesignSn;
        return $dal->addDesignSchema($value);
    }

    /**
     * 更新设计方案
     * @param $id
     * @param array $value
     * @return bool|mixed
     */
    public function updateDesignSchema($id,$value=array()){
        if(!$this->isId($id)){
            return FALSE;
        }

        if(!$value){
            return FALSE;
        }

        $value['modify_time'] = time();
        $dal = new DBDesignSchema();

        $designSchemaInfo = $dal->getDesignBaseInfoById($id);
        $houseId = $designSchemaInfo['house_type_id'];
        $houseObj = new LibHouse();
        if(isset($value['design_schema_del'])){
            if($value['design_schema_del'] == 0){  //上架
                $houseObj->addDesignNum($houseId,1);  //在对应户型图和楼盘添加设计方案数
            }
            else if(($value['design_schema_del'] == 1) || ($value['design_schema_del'] == 3)){  //下架或者删除
                $houseObj->addDesignNum($houseId,-1);

            }
            else{

            }
        }


        return $dal->updateDesignSchema($id,$value);
    }

    /**
     * 设计方案列表
     * @param $start
     * @param $num
     * @param array $wh
     * @param array $order
     * @return mixed
     */
    public function getDesignSchemaList($start,$num,$wh=array(),$order=array()){
        if(!$order){
            $order['sort'] = 'modify_time';   //更新时间
            $order['turn'] = 1;   //倒序，时间由近到远
        }
        $dal = new DBDesignSchema();
        return $dal->getDesignSchemaList($start,$num,$wh,$order);
    }

    /**
     * 符合条件的方案数
     * @param array $wh
     * @return mixed
     */
    public function getDesignSchemaCount($wh=array()){
        $dal = new DBDesignSchema();
        return $dal->getDesignSchemaCount($wh);
    }

    /**
     * 添加评论数
     * @param $id
     * @param int $num
     * @return bool|mixed
     */
    public function addCommentNum($id,$num=1){
        if(!$this->isId($id)){
            return FALSE;
        }

        $dal = new DBDesignSchema();
        return $dal->addCommentNum($id,$num);
    }

    /**
     * 添加浏览量
     * @param $id
     * @param int $num
     * @return bool|mixed
     */
    public function addViewNum($id,$num=1){
        if(!$this->isId($id)){
            return FALSE;
        }

        $dal = new DBDesignSchema();
        return $dal->addViewNum($id,$num);
    }

    /**
     * 添加点赞数
     * @param $id
     * @param int $num
     * @return bool|mixed
     */
    public function addLikeNum($id,$num=1){
        if(!$this->isId($id)){
            return FALSE;
        }

        $dal = new DBDesignSchema();
        return $dal->addLikeNum($id,$num);
    }








}