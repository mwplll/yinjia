Ext.define('PMS.apps.DesignApp.model.DesignMaterialManuModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'name',
        'price',
        'styleId',
        'styleName',
        'manual_num',
        {name: 'manual_total', convert: _Design_toPrice2}
    ]
});

function _Design_toPrice2(v, r){
    var num = Number(r.get("manual_num")) || 0;
    var p = Number(r.get('price')) || 0;

    return Number((num * p).toFixed(2));
}