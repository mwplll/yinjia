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
    vm.design_id = design_id;
    vm.text = {
        designschema: {},
        housetype: {}
    };

    vm.unit_design_price = '';
    vm.design_price = '';

    vm.house_area = '';
    vm.usable_area = '';

    // 加入我的新家计划
    vm.addToMyDesign = function(){
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['addToMyDesign'],
                dataType: Global_DataType,
                data: {design_id: design_id},
                callback: function(result){
                    Tip.alert("恭喜! 您已成功找到设计方案", function(){
                        location.href = base + '/user/my_scheme.html'
                    })
                }
            });
        })
    };
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
var materialListCtr = avalon.define({
    $id: "MaterialListController",
    list: materialModel,

    totalPrice: '',
    unitPrice:  '',

    house_area : '',
    usable_area: ''
});
var constructionListCtr = avalon.define({
    $id: "ConstructionListController",

    list: [],

    totalPrice: '',
    unitPrice:  '',

    unit_price:  '',

    house_area : '',
    usable_area: ''

});


var house_area;
var usable_area;
require("UtilController", function(AjaxFunc){
    design_id = AjaxFunc.getQueryStringByName('design_id');
    city_id = AjaxFunc.getQueryStringByName('city_id');
    // 设计费
    AjaxFunc.getAction({
        url: Global_URL['getDesignDetails'],
        data: {design_id: design_id},
        callback: function(result){
            result.data = result.data || [];
            result.data.housetype.pic = image_base + result.data.housetype.pic + THUMB_SIZE['schema'];


            house_area = Number(result.data.housetype.gross_area);
            usable_area = Number(result.data.housetype.usable_area);

            detailCtr.design_price = Number(result.data.designschema.design_price);
            detailCtr.unit_design_price = Number((detailCtr.design_price / house_area).toFixed(2));

            result.data.unit_price = 0;
            if(house_area){
                result.data.unit_price = (Number(result.data.designschema.total_price) / house_area).toFixed(2);
            }

            detailCtr.text = result.data;

            detailCtr.house_area = house_area;
            detailCtr.usable_area = usable_area;

            constructionListCtr.house_area = house_area;
            constructionListCtr.usable_area = usable_area;

            materialListCtr.house_area = house_area;
            materialListCtr.usable_area = usable_area;

            // 建材清单
            AjaxFunc.getAction({
                url: Global_URL['getDesignDetailList'],
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
                    avalon.log(re);
                    materialListCtr.list = re;
                    materialListCtr.totalPrice = Number(total.toFixed(2));
                    if(usable_area){
                        materialListCtr.unitPrice = Number((materialListCtr.totalPrice / usable_area).toFixed(2));
                    }
                }
            });

            // 人工加附料
            AjaxFunc.getAction({
                url: Global_URL['getDesignManuInfo'],
                data: {cityId: city_id},
                callback: function(result){
                    var t = 0;
                    avalon.each(result.data, function(i ,item){
                        item.totalPrice = Number((Number(item.manual_price) * house_area).toFixed(2))
                        t += item.totalPrice;
                    });
                    constructionListCtr.list = result.data;
                    constructionListCtr.totalPrice = Number(t.toFixed(2));
                    if(house_area){
                        constructionListCtr.unitPrice = Number((constructionListCtr.totalPrice / house_area).toFixed(2));
                    }
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
function filterGoodsByProdId(data){
    var tp = _.groupBy(data, function(obj){
        return obj.productsId;
    });
    console.log(tp);
    var tmp = [];
    for(var i in tp){
        var total = 0;
        avalon.each(tp[i], function(k, item){
            total += Number(item.num);
        });
        if(tp[i].length){
            tmp.push({
                materialId:'',
                materialNo:'',
                materialName:'',
                goodsId: '',
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