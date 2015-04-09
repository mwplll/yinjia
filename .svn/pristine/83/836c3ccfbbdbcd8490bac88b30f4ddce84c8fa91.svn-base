Ext.define('PMS.apps.HouseApp.model.HouseModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'name',
        {name: 'thumbUrl', convert: toThumbUrl},
        "pic",
        'usableArea',
        'grossArea',
        'companyId',
        'building',
        'buildingId',
        'houseDesignNum',
        'prov',
        'city',
        'cityId',
        'area',
        'areaId',
        'state',
        {name: 'position', convert: toPos},
        {name: 'stateText', convert: toState}
    ]
});

function toState(value, record){
    record.raw.state = Number(record.raw.state);
    if(record.raw.state == 0){
        return '正常';
    }else if(record.raw.state == 2){
        return '下架';
    }else{
        return '删除';
    }
}
function toThumbUrl(value, record){
    var url = image_base + record.get('pic') + THUMB_SIZE['grid'];
    return "<img src='"+ url+ "' height='40px'>";
}

function toPos(value, record){
    return record.raw.prov + " " + record.raw.city + " " + (record.raw.area || '');
}