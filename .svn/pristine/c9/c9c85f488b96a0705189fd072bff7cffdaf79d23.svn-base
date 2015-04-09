Ext.define('PMS.apps.GoodsApp.store.SkuStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.GoodsApp.model.SkuModel',
    autoLoad: false,
    pageSize: 20,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/spec/list'
        },
        reader:{
            root:'data.specList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});