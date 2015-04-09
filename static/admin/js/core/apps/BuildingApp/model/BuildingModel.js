Ext.define('PMS.apps.BuildingApp.model.BuildingModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'cityId',
        'companyId',
        'name',
        'designNum',
        'prov',
        'city',
        'company',
        'area',
        'areaId',
        "recommend"
    ]
});
