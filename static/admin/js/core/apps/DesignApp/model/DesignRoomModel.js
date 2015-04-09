Ext.define('PMS.apps.DesignApp.model.DesignRoomModel',{
    extend: 'Ext.data.Model',
    fields: [
        'picId',
        'pic',
        'name',
        {name: 'room_thumbUrl', convert: _Design_toRoomThumbUrl},
        {name: 'room_link', convert: _Design_toLink}
    ]
});

function _Design_toRoomThumbUrl(v, r){
    var url = image_base + r.get('pic') + THUMB_SIZE['grid'];
    return "<img src='"+ url+ "' height='40px'>";
}
function _Design_toLink(v, r){
    var url = linkBase + r.get('pic');
//    return url;
    return "<a href='"+ url+ "' target='_blank' style='display:block;width:100%;height:25px;'>" + url +"</a>";
}