/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */

// 详细清单列表
var design_id;
var city_id;
var detailCtr = avalon.define("DetailListController", function(vm) {
    vm.design_id = null;

    vm.row =  {};

    vm.design_price = '';

    vm.house_area = '';
    vm.usable_area = '';

    // 加入我的新家计划
    vm.addToMyDesign = function(){
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['addToMyDesign'],
                data: {id: design_id},
                callback: function(result){
                    Tip.alert("恭喜! 您已成功找到设计方案", function(){
                        location.href = base + '/user/my_schema.html'
                    });
                }
            });
        })
    };

    vm.has = true;
});

var PeriodModel = {
    "0": "水电阶段",
    "1": "泥木阶段",
    "2": "漆作阶段",
    "3": "成品安装阶段",
    "4": "所有阶段"
};
var materialModel = [
    {
        period: '',
        goods: [
            {
                materialId: '',
                materialNo: '',
                materialName: '',
                goodsId: '',
                goodsName: '',
                period: '',
                unit: '',
                productsId: '',
                sellPrice: '',
                totalPrice: '',
                num: '',
                content: ''
            }
        ]
    }
];

var selectGoodsItem;
var selectRoomItem;

var materialListCtr = avalon.define({
    $id: "MaterialListController",
    list: materialModel,

    totalPrice: '',
    unitPrice:  '',

    house_area : '',
    usable_area: '',

    selectHandler: function(good, period){
        require([
            'ArtDialogPlugin',
            "text!../../schema/views/select-goods-dialog.html"
        ], function(_,html){
            var d = dialog({
                fixed: true,
                width: 812,
                content: html
            });
            avalon.scan();
            d.showModal();
            _dialogs_['select_goods'] = d;

            selectGoodsCtr.init(good);
//            selectGoodsItem = good;
        });
    },

    calTotal: function(){
        var list = materialListCtr.list;
        var total = 0;
        avalon.each(list, function(i, it){
            avalon.each(it.goods, function(j, item){
                item.sellPrice = Number(item.sellPrice);
                item.num = Number(item.num);
                item.totalPrice = Number((item.sellPrice * item.num).toFixed(2));
                total += Number(item.totalPrice);
            });
        });

        materialListCtr.totalPrice = Number(total.toFixed(2));
    },

    saveHandler: function(){
        var list = materialListCtr.list.$model;
        var tp = [];
        avalon.each(list, function(i, item){
            avalon.each(item.goods, function(j, it){
                tp.push({
                    id: it.materialId,
                    goodsId: it.goodsId,
                    productsId: it.productsId,
                    num: it.num
                });
            });
        });

        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.saveAction({
                url: Global_URL['saveDetailList'],
                data: {
                    id: design_id,
                    materialList: tp
                },
                crossDomain: Global_CrossDomain,
                method: 'POST',
                callback: function(result){
                    Tip.alert("保存成功");
                }
            });
        });
    },

    linkHandler: function(good){
        if(good.sellPrice){
            return;
        }
        Tip.alert("抱歉,该建材可能已下架或删除");
    }
});

_dialogs_ = {};

var selectGoodsCtr = avalon.define({
    $id: 'SelectGoodsController',

    okHandler: function(){
        if(!goodsDetailCtr.selectProd ){
            Tip.alert("请先选择规格");
            return;
        }
        var pd = {
            goodsId: goodsDetailCtr.detailObj.id,
            unit: goodsDetailCtr.detailObj.unit,
            material: goodsDetailCtr.detailObj.name,
            num: Number(goodsDetailCtr.copy),
            price: goodsDetailCtr.selectProd.sellPrice,
            productsId: goodsDetailCtr.selectProd.productsId,
            specArray: ''
        };
        pd['total'] = Number((pd['num'] * pd['price']).toFixed(2));
        _dialogs_['select_goods'].close();

        var specArray = [];
        if(goodsDetailCtr.selectValue && goodsDetailCtr.selectValue.length){
            avalon.each(goodsDetailCtr.selectValue, function(i, it){
                if(it.type == 1){
                    specArray.push(it.picName);
                }else{
                    specArray.push(it.value);
                }
            });
        }
        if(specArray.length){
            pd['specArray'] = "(" + specArray.toString() + ")";
        }

        var newObj = {
            goodsId: goodsDetailCtr.detailObj.id,
            unit: goodsDetailCtr.detailObj.unit,
            material: goodsDetailCtr.detailObj.name,
            goodsName: goodsDetailCtr.detailObj.name,
            num: Number(goodsDetailCtr.copy),
            sellPrice: goodsDetailCtr.selectProd.sellPrice,
            productsId: goodsDetailCtr.selectProd.productsId,
            specArray: ''
        };

        newObj['totalPrice'] = newObj['sellPrice'] * newObj['num'];


        // 更新选择的建材
        _.extend(selectGoodsItem, newObj);

        materialListCtr.calTotal();
    },
    rows: [],
    selectId: '',

    init: function(item){
        if(selectGoodsItem && selectGoodsItem.goodsId && selectGoodsItem.goodsId == item.goodsId){
            return;
        }
        selectGoodsItem = item;
        selectGoodsCtr.rows = [];
        goodsDetailCtr.clearHandler();
        require("UtilController", function(AjaxUtil){
            AjaxUtil.getAction({
                url: Global_URL['listGoods'],
                data: {num: 1000, page: 1, keywords: KeyMap[item.materialName]},
                callback: function(result){
                    if(!result.data.goodsList
                        || !result.data.goodsList.length){
                        return;
                    }
                    var list = result.data.goodsList;
                    avalon.each(list, function(i, it){

                    });
                    selectGoodsCtr.rows = list;

                    // 单个详情
//                    goodsDetailCtr.getDetailHandler(list[0].id);
                    selectGoodsCtr.selectId = list[0].id;
                }
            });
        });
    }
});

selectGoodsCtr.$watch("selectId", function(){
    goodsDetailCtr.getDetailHandler(selectGoodsCtr.selectId);
});

var constructionListCtr = avalon.define({
    $id: "ConstructionListController",

    list: [1,2,3,4],

    totalPrice: '',
    unitPrice:  '',

    unit_price:  '',

    house_area : '',
    usable_area: ''
});


var house_area;
var usable_area;
require("UtilController", function(AjaxFunc){
    design_id = AjaxFunc.getQueryStringByName('id');
    // 设计费
    AjaxFunc.getAction({
        url: Global_URL['getDesignDetails'],
        data: {id: design_id},
        callback: function(result){
            result.data = result.data || {};

            result.data['thumbUrl'] = image_base + result.data['mainPic'];

            house_area = Number(result.data.houseType.grossArea);
            usable_area = Number(result.data.houseType.usableArea);

            detailCtr.design_price = Number(result.data.price);

            detailCtr.row = avalon.mix(true,{}, result.data);

            detailCtr.house_area = house_area;
            detailCtr.usable_area = usable_area;

            constructionListCtr.house_area = house_area;
            constructionListCtr.usable_area = usable_area;

            materialListCtr.house_area = house_area;
            materialListCtr.usable_area = usable_area;


            // 建材清单
            AjaxFunc.getAction({
                url: Global_URL['getDesignDetailList2User'],
                data: {id: design_id},
                callback: function(result){
                    var re = [], total = 0;
                    result.data = result.data || [];
                    avalon.each(result.data, function(i, item){
                        item.sellPrice = Number(item.sellPrice);
                        item.num = Number(item.num);
                        item.totalPrice = Number((item.sellPrice * item.num).toFixed(2));
                        total += Number(item.totalPrice)
                    });

//                    var tp = filterGoodsByPeriod(result.data);
                    var prod_result = filterGoodsByProdId(result.data);
                    var tp = filterGoodsByPeriod(prod_result);
                    for(var i in tp){
                        re.push({
                            period: PeriodModel[i],
                            goods: tp[i]
                        });
                    }

                    avalon.each(re, function(i, it){
                        avalon.each(it.goods, function(j, item){
                            if(item.sellPrice){
                                item.link = '../material/detail.html?id=' + item.goodsId + '&pid=' + item.productsId;
                            }else{
                                item.link = 'javascript:void;';
                            }
                        });
                    });

                    materialListCtr.list = re;
                    materialListCtr.totalPrice = Number(total.toFixed(2));
                }
            });

            // 人工加附料
            AjaxFunc.getAction({
                url: Global_URL['getDesignManuInfo'],
                data: {id: design_id},
                callback: function(result){
                    var t = 0;
                    avalon.each(result.data, function(i ,item){
                        t += Number(item.price) * house_area;
                    });
                    constructionListCtr.list = result.data;
                    constructionListCtr.totalPrice = Number(t.toFixed(2));
                }
            });
        }
    });
});

function filterGoodsByPeriod(data){
    return _.groupBy(data, function(obj){
        return obj.period;
    })
}
function filterGoodsByProdId_Old(data){
    var tp = data;
    var tmp = [];
    for(var i = 0;i < tp.length; i++){
        tmp.push({
            materialId: tp[i].id,
            materialNo: tp[i].materialNo,
            materialName: tp[i].materialName,
            goodsId: tp[i].goodsId,
            goodsName: tp[i].goodsName,
            period: tp[i].period,
            unit:tp[i].unit,
            productsId: tp[i].productsId,
            sellPrice: tp[i].sellPrice,
            num: tp[i].num,

            totalPrice: Number(( tp[i].sellPrice * tp[i].num).toFixed(2))
        })
    }

    return tmp;
}
function filterGoodsByProdId(data){
    var tp = _.groupBy(data, function(obj){
        return obj.productsId;
    });
    var tmp = [];
    for(var i in tp){
        var total = 0;
        avalon.each(tp[i], function(k, item){
            total += Number(item.num);
        });
        if(tp[i].length){
            tmp.push({
                materialId:tp[i][0].materialId,
                materialNo:tp[i][0].materialNo,
                materialName:tp[i][0].materialName,
                goodsId: tp[i][0].goodsId,
                goodsName: tp[i][0].goodsName,
                period: tp[i][0].period,
                unit:tp[i][0].unit,
                productsId: tp[i][0].productsId,
                sellPrice: tp[i][0].sellPrice,
                num: total,

                totalPrice: Number(( tp[i][0].sellPrice * total).toFixed(2))
            })
        }
    }

    return tmp;
}