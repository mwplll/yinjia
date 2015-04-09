/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.DesignApp.controller.DesignController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.DesignApp.model.DesignModel',
        'PMS.apps.DesignApp.model.DesignRoomModel'
    ],
    stores: [
        'PMS.apps.DesignApp.store.DesignStore'
    ],
    views: [
        'PMS.apps.DesignApp.view.DesignGrid',
        'PMS.apps.DesignApp.view.DesignWin'
    ],
    refs: [
        {
            selector: 'appPanel [itemId=designTreeMenu]',
            ref: 'designTreeMenu'
        },
        {
            selector: 'designGrid',
            ref: 'designGrid'
        },
        {
            selector: 'designGrid #keywordsText',
            ref: 'keywordsText'
        },
        {
            selector: 'designWin',
            ref: 'designWin'
        },
        {
            selector: 'designWin designBaseForm',
            ref: 'designBaseForm'
        },
        {
            selector: 'designWin designBaseForm [itemId=designImageBoxWrap]',
            ref: 'designImageBoxWrap'
        },
        {
            selector: 'designWin designBaseForm [itemId=houseImageBoxWrap]',
            ref: 'houseImageBoxWrap'
        }
    ],
    init: function(){
        console.log("DesignController init");

        this.control({
            'designGrid':{
                afterrender: function(grid){
                    var me = this;
                    // 从treeMenu得到type参数
                    var treeMenu = me.getDesignTreeMenu(),
                        selectTreeNode = treeMenu.getSelectionModel().getSelection()[0],
                        type = selectTreeNode.raw.type;

                    // store中绑定type参数
                    var store = grid.getStore();
                    store.proxy.extraParams = {
                        "states[]": type
                    };

                    // 加载store
                    store.loadPage(1);
                }
            },
            // 关键字 检索
            "designGrid button[itemId=SearchButton]":{
                click: function(){
                    var me = this,
                        grid = me.getDesignGrid(),
                        store = grid.getStore(),
                        keywords = me.getKeywordsText().getValue();
                    console.log("keywords:" + keywords);
                    store.proxy.extraParams =  {
                        keywords: keywords
                    };
                    store.loadPage(1);
                }
            },
            "designGrid actioncolumn": {
                editHandler: function(type, grid, record){
                    var me = this;
                    var url = me.requestUrl[type];

                    var recommend = null;
                    if(type == 'del'){
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                action();
                            }
                        });
                    }else if(type == 'edit'){
                        me.editHandler(record);
                    }else if(type == 'up'){
                        url = me.requestUrl['recommend'];
                        recommend = 1;
                        action();
                    }else if(type == 'down'){
                        url = me.requestUrl['recommend'];
                        recommend = 0;
                        action();
                    }else{
                        action();
                    }
                    function action(){
                        Ext.AjaxUtil.getAction({
                            url : url,
                            data: {id: record.get("id"), recommend: recommend},
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

    editHandler: function(record){
        var me = this;

//        me.setDetailValues(record);

        var ctr = coreApp.loadController('PMS.apps.DesignApp.controller.DesignWinController');
        ctr.doInitial(record);

    },

    requestUrl: {
        del: dev_base + 'data/admin/design/schema/edit?act=del&_dt=' + Math.random(),
        audit: dev_base + 'data/admin/design/schema/edit?act=check&_dt='+ Math.random(),
        detail: dev_base + 'data/design/details?_dt=' + Math.random(),
        list: dev_base + 'data/admin/design/schema/list?_dt=' + Math.random(),

        recommend: dev_base + 'data/admin/design/schema/edit?act=recommend&_dt=' + Math.random()
    }
});