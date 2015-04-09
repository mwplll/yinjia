/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.DesignersApp.controller.DesignersController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.DesignersApp.model.DesignersModel'
    ],
    stores: [
        'PMS.apps.DesignersApp.store.DesignersStore'
    ],
    views: [
        'PMS.apps.DesignersApp.view.DesignersGrid',
        'PMS.apps.DesignersApp.view.DesignersCheckWin',
        'PMS.apps.DesignersApp.view.DesignersWin'
    ],

    refs:[
        {
            selector: 'appPanel [itemId=designerTreeMenu]',
            ref: 'designerTreeMenu'
        },
        {
            selector: 'designersWin',
            ref: 'designersWin'
        },
        {
            selector:'designersWin form',
            ref:'designersForm'
        },
        {
            selector:'designersGrid',
            ref:'designersGrid'
        },
        {
            selector:'designersCheckWin',
            ref:'designersCheckWin'       
        },
        {
            selector:'designersCheckWin form',
            ref:'designersCheckForm'       
        }
    ],
    init: function(){
        console.log("DesignersController init");

        this.control({
            'designersGrid':{
                afterrender: function(grid){
                    var me = this;
                    // 从treeMenu得到type参数
                    var treeMenu = me.getDesignerTreeMenu(),
                        selectTreeNode = treeMenu.getSelectionModel().getSelection()[0],
                        type = selectTreeNode.raw.type;

                    // store中绑定type参数
                    var store = grid.getStore();
                    store.proxy.extraParams = {
                        "states[]": type,
                        isSpecial: 1
                    };

                    // 加载store
                    store.load();

                    // 动态显示列
                    if(type == '0'){ //审核失败
                        grid.columns[5].show();
                        grid.columns[6].show();
                        grid.columns[7].hide();
                    }else if(type == '1'){//审核成功
                        grid.columns[5].hide();
                        grid.columns[6].hide();
                        grid.columns[7].show();
                    }else{
                        grid.columns[5].hide();
                        grid.columns[6].hide();
                        grid.columns[7].show();
                    }
                }
            },
            'designersGrid actioncolumn':{
                click: function(grid,cell,row,col,e,record){
                    var me = this;
                    me.modifyAction(grid,e,record);
                }
            },

            'designersWin button[itemId=SaveBtn]':{
                click: function(btn){
                    var me = this;
                    var form = me.getDesignersForm();
                    var values = form.getValues();
                    var grid = me.getDesignersGrid();
                    console.log(grid);
                    me.saveAction(values, grid);
                }
            },
            'designersCheckWin button[itemId=pass]':{
                click: function(btn){
                    var me = this;
                    var form = me.getDesignersCheckForm();
                    var values = form.getValues();
                    var grid = me.getDesignersGrid();
                    me.checkAction(values, grid, 1);
                }
            },
            'designersCheckWin button[itemId=fail]':{
                click: function(btn){
                    var me = this;
                    var form = me.getDesignersCheckForm();
                    var values = form.getValues();
                    var grid = me.getDesignersGrid();
                    me.checkAction(values, grid, 0);
                }
            }

        });
    },

    modifyAction: function(grid,e,record){
        var me = this;
        var url = me.requestUrl['del'];
        var m = e.getTarget().className.indexOf("edit-col");
        var n = e.getTarget().className.indexOf("revert");


        if(m >= 0){ //修改
            Ext.widget("designersWin",{
                title: '修改'
            });
            var form = me.getDesignersForm();
            form.getForm().loadRecord(record);
        } else if( n >= 0) {
            var isCheck = record.get('state');
            Ext.widget("designersCheckWin",{
                title: '修改'
            });
            
            var form = me.getDesignersCheckForm();
            form.getForm().loadRecord(record);
            var frontUrl = image_base + record.get('cidFrontPic');
            var backUrl = image_base + record.get('cidBackPic');
            
            var win = me.getDesignersCheckWin();
            win.queryById('frontPic').setSrc(frontUrl);
            win.queryById('backPic').setSrc(backUrl);
        }
        else{
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
    },
    checkAction: function(values, grid, ok) {
        var me = this;
        var url = me.requestUrl['check']; 

        if(ok == 1){
            var pd = {
                id: values['id'],
                isChecked: 1
            };
            Ext.AjaxUtil.getAction({
                url : url,
                type: 'GET',
                data: pd,
                callback:function(data){
                    grid.getStore().reload();
                    Ext.example.msg("", "操作成功!");
                    me.getDesignersCheckWin().close();
                }
            });
        }
        else if(ok == 0){
            var pd = {
                id: values['id'],
                isChecked: 0,
                failReason: values['reason']
            };
            Ext.AjaxUtil.getAction({
                url : url,
                type: 'GET',
                data: pd,
                callback:function(data){
                    grid.getStore().reload();
                    Ext.example.msg("", "操作成功!");
                    me.getDesignersCheckWin().close();
                }
            });
        }      
    },


    saveAction: function(values, grid){
        var me = this;
        if(!values){
            return;
        }
        if(!values.user_tel){
            Ext.example.msg("", "电话不能为空!");
            return;
        }
        if(!values.true_name){
            Ext.example.msg("", "姓名不能为空!");
            return;
        }
        if(!values.cid){
            Ext.example.msg("", "身份证不能为空!");
            return;
        }
        var url = me.requestUrl['save'];
        var pd = {
            id: values.id,
            tel: values.tel,
            name: values.realName,
            cid: values.cid
        };
        Ext.AjaxUtil.saveAction({
            url : url,
            type: 'POST',
            data: pd,
            callback: function(re){
                grid.getStore().reload();
                Ext.example.msg("", "操作成功!");
                me.getDesignersWin().close();
            }
        });
    },

    requestUrl: {
        list: dev_base + 'data/admin/user/list?_dt=' + Math.random(),
        del: dev_base + 'data/admin/user/edit?act=del&_dt=' + Math.random(),
        save: dev_base + 'data/admin/user/edit?act=update&_dt=' + Math.random(),
        check: dev_base + 'data/admin/user/edit?act=check&_dt=' + Math.random()
    }
});