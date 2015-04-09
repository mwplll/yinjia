Ext.define('PMS.apps.DesignApp.store.DesignStyleStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.DesignApp.model.DesignStyleModel',
    autoLoad: false,
    pageSize: 15,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/admin/design/manual/list'
        },
        reader:{
            root:'data',
            type: 'json',
            successProperty:'success',
            totalProperty: 'total'
        },
        extraParams:{

        }
    }
});