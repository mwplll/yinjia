Ext.define('PMS.apps.GoodsApp.store.BrandStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.GoodsApp.model.BrandModel',
    autoLoad: false,
    pageSize: 15,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/brand/list'
        },
        reader:{
            root:'data.brandlist',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});