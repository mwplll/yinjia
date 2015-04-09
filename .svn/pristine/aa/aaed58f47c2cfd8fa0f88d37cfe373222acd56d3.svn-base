Ext.define('PMS.apps.HouseApp.store.HouseStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.HouseApp.model.HouseModel',
    autoLoad: false,
    pageSize: 15,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/house/list'
        },
        reader:{
            root:'data.houseList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{
            "states[]": [0,2]
        }
    }
});