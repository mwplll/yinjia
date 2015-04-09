Ext.define('PMS.apps.DesignApp.store.DesignMaterialStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.DesignApp.model.DesignMaterialModel',
    autoLoad: false,
    pageSize: 150,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/design/cad/info'
        },
        reader:{
            root:'data.picList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination'
        },
        extraParams:{

        }
    }
});