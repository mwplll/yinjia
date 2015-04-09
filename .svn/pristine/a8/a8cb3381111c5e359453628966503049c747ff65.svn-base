/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.UsersApp.controller.UsersController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.UsersApp.model.UsersModel'
    ],
    stores: [
        'PMS.apps.UsersApp.store.UsersStore'
    ],
    views: [
        'PMS.apps.UsersApp.view.UsersGrid'
    ],

    refs:[
        {
            selector: 'usersWin',
            ref: 'usersWin'
        },
        {
            selector:'usersWin form',
            ref:'usersForm'
        },
        {
            selector:'usersGrid',
            ref:'usersGrid'
        }
    ],
    init: function(){
        console.log("UsersController init");

        this.control({
            'usersGrid':{
                render: function(grid){
                    grid.getStore().load();
                }
            },
            'usersGrid actioncolumn':{
                click: function(grid,cell,row,col,e,record){
                    var me = this;
                    var url = me.requestUrl['del'];
                    var m = e.getTarget().className.indexOf("edit-col");
                    if(m >= 0){ //修改
                        Ext.widget("usersWin",{
                            title: '修改'
                        });

                        var form = me.getUsersForm();
                        form.getForm().loadRecord(record);
                    }else{
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                Ext.AjaxUtil.getAction({
                                    url : url,
                                    data: {id: record.get('id')},
                                    callback:function(data){
                                        grid.getStore().reload();
                                        Ext.example.msg("", "操作成功!");
                                    }
                                });
                            }
                        });
                    }
                }
            },
            'usersWin button[itemId=SaveBtn]':{
                click: function(btn){
                    var me = this;
                    var form = me.getUsersForm();
                    var values = form.getValues();
                    var grid = form.previousNode("usersGrid");
                    me.saveAction(values, grid);
                }
            }
        });
    },

    saveAction: function(values, grid){
        var me = this;
        if(!values){
            return;
        }
        if(!values.tel){
            Ext.example.msg("", "电话不能为空!");
            return;
        }
        var url = me.requestUrl['save'];
        var pd = {
            id: values.id,
            tel: values.tel
        };
        Ext.AjaxUtil.saveAction({
            url : url,
            type: 'POST',
            data: pd,
            callback: function(re){
                me.getUsersGrid().getStore().reload();
                Ext.example.msg("", "操作成功!");
                me.getUsersWin().close();
            }
        });
    },

    requestUrl: {
        list: dev_base + 'data/admin/user/list?_dt=' + Math.random(),
        del: dev_base + 'data/admin/user/edit?act=del&_dt=' + Math.random(),
        save: dev_base + 'data/admin/user/edit?act=update&_dt=' + Math.random()
    }
});