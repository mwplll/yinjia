/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.GoodsApp.controller.SupplyController",{
    extend: 'Ext.app.Controller',
    models: [
         'PMS.apps.GoodsApp.model.SupplyModel'
    ],
    stores: [
         'PMS.apps.GoodsApp.store.SupplyStore'
    ],
    views: [
        'PMS.apps.GoodsApp.view.SupplyList',
        'PMS.apps.GoodsApp.view.SupplyWin'
    ],

    refs: [
        {
            selector: 'supplyList',
            ref: 'supplyList'
        },
        {
            selector: 'supplyWin',
            ref: 'supplyWin'
        },
        {
            selector: 'supplyWin supplyBaseForm',
            ref: 'supplyBaseForm'
        }
    ],
    init: function(){
        console.log("SupplyController init");

        this.control({
            "supplyList":{
                afterrender: function(){
                    var me = this,
                        grid = me.getSupplyList(),
                        st = grid.getStore();
                    Ext.apply(st,{pageSize: 15});
                    st.loadPage(1);
                },
                itemdblclick: function(grid, record){
                    var me = this;
                    Ext.widget("supplyWin", {
                        title: '编辑供应商'
                    });
                    me.getSupplyBaseForm().setFormValues(record);
                }
            },
            "supplyList button[itemId=AddButton]": {
                click: function(grid, record){
                    var me = this;
                    Ext.widget("supplyWin");
                }
            },
            "supplyList button[itemId=RemoveAllButton]": {
                click: function(){
                    var me = this,
                        grid = me.getSupplyList();
                    var selection = grid.getSelectionModel().getSelection();
                    if(!selection.length){
                        Ext.example.msg("", "请先选择要删除的数据");
                        return;
                    }
                    var ids = [];
                    Ext.each(selection, function(el){
                        ids.push(el.get('id'));
                    });
                    Ext.AjaxUtil.getAction({
                        url : me.requestUrl['del'],
                        data: {ids: "[" + ids.toString() + "]"},
                        callback:function(data){
                            grid.getStore().reload();
                            Ext.example.msg("", "操作成功!");
                        }
                    });
                }
            },
            'supplyList actioncolumn':{
                click: function(grid,cell,row,col,e,record){
                    var me = this;
                    var url = me.requestUrl['del'];
                    var className = e.getTarget().className;
                    if(className.indexOf("delete-col") >= 0){ //删除
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                Ext.AjaxUtil.getAction({
                                    url : url,
                                    data: {ids: "[" + record.get("id")+ "]"},
                                    callback:function(data){
                                        grid.getStore().reload();
                                        Ext.example.msg("", "操作成功!");
                                    }
                                });
                            }
                        });
                    }else if(className.indexOf("edit-col") >= 0){
                        Ext.widget("supplyWin", {
                            title: '编辑供应商'
                        });
                        me.getSupplyBaseForm().setFormValues(record);
                    }
                }
            },
            "supplyWin button[itemId=SaveButton]": {
                click: function(){
                    var me = this,
                        form = me.getSupplyBaseForm();
                    if(!form.getForm().isValid()){
                        return;
                    }
                    var values = form.getFormValues();
                    if(values.error){
                        Ext.example.msg("", values.error);
                        return;
                    }
                    var url = me.requestUrl['save'];
                    Ext.AjaxUtil.saveAction({
                        url : url,
                        data: values,
                        callback: function(re){
                            Ext.example.msg("", "操作成功!");
                            me.getSupplyWin().close();
                            me.getSupplyList().getStore().load();
                        }
                    });
                }
            }
        });
    },

    requestUrl: {
        save:  dev_base + 'data/provider/edit?act=save&_dt=' + Math.random(),
        list: dev_base + 'data/provider/list?_dt=' + Math.random(),
        del: dev_base + 'data/provider/edit?act=delete&_dt=' + Math.random()
    }
});