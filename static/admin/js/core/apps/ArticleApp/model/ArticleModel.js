Ext.define('PMS.apps.ArticleApp.model.ArticleModel',{
    extend: 'Ext.data.Model',
    fields: [
        "id",
        "title",
        "content",
        'summary',
        'category',
        'catId',
        "author",
        "pic",
        "modifyTime",
        "createTime",
        "sort",
        "top",
        "state",
        {name: 'stateText', convert: _Article_toState},
        {name: 'thumbUrl', convert: _Article_toThumbUrl}
    ]
});

function _Article_toThumbUrl(value, record){
    if(!record.get('pic')){
        return '无';
    }
    var url = image_base + record.get('pic') + THUMB_SIZE['grid'];
    var link = base_link + "material/material-detail.html?id=" + record.get("id");
    return "<a target='_blank' href='" + link +" '><img src='"+ url+ "' height='40px'></a>";
}

function _Article_toState(value, record){
    var s = Number(record.get('state'));
    if(s == 0){
        return '上架';
    }else if(s == 1){
        return '删除';
    }else if(s == 2){
        return '下架';
    }
}