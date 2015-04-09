/**
 * file:
 * ver:
 * auth: zyc
 * update: 2015/1/27
 * description:
 */

var goodsDetailCtr = avalon.define({
    $id: 'GoodsDetailController',
    $skipArray: ['prodList'],
    rows: [],
    detailObj: {thumbUrl: '../images/loading2.gif'},
    selectId: -1,

    skuList: [],
    prodList: [],
    picList: [],

    sellPrice: '',
    marketPrice: '',
    storeNum: '',

    copy: 1,

    selectValue: [],
    selectProd: null,
    scrollIndex: 0,
    picSelectIndex: -1,

    // 缩略图切换
    selectPicHandler: function(pic, index){
        goodsDetailCtr.detailObj.thumbUrl = pic.thumbUrl;
        goodsDetailCtr.picSelectIndex = index;
    },
    clearHandler: function(){
        goodsDetailCtr.rows = [];
        goodsDetailCtr.detailObj = {thumbUrl: '../images/loading2.gif'};
        goodsDetailCtr.selectId = -1;
        goodsDetailCtr.skuList = [];
        goodsDetailCtr.prodList = [];
        goodsDetailCtr.picList = [];
        goodsDetailCtr.picSelectIndex = -1;
        goodsDetailCtr.sellPrice = '';
        goodsDetailCtr.marketPrice = '';
        goodsDetailCtr.storeNum = '';
        goodsDetailCtr.copy = 1;
        goodsDetailCtr.selectValue =[];
        goodsDetailCtr.selectProd = null;
        goodsDetailCtr.scrollIndex = 0;
    },

    selectPicIndex: -1,
    // 商品详情
    getDetailHandler: function(goodId, prodId){
        goodsDetailCtr.clearHandler();
        if(!goodId){
          return;
        }
        require("UtilController", function(AjaxUtil) {
            AjaxUtil.getAction({
                url: Global_URL['getGoodDetail'],
                data: {id: goodId},
                callback: function (result2) {
                    var obj = result2.data;
                    obj['thumbUrl'] = image_base + obj['pic'] + THUMB_SIZE['goods'];

                    // 图片列表
                    avalon.each(obj.picList, function (i, it) {
                        it['thumbUrl'] = image_base + it['pic'] + THUMB_SIZE['goods'];

                        if(it['pic'] == obj['pic']){
                            goodsDetailCtr.selectPicIndex = i;
                        }
                    });

                    // 规格列表
                    var productsList = obj.productsList;
                    goodsDetailCtr.skuList = getSkuList(productsList);
                    goodsDetailCtr.prodList = avalon.mix(true, [], productsList);
                    goodsDetailCtr.picList = obj.picList;
                    goodsDetailCtr.detailObj = obj;

                    goodsDetailCtr.sellPrice = obj.sellPrice;
                    goodsDetailCtr.marketPrice = obj.marketPrice;
                    goodsDetailCtr.storeNum = obj.storeNum;

                    goodsDetailCtr.selectValue = [];
                    goodsDetailCtr.selectProd = null;

                    if(productsList.length == 1){
                        if( !productsList[0].specArray || !productsList[0].specArray.length){
                            goodsDetailCtr.selectProd = avalon.mix(true, {},productsList[0]);
                        }
                    }

                    // 选中对应规格 sku
                    if(prodId){
                        var select_product;
                        avalon.each(productsList, function(i,p){
                            if(Number(p.productsId) == Number(prodId)){
                                select_product = p;
                            }
                        });
                        var specArray = select_product.specArray || [];
                        avalon.log(specArray);
                        avalon.each(specArray, function(i, sku){
                            avalon.each(goodsDetailCtr.skuList, function(j, tp){
                                avalon.each(tp.items, function(k, it){
                                    if(it['value'] == sku['value']){
//                                        tp['selectIndex'] = k;
                                        goodsDetailCtr.selectSkuHandler(tp, k, it)
                                    }
                                });
                            });
                        });
                    }
                }
            });
        });
    },

    // 规格组合
    selectSkuHandler: function(sku, index, skuItem){
        if(!skuItem.enable){
            return;
        }
        sku.selectIndex = index;
        var selectValue = getSelectValue(goodsDetailCtr.skuList.$model);

        goodsDetailCtr.selectValue = selectValue;
        if(selectValue.length == goodsDetailCtr.skuList.length){
            var prod = findProdBySku(goodsDetailCtr.prodList, selectValue);
            avalon.log(prod);
            goodsDetailCtr.sellPrice = prod.sellPrice;
            goodsDetailCtr.marketPrice = prod.marketPrice;
            goodsDetailCtr.storeNum = prod.storeNum;

            goodsDetailCtr.selectProd = avalon.mix(true,{}, prod);
        }else{
            enableHandler(
                goodsDetailCtr.skuList,
                skuItem.value,
                goodsDetailCtr.prodList
            );
        }
    },

    scrollPic: function(type){
        if(type == 'left'){
            if(goodsDetailCtr.scrollIndex <=0 ){
                return;
            }else{
                goodsDetailCtr.scrollIndex --;
            }
        }else{
            if(goodsDetailCtr.scrollIndex >= (goodsDetailCtr.picList.length - 4)){
                return;
            }else{
                goodsDetailCtr.scrollIndex ++;
            }
        }
    }
});

/**
 * 重新组装规格列表
 * "specArray: [
 *   {"id":"1","type":"1","value":"upload/2015/01/17/20150117114701519.jpg","picName":"红色","name":"颜色"},
 *   {"id":"2","type":"0","value":"7寸","picName":"","name":"尺寸"}
 * ]"
 */


function getSkuList(list){
    var tp = [], group = [], items = [], values = [];
    // 过滤 找出共有几组 sku
    avalon.each(list, function(i, it){
        if(it.specArray){
            it.specArray = JSON.parse(it.specArray);
            avalon.each(it.specArray, function(j, item){
                if(Number(item.type) == 1){ // 图片类型
                    item.thumbUrl = image_base + item.value;
                }
                group.push(item.id);
                items.push(item);
            });
        }
    });

    group = _.uniq(group);
    items = _.map(_.groupBy(items,function(doc){
        return doc.value;
    }),function(grouped){
        return grouped[0];
    });

    avalon.each(group, function(i, it){
        tp[i] = {};
        avalon.each(items, function(j, item){
            if(item.id == it){
                tp[i].name = item.name;
                tp[i].type = Number(item.type);
                tp[i]['items'] = tp[i]['items'] || [];
                tp[i]['items'].push(item);
                tp[i]['id'] = Number(it);
                tp[i]['selectIndex'] = -1;
                item['_id'] = item.id + "_" + tp[i]['items'].length;
                item['select'] = false;
                item['enable'] = true;
            }
        });
    });

    avalon.each(list, function(i, it){
        var value = [];
        if(it.specArray){
            avalon.each(it.specArray, function(j, item){
                value.push(item.value);
            });
        }
        it._id = value;
    });

    return tp;
}

/**
 * 获取规格组合值
 */
function getSelectValue(skuGroup){
    var result = [];
    avalon.each(skuGroup, function(i, sku){
        if(sku.selectIndex >= 0){
            result.push(sku.items[sku.selectIndex])
        }
    });
    return result;
}

/**
 * 判断规格组合
 * @param skuGroup  Array
 * @param selectValue String
 * @param prodList Array
 */
function enableHandler(skuGroup, selectValue, prodList){
    var re = [];
    avalon.each(prodList, function(i, prod){
        if(_.contains(prod._id, selectValue)){
            re = [].concat(_.without(prod._id,selectValue));
        }
    });
    re = _.uniq(re);
    avalon.each(skuGroup, function(i, sku){
        avalon.each(sku.items, function(j, item){
            if(_.contains(re, item.value)){
                item.eanble = true;
            }else{
                item.eanble = false;
            }
        })
    })
}

/**
 * 根据规格组合 查找对应商品
 * @param selectValue Array
 * @param prodList Array
 */
function findProdBySku(prodList, selectValue){
    var result = null;
    var select = _.map(selectValue, function(it){
        return it.value;
    });
    avalon.each(prodList, function(i, prod){
        var re = _.intersection(prod._id, select);
        if(re.length == selectValue.length){
            result = prod;
        }
    });
    return result;
}