/**
 * Created by zyc on 2014/11/6.
 */
var type = '';
var buyNowCtr = avalon.define("BuyNowController", function(vm){
    vm.expressCompany = "默认快递";
    vm.usePoint = 0;
    vm.userComment= "";

    vm.step = 0;

    vm.payUrl = '';

    vm.priceInfo = {
        expressCost: 0,
        pointCost: 0,
        totalCost: 0
    };
    vm.itemsPrice = 0;

    vm.list = [{}];

    vm.getTotalWidthExpress = function(){
        buyNowCtr.priceInfo.expressCost = 0;
        var total = 0;
        total += buyNowCtr.priceInfo.expressCost;

        return Number(total.toFixed(2));
    };

    // 计算订单总价
    vm.calOrderCost = function(){
        var total = buyNowCtr.getTotalWidthExpress();

        total -= buyNowCtr.priceInfo.pointCost;
        buyNowCtr.priceInfo.totalCost = Math.max(Number(total.toFixed(2)), 0);
    };

    // 确认下单
    vm.placeOrder = function(){
        if(addressListCtr.list.length <1){
            alert("您暂无收货地址,下单前请添加,否则不能成功下单！");
            return;
        }

        if(type == 'design'){
            placeDesignOrder();
        }else if(type == 'material'){
            placeDirect();
        }
    };

    //支付成功
    vm.paySuccess = function(){
        window.open( base + "user/my_orders.html","_self");
    };
});

var design_id;
var design_type;
require(['UtilController'], function(AjaxFunc){
    type = AjaxFunc.getQueryStringByName('type');

    if(type == 'design'){
        design_id = AjaxFunc.getQueryStringByName('design_id');
        design_type = Number(AjaxFunc.getQueryStringByName('design_type'));
        AjaxFunc.getAction({
            url: Global_URL['getDesignDetails'],
            data: {design_id: design_id},
            dataType: Global_DataType,
            callback: function(result){
                result.data = [result.data] || [];

                // 补充数据模型
                avalon.each(result.data, function(i, item){
                    item['thumbUrl'] = image_base + item.designschema.main_pic;
                    item['design_name'] = item.designschema.design_name;
                    item['copy'] = 1;
                    item['houseInfo'] = item.housetype.house_typename + " 套内面积:" + item.housetype.usable_area + "平方米";
                    item['priceInfo'] = {
                        design_price: item.designschema.design_price,
                        deposit: item.designschema.design_deposit
                    };
                });
                buyNowCtr.list = result.data;

                if(design_type == 1){
                    buyNowCtr.priceInfo.totalCost = Number(Number(result.data[0]['priceInfo']['deposit']).toFixed(2));
                }else{
                    buyNowCtr.priceInfo.totalCost = Number(Number(result.data[0]['priceInfo']['design_price']).toFixed(2));
                }

            }
        })
    }
});

function placeDesignOrder(){
    var pd = {
        design_id: design_id,
        addr_id: addressListCtr.list[addressListCtr.selectedIndex].addr_id,
        type: design_type || 1
    };
    if(!pd.addr_id){
        Tip.alert("请先选择收货地址");
        return;
    }
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['placeDesignOrder'],
            data: pd,
            dataType: Global_DataType,
            callback: function(result){
                location.href = base + 'user/my_orders.html';
            }
        })
    });
}

// 直接下单
function placeDirect(){
    var pd = {
        address: {
            id: addressListCtr.list[addressListCtr.selectedIndex].id
        },
        expressCompany: buyNowCtr.expressCompany,
        orderItemInfos: buyNowCtr.getSelectedItems2(),
        point: buyNowCtr.usePoint,
        userComment: buyNowCtr.userComment,
        needInvoice: invoiceCtr.needInvoice,
        invoice:{
            title: invoiceCtr.title,
            type: invoiceCtr.type,
            content: invoiceCtr.content
        },
        source: 'ALLADIN'
    };
    if(!pd.needInvoice){
        pd.invoice = null;
    }else if(!pd.invoice.title){
        alert("请填写发票抬头");
        return;
    }
    cart_service.placeOrderDirect(pd).then(function(data){
        if(buyNowCtr.priceInfo.totalCost <= 0){
            location.href = base + 'user/my_orders.html';
            return;
        }

        headerCtr.getCatNum();

        require("ServiceUtil", function(serviceUtil){
            // 清空 session
            serviceUtil.saveIntoSession({'muri_orderItems': JSON.stringify([])});

            buyNowCtr.payUrl = serviceUtil.getPayUrl(data.value.orderSerial);

            window.open(buyNowCtr.payUrl, '_blank');

            require([
                'ArtDialogPlugin',
                "text!../../order/views/pay.html"
            ], function(__, html){
                var d = dialog({
                    fixed: true,
                    content: html,
                    okValue:'付款已成功',
                    statusbar: "<a target='_blank' href=" + buyNowCtr.payUrl+ ">付款遇到问题，再试一次</a>",
                    ok: function () {
                        location.href = base + 'user/my_orders.html';
                    }
                });
                d.showModal();
            });
//            location.href = buyNowCtr.payUrl;
        });
    });
}





