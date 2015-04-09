Ext.define('PMS.apps.GoodsApp.model.GoodsImageModel',{
    extend: 'Ext.data.Model',
    fields: [
        {name: 'thumbUrl', convert: _GoodsImage_toThumbUrl},
        'pic',
        'is_main'
    ]
});
function _GoodsImage_toThumbUrl(value, record){
    var url = image_base + record.get('pic') + THUMB_SIZE['grid'];
    return "<img src='"+ url+ "' height='40px'>";
}