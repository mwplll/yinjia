Ext.define('PMS.apps.UsersApp.store.AdminStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.UsersApp.model.AdminModel',
    autoLoad: false,
    pageSize: 20,
    proxy: {
        limitParam: "num",
        pageParam: 'page',

        //type: 'ajax',
        type: Global_DataType,
        callbackKey: 'callback',

        api: {
            read: dev_base + 'data/super/user/list'
        },
        reader: {
            type: 'json',
            root: 'data.userList',
            successProperty: 'success',
            totalProperty: 'data.userList.length'
        }
    }
});