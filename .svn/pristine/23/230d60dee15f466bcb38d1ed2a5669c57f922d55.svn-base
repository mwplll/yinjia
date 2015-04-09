Ext.define('PMS.apps.DesignersApp.store.DesignersStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.DesignersApp.model.DesignersModel',

    autoLoad: true,
    pageSize: 20,
    proxy: {
        limitParam: "num",
        pageParam: 'page',

        //type: 'ajax',
        type: Global_DataType,
        callbackKey: 'callback',

        api: {
            read: dev_base + 'data/admin/user/list'
        },
        reader: {
            type: 'json',
            root: 'data.userList',
            successProperty: 'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{
            isSpecial: 1
        }
    }
});