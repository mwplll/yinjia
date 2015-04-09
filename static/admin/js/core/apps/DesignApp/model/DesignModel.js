Ext.define('PMS.apps.DesignApp.model.DesignModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'name',
        'designerId',
        'designer',
        'userName',
        'designSn',
        'price',
        'totalPrice',
        'materialPrice',
        'manualPrice',
        'deposit',
        'houseTypeId',
        'mainPic',
        'modifyTime',
        'viewNum',
        'state',
        'file',
        'houseType',
        'content',
        'recommend',
        {name: 'designLink', convert: _Design_toLink2},
        {name: 'recommendText', convert: _Design_toRecommend},
        {name: 'thumbUrl', convert: _Design_toThumbUrl},
        {name: 'stateText', convert: _Design_toState}
    ]
});


function _Design_toLink2(value, record){
    var link = base_link + "schema/detail.html?schema_id=" + record.get("id") + '&house_id=' + record.get('houseType').id;
    return "<a target='_blank' href='" + link +" '>" + record.get("name") +"</a>";
}


function _Design_toRecommend(v, r){
    v = Number(v);
    if(v == 1){
        return '是';
    }else{
        return '否';
    }
}
function _Design_toThumbUrl(v, r){
    var url = image_base + r.get('mainPic') + THUMB_SIZE['grid'];
    return "<img src='"+ url+ "' height='20px'>";
}
function _Design_toState(v, r){
   var s = Number(r.get("state"));
    if(s == 0){
        return '上架'
    }else if(s == 1){
        return '删除'
    }else if(s == 2){
        return '审核中'
    }else if(s == 3){
        return '下架'
    }else if(s == 4){
        return '审核失败'
    }
}