Ext.define('PMS.apps.GoodsApp.model.BrandModel',{
    extend: 'Ext.data.Model',
    fields: [
        "id",
        'name',
        'enName',
        'logo',
        'content',
        'url',
        'sort',
        'del',
        'seriesList',
        {name: 'thumbUrl', convert: _Brand_toThumbUrl},
        {name: 'serialText', convert: _Brand_toText},
        {name: 'contents', convert: _Brand_toContents}
    ]
});

function _Brand_toThumbUrl(value, record){
    if(!record.get("logo")){
        return '';
    }
    var url = image_base + record.get('logo') + THUMB_SIZE['grid'];
    return "<img src='"+ url+ "' height='20px'>";
}
function _Brand_toContents(value, record){
    return record.get("content");
}
function _Brand_toText(value, record){
    var list = record.get("seriesList");
    var str = [];
    Ext.each(list, function(item){
        str.push(item.seriesName);
    });

    return str.join(",");
}