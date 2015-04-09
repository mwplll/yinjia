Ext.define('PMS.apps.GoodsApp.model.GoodsSkuModel',{
    extend: 'Ext.data.Model',
    fields: [
        'productsId',
        'productsSn',
        'sellPrice',
        'marketPrice',
        'costPrice',
        'storeNum',
        'weight',
        {name: 'specArrayText', convert: _specArray_toText},
        {name: 'specArray', convert: _specArray_}
    ]
});
function _specArray_(value, record){
    var li = record.raw["specArray"];
    if(!li || li === ''){
        return [];
    }
    li = typeof li == 'string'? JSON.parse(li): li;
    return li;
}
function _specArray_toText(value, record){
    var li = record.raw["specArray"],
        tp = [];
    if(!li || li === ''){
        return '无';
    }
    li = typeof li == 'string'? JSON.parse(li): li;
    Ext.each(li, function(rec){
        if(Number(rec.type) == 1){
            var url = image_base + rec.value + THUMB_SIZE['grid'];
            tp.push("<img src='"+ url+ "' height='40px'>");
        }else{
            tp.push(rec.value);
        }
    });
    if(!tp.length){
        return '无';
    }else{
        return tp.join(" , ");
    }
}