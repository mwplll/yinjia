/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.DesignApp.controller.CommentController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.DesignApp.model.CommentModel'
    ],
    stores: [
        'PMS.apps.DesignApp.store.CommentStore'
    ],
    views: [
        'PMS.apps.DesignApp.view.CommentGrid'
    ],
    refs: [
       
        {
            selector: 'commentGrid',
            ref: 'commentGrid'
        }
    ],
    init: function(){
        console.log("CommentController init");

        this.control({
            'commentGrid':{
                afterrender: function(grid){
                    var me = this;

                    // store中绑定type参数
                    var store = grid.getStore();

                    // 加载store
                    store.loadPage(1);
                }
            },
            "commentGrid actioncolumn": {
                editHandler: function(type, grid, record){
                    var me = this;
                    var url = me.requestUrl[type];

                    if(type == 'del'){
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                action();
                            }
                        });
                    }
                    function action(){
                        Ext.AjaxUtil.getAction({
                            url : url,
                            data: {id: record.get("id")},
                            callback:function(data){
                                grid.getStore().reload();
                                Ext.example.msg("", "操作成功!");
                            }
                        });
                    }
                }
            }
        });
    },

    requestUrl: {
        del: dev_base + 'data/design/comment/edit?act=del&_dt=' + Math.random(),
        list: dev_base + 'data/design/comment/list?_dt=' + Math.random()
    }
});