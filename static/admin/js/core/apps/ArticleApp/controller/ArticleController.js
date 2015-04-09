/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.ArticleApp.controller.ArticleController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.ArticleApp.model.ArticleModel',
        'PMS.apps.ArticleApp.model.CategoryModel'
    ],
    stores: [
        'PMS.apps.ArticleApp.store.ArticleStore'

    ],
    views: [
        'PMS.apps.ArticleApp.view.ArticleGrid'
    ],

    refs: [
        {
            selector: 'articleGrid',
            ref: 'articleGrid'
        },
        {
            selector: 'articleGrid #keywordsText',
            ref: 'keywordsText'
        },
        {
            selector: 'articleGrid #treeCombo',
            ref: 'catCombo'
        },
        {
            selector: 'articleGrid #periodCombo',
            ref: 'periodCombo'
        },
        {
            selector: 'articleGrid #stateCombo',
            ref: 'stateCombo'
        },
        {
            selector: 'articleGrid #storeNumCombo',
            ref: 'storeNumCombo'
        },
        {
            selector: 'articleGrid #brandCombo',
            ref: 'brandCombo'
        }
    ],


    init: function(){
        console.log("ArticleController init");

        this.control({
            "articleGrid": {
                afterrender: function(){
                    var me = this,
                        grid = me.getArticleGrid(),
                        store = grid.getStore();
                    store.proxy.extraParams =  {
                        "states[]": [0,2]
                    };
                    store.loadPage(1);

                    Ext.AjaxUtil.getAction({
                        url: me.requestUrl.listCategory,
                        callback: function (result) {
                            if(!result.data){
                                return;
                            }
                            var st = Ext.create("Ext.data.TreeStore", {
                                extend: 'Ext.data.TreeStore',
                                model: 'PMS.apps.ArticleApp.model.CategoryModel',
                                root: {
                                    expanded: true,
                                    text:  '根目录',
                                    id: 0,
                                    categoryId: 0,
                                    children: Ext.ToolUtil.createArticleTreeModel(result.data)
                                }
                            });
                            var treeCombo = Ext.create('Ext.ux.TreeCombo', {
                                store: st,
                                itemId: 'treeCombo',
                                emptyText: '选择文章分类'
                            });
                            grid.queryById('filterToolbar').insert(0, treeCombo);
                        }
                    });
                },
                itemdblclick: function(grid, record){
                    var me = this;
                    me.editHandler(record);
                },

                // 批量删除  批量上架 批量下架 批量审核
                actionHandler: function(type){
                    var me = this,
                        grid = me.getArticleGrid(),
                        selection = grid.getSelectionModel().getSelection();
                    if(!selection.length){
                        Ext.example.msg("", "请选择要操作的数据!");
                        return;
                    }
                    var url = me.requestUrl[type], ids = [];
                    Ext.each(selection, function(re){
                        ids.push(re.get("id"));
                    });
                    Ext.AjaxUtil.getAction({
                        url : url,
                        data: {ids:  "[" + ids.toString() + "]"},
                        callback:function(data){
                            grid.getStore().reload();
                            Ext.example.msg("", "操作成功!");
                        }
                    });
                }
            },
            // 添加商品
            "articleGrid button[itemId=addButton]":{
                click: function(){
                    coreApp.loadWorkPanel('ArticleWin','文章添加', 'PMS.apps.ArticleApp.controller.ArticleWinController');
                }
            },
            'articleGrid actioncolumn':{
                editHandler: function(type, grid, record){
                    var me = this;
                    var url = me.requestUrl[type];
                    var pd = {
                        id: record.get("id")
                    };
                    if(type == 'del'){
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                pd['state'] = 1;
                                action();
                            }
                        });
                    }else if(type == 'edit'){
                        me.editHandler(record);
                    }else{
                        if(type == 'up'){
                            pd['state'] = 0;
                        }else if(type == 'down'){
                            pd['state'] = 2
                        }
                        action();
                    }
                    function action(){
                        Ext.AjaxUtil.getAction({
                            url : url,
                            data: pd,
                            callback:function(data){
                                grid.getStore().reload();
                                Ext.example.msg("", "操作成功!");
                            }
                        });
                    }
                }
            },

            // 条件 筛选
            "articleGrid button[itemId=FilterButton]":{
                click: function(){
                    var me = this,
                        grid = me.getArticleGrid(),
                        store = grid.getStore(),
                        state = me.getStateCombo().getValue(),
                        storeNum = me.getStoreNumCombo().getValue(),

                        catId = me.getCatCombo().getValue();
                    var pd = {};
                    if(catId !== ''&& catId !== undefined&& catId !== null){
                        pd['catId'] = Number(catId);
                    }
                    if(state !== ''&& state !== undefined && state !== null){
                        pd['state'] = Number(state);
                    }
                    console.log("condition:");
                    console.log(pd);
                    store.proxy.extraParams = pd;
                    store.loadPage(1);
                }
            },

            // 名称 检索
            "articleGrid button[itemId=SearchButton]":{
                click: function(){
                    var me = this,
                        grid = me.getArticleGrid(),
                        store = grid.getStore(),
                        keywords = me.getKeywordsText().getValue();
                    console.log("keywords:" + keywords);
                    store.proxy.extraParams =  {
                        keywords: keywords
                    };
                    store.loadPage(1);
                }
            }
        });
    },

    editHandler: function(record){
        var me = this;
        var ctr = coreApp.loadController('PMS.apps.ArticleApp.controller.ArticleWinController');
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.detail,
            data: {id: record.get("id")},
            callback: function(result){
                var model = Ext.create("PMS.apps.ArticleApp.model.ArticleModel", result.data);
                ctr.record = model;
                coreApp.loadWorkPanel('articleWin','编辑文章');
            }
        });
    },

    requestUrl: {
        uploadArticle: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=Article",
        up: dev_base + 'data/article/edit?act=del&_dt=' + Math.random() + "&state=0",
        down: dev_base + 'data/article/edit?act=del&_dt=' + Math.random() + "&state=2",
        audit: dev_base + 'data/article/edit?act=state&_dt=' + Math.random() + "&state=3",
        del: dev_base + 'data/article/edit?act=del&_dt=' + Math.random() + "&state=1",
        list: dev_base + 'data/article/list?_dt=' + Math.random(),
        listCategory: dev_base + 'data/article/category/list?_dt=' + Math.random(),
        detail: dev_base + 'data/article/info?_dt=' + Math.random()
    }
});