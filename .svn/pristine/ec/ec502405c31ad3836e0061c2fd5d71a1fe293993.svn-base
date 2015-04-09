Ext.define('PMS.apps.TmplApp.store.TmplStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.TmplApp.model.TmplModel',
    autoLoad: false,
    pageSize: 10,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/house/type'
        },
        reader:{
            root:'data.list',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});