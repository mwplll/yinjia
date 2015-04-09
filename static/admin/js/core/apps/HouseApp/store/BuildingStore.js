Ext.define('PMS.apps.HouseApp.store.BuildingStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.BuildingApp.model.BuildingModel',
    autoLoad: false,
    pageSize: 1000,
    proxy:{
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
            cityId: 330100
        }
    }
});