Ext.define('PMS.apps.BuildingApp.store.BuildingStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.BuildingApp.model.BuildingModel',

    autoLoad: true,
    pageSize: 15,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/building/list'
        },
        reader:{
            root:'data.buildingList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});