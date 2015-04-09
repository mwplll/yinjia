/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.GoodsApp.controller.GoodsController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.GoodsApp.model.GoodsModel',
        'PMS.apps.GoodsApp.model.CategoryModel'
    ],
    stores: [
        'PMS.apps.GoodsApp.store.GoodsStore'

    ],
    views: [
        'PMS.apps.GoodsApp.view.GoodsGrid'
    ],

    refs: [
        {
            selector: 'goodsGrid',
            ref: 'goodsGrid'
        },
        {
            selector: 'goodsGrid #keywordsText',
            ref: 'keywordsText'
        },
        {
            selector: 'goodsGrid #treeCombo',
            ref: 'catCombo'
        },
        {
            selector: 'goodsGrid #periodCombo',
            ref: 'periodCombo'
        },
        {
            selector: 'goodsGrid #stateCombo',
            ref: 'stateCombo'
        },
        {
            selector: 'goodsGrid #storeNumCombo',
            ref: 'storeNumCombo'
        },
        {
            selector: 'goodsGrid #brandCombo',
            ref: 'brandCombo'
        }
    ],


    init: function(){
        console.log("GoodsController init");

        this.control({
            "goodsGrid": {
                afterrender: function(){
                    var me = this,
                        grid = me.getGoodsGrid(),
                        store = grid.getStore();

                    // 如果是从编辑 回来的，则不重置store
                    if(me.from != 'edit'){
                        store.proxy.extraParams =  {
                            keywords: ''
                        };
                        store.loadPage(1);
                    }

                    Ext.AjaxUtil.getAction({
                        url: me.requestUrl.listCategory,
                        callback: function (result) {
                            if(!result.data){
                                return;
                            }
                            var st = Ext.create("Ext.data.TreeStore", {
                                extend: 'Ext.data.TreeStore',
                                model: 'PMS.apps.GoodsApp.model.CategoryModel',
                                root: {
                                    expanded: true,
                                    text:  '根目录',
                                    id: 0,
                                    categoryId: 0,
                                    children: Ext.ToolUtil.createGoodsTreeModel(result.data)
                                }
                            });
                            var treeCombo = Ext.create('Ext.ux.TreeCombo', {
                                store: st,
                                itemId: 'treeCombo',
                                emptyText: '选择商品分类'
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
                        grid = me.getGoodsGrid(),
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
            "goodsGrid button[itemId=addButton]":{
                click: function(){
                    coreApp.loadWorkPanel('goodsWin','商品添加', 'PMS.apps.GoodsApp.controller.GoodsWinController');
                }
            },
            'goodsGrid actioncolumn':{
                editHandler: function(type, grid, record){
                    var me = this;
                    var url = me.requestUrl[type];
                    if(type == 'del'){
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                action();
                            }
                        });
                    }else if(type == 'edit'){
                        me.editHandler(record);
                    }else{
                        action();
                    }
                    function action(){
                        Ext.AjaxUtil.getAction({
                            url : url,
                            data: {ids: "[" + record.get("id") + "]"},
                            callback:function(data){
                                grid.getStore().reload();
                                Ext.example.msg("", "操作成功!");
                            }
                        });
                    }
                }
            },

            // 条件 筛选
            "goodsGrid button[itemId=FilterButton]":{
                click: function(){
                    var me = this,
                        grid = me.getGoodsGrid(),
                        store = grid.getStore(),
                        period = me.getPeriodCombo().getValue(),
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
                    if(period !== ''&& period !== undefined && period !== null){
                        pd['period'] = Number(period);
                    }
                    if(storeNum){
                        storeNum = storeNum.split(",");
                        pd['minNum'] = Number(storeNum[0]);
                        pd['maxNum'] = Number(storeNum[1]);
                    }
                    console.log("condition:");
                    console.log(pd);
                    store.proxy.extraParams = pd;
                    store.loadPage(1);
                }
            },

            // 名称 检索
            "goodsGrid button[itemId=SearchButton]":{
                click: function(){
                    var me = this,
                        grid = me.getGoodsGrid(),
                        store = grid.getStore(),
                        brand = me.getBrandCombo().getValue(),
                        keywords = me.getKeywordsText().getValue();

                    if(brand == 0){
                        console.log("keywords:" + keywords);
                        store.proxy.extraParams =  {
                            keywords: keywords
                        };
                    }else{
                        console.log("brand name:" + keywords);
                        store.proxy.extraParams =  {
                            brand: keywords
                        };
                    }
                    store.loadPage(1);
                }
            }
        });
    },

    editHandler: function(record){
        var me = this;
        var ctr = coreApp.loadController('PMS.apps.GoodsApp.controller.GoodsWinController');
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.detail,
            data: {id: record.get("id")},
            callback: function(result){
                var model = Ext.create("PMS.apps.GoodsApp.model.GoodsModel", result.data);
                ctr.record = model;
                ctr.initSeries = true;
                coreApp.loadWorkPanel('goodsWin','编辑商品');
            }
        });
    },

    requestUrl: {
        uploadGoods: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=goods",
        up: dev_base + 'data/goods/edit?act=state&_dt=' + Math.random() + "&state=0",
        down: dev_base + 'data/goods/edit?act=state&_dt=' + Math.random() + "&state=2",
        audit: dev_base + 'data/goods/edit?act=state&_dt=' + Math.random() + "&state=3",
        del: dev_base + 'data/goods/edit?act=state&_dt=' + Math.random() + "&state=1",
        list: dev_base + 'data/goods/list?_dt=' + Math.random(),
        listCategory: dev_base + 'data/category/list?_dt=' + Math.random(),
        detail: dev_base + 'data/goods/info?_dt=' + Math.random()
    }
});