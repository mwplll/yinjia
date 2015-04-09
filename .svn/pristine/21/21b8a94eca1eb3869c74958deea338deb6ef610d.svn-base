Ext.define('PMS.apps.UsersApp.model.AdminModel',{
    extend: 'Ext.data.Model',
    fields: [
        'id',
        'isSpecial',
        'user',
        'pwd',
        {name: 'text', convert: nametoText},
    ]
});


function nametoText(value, record){
    var t = Number(record.get("isSpecial"));
    if(t == 10){
        return '超级管理员';
    }else if(t == 11){
        return '设计方案管理员';
    }else if(t == 12){
        return '材料管理员';
    }else if(t == 13){
        return '文章管理员';
    }
}