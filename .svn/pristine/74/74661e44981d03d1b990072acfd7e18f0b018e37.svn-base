/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.UsersApp.controller.AdminController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.UsersApp.model.AdminModel'
    ],
    stores: [
        'PMS.apps.UsersApp.store.AdminStore'
    ],
    views: [
        'PMS.apps.UsersApp.view.AdminGrid'
    ],

    refs:[
        {
            selector: 'adminWin',
            ref: 'adminWin'
        },
        {
            selector:'adminWin form',
            ref:'adminForm'
        },
        {
            selector:'adminGrid',
            ref:'adminGrid'
        }
    ],
    init: function(){
        console.log("AdminController init");

        this.control({
            'adminGrid':{
                afterrender: function(grid){
                    grid.getStore().load();
                }
            },
            'adminGrid button[action=Add]':{
                click: function () {
                    var me = this;
                    Ext.widget("adminWin",{
                        title: '新增'
                    });
                }
            },
            'adminGrid actioncolumn':{
                editHandler: function(grid, record){
                    var me = this;
                    Ext.widget("adminWin",{
                        title: '修改'
                    });
                    var form = me.getAdminForm();
                    form.getForm().loadRecord(record);
                },

                delHandler: function(grid, record){
                    var me = this;
                    Ext.Msg.confirm('删除', "确认删除？", function(btn){
                        if(btn == 'yes'){
                            Ext.AjaxUtil.getAction({
                                url : me.requestUrl['del'],
                                data: {id: record.get("id")},
                                callback:function(data){
                                    grid.getStore().reload();
                                    Ext.example.msg("", "操作成功!");
                                }
                            });
                        }
                    });
                }
            },
            'adminWin button[itemId=SaveBtn]':{
                click: function(btn){
                    var me = this;
                    var form = me.getAdminForm();
                    var values = form.getValues();
                    var grid = form.previousNode("adminGrid");
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
        if(!values.user){
            Ext.example.msg("", "用户名不能为空!");
            return;
        }
        var url = me.requestUrl['add'];
        var pd = {
            user: values.user,
            isSpecial: values.isSpecial
        };
        if(values.id){
            url = me.requestUrl['update'];
            pd['id'] = values.id;
        }
        if(values.pwd){
            pd['pwd'] = values.pwd;
        }
        if(values.id && !values.pwd){
            Ext.example.msg("", "请输入密码!");
            return;
        }
        Ext.AjaxUtil.saveAction({
            url : url,
            type: 'POST',
            data: pd,
            callback: function(re){
                me.getAdminGrid().getStore().reload();
                Ext.example.msg("", "操作成功!");
                me.getAdminWin().close();
            }
        });
    },

    requestUrl: {
        list: dev_base + 'data/admin/user/list?_dt=' + Math.random(),
        del: dev_base + 'data/admin/user/edit?act=del&_dt=' + Math.random(),
        update: dev_base + 'data/admin/user/edit?act=update&_dt=' + Math.random(),
        add: dev_base + 'data/admin/user/edit?act=add&_dt=' + Math.random()
    }
});