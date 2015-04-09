Ext.define('PMS.apps.OrderApp.model.OrderModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'user',
        'sn',
        'amount',
        'type',
        'status',
        {name: 'statusText', convert: _Order_To_State},
        'createTime',
        {name: 'timeText', convert: _Order_To_Time}
    ]
});

function _Order_To_State(v, r){
    var s = Number(r.get("status"));

    if(s == 0){
        return '';
    }else if(s == 1){
        return '等待买家付款';
    }else if(s == 2){
        return '买家已付款、等待卖家发货';
    }else if(s == 3){
        return '卖家已发货、等待买家确认收货';
    }else if(s == 4){
        return '买家已确认收货';
    }else if(s == 10){
        return '已关闭的订单';
    }else if(s == 11){
        return '完成的订单';
    }else{
        return '';
    }
}

function _Order_To_Time(v, r){
    var s = Number(r.get("createTime") * 1000);
    if(!s){
        return '';
    }
    return Ext.util.Format.date(new Date(s), "Y-m-d H:i:s");
}