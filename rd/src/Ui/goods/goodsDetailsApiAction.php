<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-20
 * Time: 上午12:45
 */

/**
 * Class goodsDetailsApiAction
 */
class goodsDetailsApiAction extends baseAction
{
    public function execute()
    {
        $goodsObj = LibFactory::getInstance('LibGoods');

        $goodsId = intval(Dapper_Http_Request::getParam('goods_id', 0));

        if($goodsId!==''){
            //获取商品的所有信息，基本信息、额外属性、图片、评价
            $goodsInfo = $goodsObj->getGoodsByGoodsId($goodsId);
            //echo $goodsId;
            //print_r($goodsInfo);

            $tplData = array(
                'errorCode' => $goodsInfo ? SUCCESS : FAILED,
                'data' => $goodsInfo
            );
        }else{
            $tplData = array(
                'errorCode' => FAILED,
                'data' => '请传入 goods_id 搜索相关建材信息'
            );
        }


        $this->echo_json($tplData);
        return;
    }

}
?>