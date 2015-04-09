Ext.define('PMS.apps.GoodsApp.model.GoodsModel',{
    extend: 'Ext.data.Model',
    fields: [
        "id",
        "goodsId",
        'name',
        {name: 'nameText', convert: _Goods_toName},
        'cat',
        'catId',
        'brandId',
        'state',
        'storeNum',
        {name: 'stateText', convert: _Goods_toState},
        'sort',
        'unit',
        'period',
        {name: 'periodText', convert: _Goods_toPeriod},
        'productsList',
        'attrList',
        'price',
        'pic',
        'picList',
        'productStore',
        'goodsSn',
        'providerId',
        'content',
        'seriesId',
        {name: 'thumbUrl', convert: _Goods_toThumbUrl}
    ]
});

function _Goods_toThumbUrl(value, record){
    var url = image_base + record.get('pic') + THUMB_SIZE['grid'];
    var link = base_link + "material/detail.html?id=" + record.get("id");
    return "<a target='_blank' href='" + link +" '><img src='"+ url+ "' height='40px'></a>";
}
function _Goods_toName(value, record){
    var link = base_link + "material/detail.html?id=" + record.get("id");
    return "<a target='_blank' href='" + link +" '>" + record.get("name") + "</a>";
}
function _Goods_toState(value, record){
    var s = Number(record.get('state'));
    if(s == 0){
        return '上架';
    }else if(s == 1){
        return '删除';
    }else if(s == 2){
        return '下架';
    }else if(s == 3){
        return '待审';
    }
}
function _Goods_toPeriod(value, record){
    var s = Number(record.get('period'));
    if(s == 0){
        return '水电阶段';
    }else if(s == 1){
        return '泥水阶段';
    }else if(s == 2){
        return '木工阶段';
    }else if(s == 3){
        return '漆作阶段';
    }else if(s == 4){
        return '成品安装阶段';
    }else if(s == 5){
        return '软装阶段';
    }else if(s == 10){
        return '其他';
    }
}