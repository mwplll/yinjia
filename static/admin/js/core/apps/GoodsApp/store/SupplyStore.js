Ext.define('PMS.apps.GoodsApp.store.SupplyStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.GoodsApp.model.SupplyModel',
    autoLoad: false,
    pageSize: 15,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/provider/list'
        },
        reader:{
            root:'data.providerList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});