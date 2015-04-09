Ext.define('PMS.apps.GoodsApp.model.SkuImageModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'name',
        'time',
        'pic',
        {name: 'thumbUrl', convert: _Sku_toThumbUrl}
    ]
});

function _Sku_toThumbUrl(value, record){
    var url = image_base + record.get('pic') + THUMB_SIZE['grid'];
    return "<img src='"+ url+ "' height='40px'>";
}