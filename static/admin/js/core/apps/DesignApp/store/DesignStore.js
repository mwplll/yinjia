Ext.define('PMS.apps.DesignApp.store.DesignStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.DesignApp.model.DesignModel',
    autoLoad: false,
    pageSize: 15,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/design/schema/list'
        },
        reader:{
            root:'data.schemaList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});