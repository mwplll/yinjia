Ext.define('PMS.apps.DesignApp.model.DesignMaterialGridModel',{
    extend: 'Ext.data.Model',
    fields: [
        'materialId',
        'materialNo',
        'materialName',
        'goodsId',
        'goodsName',
        'unit',
        'productsId',
        'sellPrice',
        'num',
        'content',
        {name: 'totalPrice', convert: _Design_toPrice}
    ]
});

function _Design_toPrice(v, r){
    var num = Number(r.get("num")) || 0;
    var p = Number(r.get('sellPrice')) || 0;

    return Number((num * p).toFixed(2));
}