<?php
/**
 * Created by PhpStorm.
 * User: mwp
 * Date: 14-12-20
 * Time: 上午12:45
 */
class goodsListApiAction extends baseAction
{
    public function execute()
    {
        $goodsObj = new LibGoods();

        $num = Dapper_Http_Request::getParam('num',15);
        $page = Dapper_Http_Request::getParam('page',1);
        $catId = Dapper_Http_Request::getParam('catId',NULL);
        $isDel = Dapper_Http_Request::getParam('state',NULL);
        $maxStoreNum = (int)Dapper_Http_Request::getParam('maxNum',10000);
        $minStoreNum = (int)Dapper_Http_Request::getParam('minNum',0);
        $period = Dapper_Http_Request::getParam('period',NULL);
        $keywords = Dapper_Http_Request::getParam('keywords',NULL);
        $brand = Dapper_Http_Request::getParam('brand',NULL);

        //分页处理
        if($page < 1){
            $page = 1;
        }
        $start = ($page - 1) * $num;

        $wh = array();
        $wh['is_del'] = $isDel;
        $wh['period'] = $period;
        $wh['keywords'] = $keywords;
        $wh['brand'] = $brand;
        $wh['min_store_num'] = $minStoreNum;
        $wh['max_store_num'] = $maxStoreNum;
        $wh['cat_id'] = $catId;
        $goodsList = $goodsObj->getGoodsList($start,$num,$wh);
        //print_r($goodsList);
        $totalCount = (int)$goodsObj->getGoodsCount($wh);
        $totalPage = ceil($totalCount / $num);

        
        //输出映射表
        $mapArr = array(
            'id' => 'goods_id',
            'name' => 'goods_name',
            'cat' => 'cat_name',
            'price' => 'sell_price',
            'storeNum' => 'store_num',
            'state' => 'is_del',
            'sort' => 'sort',
            'period' => 'period',
            'pic' => 'img'
        );
        $goodsList = $this->mapArrays($mapArr,$goodsList);

        $data = array(
            'goodsList' => $goodsList,
            'pagination' => array(
                'count' => $totalCount,
                'page' => $totalPage
            ));
        //print_r($data);

        if(!$data){
            return $this->api_error(FAILED);
        }
        else{
            return $this->api_success($data);
        }
/*        $goodsObj = LibFactory::getInstance('LibGoods');

        // 每页的个数
        $num = isset($_GET["num"]) ? $_GET["num"] : 9;
        // 当前的分页
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        if($page < 1){
            $page = 1;
        }
        //起始个数
        $start = ($page - 1) * $num;
        //搜索关键词
        $keywords = isset($_GET["keywords"]) ? $_GET["keywords"] : NULL;
        //分类ID
        $typeId = isset($_GET["type_id"]) ? $_GET["type_id"] : 1;
        //排序方式，0为默认，1为按人气，2为按评论，3为按价格
        $sort = isset($_GET["sort"]) ? $_GET["sort"] : 0;
        //排序方向，0为正序，1为倒序
        $direction = isset($_GET["direction"]) ? $_GET["direction"] : 0;


        $childrenType = $goodsObj->getChildrenTypeByTypeId($typeId);
        $goodsList = $goodsObj->getGoodsList($keywords,$typeId,$start,$num,$sort,$direction);
        $goodsListCount = $goodsObj->getGoodsListCount($keywords,$typeId);
        $totalCount = (int)$goodsListCount;
        $totalPage = ceil($totalCount / $num);
        //echo $goodsListCount;

        //echo $typeId;
        //print_r($goodsObj->getChildrenTypeByTypeId($typeId));
        //print_r($goodsList);

        /*$typeLayer = '0101020000';
        $typefather = 3;
        $typeLayerFirst = substr($typeLayer,0,$typefather*2);
        $typeLayerLast = substr('0000000000',$typefather*2);
        $minTypeLayer = $typeLayerFirst.$typeLayerLast;
        $TypeLayerbefore = intval($typeLayerFirst);
        $TypeLayerbefore = $TypeLayerbefore + 1;
        $TypeLayerbefore = substr(strval($TypeLayerbefore+10000000000),-$typefather*2);
        $maxTypeLayer = $TypeLayerbefore.$typeLayerLast;
        echo 'b='.$TypeLayerbefore;
        echo '$minTypeLayer'.$minTypeLayer;
        echo '$maxTypeLayer'.$maxTypeLayer;*/

        /*$tplData = array(
            'errorCode' => SUCCESS,
            'data' => array(
                'childrenType' => $childrenType,
                'goodsList' => $goodsList,
                'pagination' => array(
                    'count' => $totalCount,
                    'page' => $totalPage
                ),

            ),
        );
        $this->echo_json($tplData);
        return;*/
    }

}
?>