Ext.define('PMS.apps.GoodsApp.store.SkuImageStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.GoodsApp.model.SkuImageModel',
    autoLoad: false,
    pageSize: 20,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/spec/pic/list'
        },
        reader:{
            root:'data.picList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});