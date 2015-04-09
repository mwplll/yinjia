/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.GoodsApp.controller.SkuImageController",{
    extend: 'Ext.app.Controller',
    models: [
         'PMS.apps.GoodsApp.model.SkuImageModel'
    ],
    stores: [
         'PMS.apps.GoodsApp.store.SkuImageStore'
    ],
    views: [
        'PMS.apps.GoodsApp.view.SkuImageList'
    ],

    refs: [
        {
            selector: 'skuImageList',
            ref: 'skuImageList'
        }
    ],
    init: function(){
        console.log("SkuImageController init");

        this.control({
            "skuImageList":{
                afterrender: function(){
                    var me = this,
                        grid = me.getSkuImageList();
                    grid.getStore().loadPage(1);
                }
            },
            "skuImageList button[itemId=RemoveAllButton]": {
                click: function(){
                    var me = this,
                        grid = me.getSkuImageList();
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
            'skuImageList actioncolumn':{
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
                    }
                }
            }
        });
    },

    requestUrl: {
        list: dev_base + 'data/spec/pic/list?_dt=' + Math.random(),
        del: dev_base + 'data/spec/pic/edit?act=delete&_dt=' + Math.random()
    }
});