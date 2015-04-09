Ext.define('PMS.apps.OrderApp.store.OrderStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.OrderApp.model.OrderModel',
    autoLoad: false,
    pageSize: 15,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/order/list'
        },
        reader:{
            root:'data.orderList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});