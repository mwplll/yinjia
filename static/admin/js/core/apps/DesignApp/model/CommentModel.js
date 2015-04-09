Ext.define('PMS.apps.DesignApp.model.CommentModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'designSchemaId',
        'houseTypeId',
        'userId',
        'userName',
        'designName',
        {name: 'designLink', convert: _Design_toLink},
        'avatar',
        'content',
        'point',
        'time'
    ]
});


function _Design_toLink(value, record){
    var link = base_link + "schema/detail.html?schema_id=" +
        record.get("designSchemaId") +
        '&house_id=' + record.get('houseTypeId');
    return "<a target='_blank' href='" + link +" '>" + record.get("designName") +"</a>";
}
