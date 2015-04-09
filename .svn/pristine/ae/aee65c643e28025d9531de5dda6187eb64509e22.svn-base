Ext.define('PMS.apps.GoodsApp.model.SkuModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'name',
        'value',
        'type',
        {name: 'typeText', convert: _sku_toText},
        'picList',
        {name: 'items', convert: _sku_toItems},
        'del'
    ]
});

function _sku_toText(v, r){
    if(Number(r.get("type")) == 0){
        return '文字';
    }else{
        return '图片';
    }
}
function _sku_toItems(v, r){
    if(Number(r.get("type")) == 0){
        return r.get("value");
    }else{
        var t = r.get("value"), tp = [];
        if(!t){
            return ''
        }else{
            t = t.split(',');
        }
        Ext.each(t, function(it){
            var url = image_base + it + THUMB_SIZE['grid'];
            tp.push("<img src='"+ url+ "' height='40px' style='margin-right:10px;'>");
        });
        return tp.join(" ");
    }
}