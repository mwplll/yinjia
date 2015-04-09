/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */

var orderModel = {
    order_status: '',
    order_id: '',
    order_sn: '',
    order_amount: '',
    order_type: '',
    create_time: '',
    paid_time: '',
    payAble: false,
    design: {
        thumbUrl: ''
    },
    house: {

    },
    address: {

    }
};
var orderListCtr;   // 列表 控制器
require(["PagerPlugin"], function() {
    orderListCtr = avalon.define({
        $id: "OrderListController",
        pager:{
            currentPage: 1,
            perPages: 20,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
//                listScheme(data.currentPage);
            }
        },
        $skipArray: ['pager'],

        // 默认数据格式，定义一条空的数据 是为了VM绑定
        list: [
            orderModel
        ],
        dropOrderHandler: function(el){
            require("ArtDialogPlugin", function(){
                var d = dialog({
                    fixed: true,
                    width: 360,
                    height: 60,
                    content: "<div style='text-align: center; font-size: 20px;padding: 30px;'>确认取消订单？</div>",
                    okValue: '确认',
                    cancelValue: '取消',
                    ok: function(){
                        require("UtilController", function(AjaxFunc){
                            AjaxFunc.getAction({
                                url: Global_URL['dropDesignOrder'],
                                data: {sn: el.order_sn},
                                callback: function(result){
                                    d.close();
                                    el.order_status = ORDER_STATE_HASH['10'];
                                }
                            });
                        });
                    },
                    cancel: function(){}
                });
                d.showModal();
            });
        },
        acceptOrderHandler: function(el){
            require("ArtDialogPlugin", function(){
                var d = dialog({
                    fixed: true,
                    width: 360,
                    height: 100,
                    content: "<div style='text-align: center; font-size: 20px;padding: 30px 5px 30px 30px;'>确认收货？<p style='text-align: center; font-size: 14px; margin-bottom: 20px;'>注意：请收到货后，再确认收货。</p></div>",
                    okValue: '确认',
                    cancelValue: '取消',
                    ok: function(){
                        require("UtilController", function(AjaxFunc){
                            AjaxFunc.getAction({
                                url: Global_URL['acceptDesignOrder'],
                                data: {sn: el.order_sn},
                                callback: function(result){
                                    d.close();
                                    el.order_status = ORDER_STATE_HASH['4'];
                                    el.acceptAble = false;
                                }
                            });
                        });
                    },
                    cancel: function(){}
                });
                d.showModal();
            });

        }
    });
    avalon.scan();
});

require(['UtilController', 'OrderModel'], function(AjaxFunc, OrderModel){
    AjaxFunc.getAction({
        url: Global_URL['getDesignOrder'],
        callback: function(result){
            result.data = result.data || [];

            // 补充数据模型
            var list = [];
            avalon.each(result.data, function(i, item){
                list.push(new OrderModel(item));
            });
//            orderListCtr.list = list;
            orderListCtr.list = [1,2,3,4];
        }
    });
});
