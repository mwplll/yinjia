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
var pageSize = 20;
var orderManagementCtr;   // 列表 控制器
require(["PagerPlugin"], function() {
    orderManagementCtr = avalon.define({
        $id: "OrderManagementController",
        pager:{
            currentPage: 1,
            perPages: pageSize,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listOrder(data.currentPage);
            }
        },
        $skipArray: ['pager'],

        // 默认数据格式，定义一条空的数据 是为了VM绑定
        items: [
            orderModel
        ],

        state: 'all', // ['all', 'pay_first', 'pic_first', 'pay_second', 'pic_second', 'send','complete','cancel']

        listHandler: function(state){
            if(orderManagementCtr.state == state){
                return;
            }
            orderManagementCtr.state = state;
            listOrder(1);
        },
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
                                url: Global_URL['dropOrderForDesigner'],
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
        }
    });
    avalon.scan();
});

listOrder(1, 'all');
function listOrder(page, state){
    var pd = {
        page: page,
        num: pageSize,
        state: state || orderManagementCtr.state
    };
    require(['UtilController', 'OrderModel'], function(AjaxFunc, OrderModel){
        AjaxFunc.getAction({
            url: Global_URL['getOrderListForDesigner'],
            data: pd,
            callback: function(result){
                result.data = result.data.orderList || [];

                // 补充数据模型
                var list = [];
                avalon.each(result.data, function(i, item){
                    list.push(new OrderModel(item));
                });
                orderManagementCtr.items = list;
            }
        });
    });
}
