Ext.define('PMS.apps.GoodsApp.model.SkuItemModel',{
    extend: 'Ext.data.Model',
    fields: [
        'value',
        'serial',
        'id',
        {name: 'thumbUrl', convert: _sku_item_image}
    ]
});
function _sku_item_image(v, r){
    var url = image_base + r.get('serial') + THUMB_SIZE['grid'];
    if(!r.get('serial')){
        return '';
    }
    return "<img src='"+ url+ "' height='40px'>"
}