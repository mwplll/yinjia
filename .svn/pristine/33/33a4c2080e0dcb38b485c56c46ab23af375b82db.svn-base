Ext.define('PMS.apps.GoodsApp.store.GoodsStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.GoodsApp.model.GoodsModel',
    autoLoad: false,
    pageSize: 10,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/goods/list'
        },
        reader:{
            root:'data.goodsList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});