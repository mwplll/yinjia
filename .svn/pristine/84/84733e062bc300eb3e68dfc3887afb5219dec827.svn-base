/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.GoodsApp.controller.GoodsWinController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.GoodsApp.model.GoodsModel',
        'PMS.apps.GoodsApp.model.CategoryModel',
        'PMS.apps.GoodsApp.model.GoodsImageModel',
        'PMS.apps.GoodsApp.model.GoodsSkuModel',
        'PMS.apps.GoodsApp.model.BrandModel',
        'PMS.apps.GoodsApp.model.BrandSerialModel',
        'PMS.apps.GoodsApp.model.SupplyModel',
        'PMS.apps.GoodsApp.model.SkuModel',
        'PMS.apps.GoodsApp.model.SkuItemModel'
    ],
    stores: [
        'PMS.apps.GoodsApp.store.SkuStore',
        'PMS.apps.GoodsApp.store.BrandStore',
        'PMS.apps.GoodsApp.store.SupplyStore'
    ],

    views: [
        'PMS.apps.GoodsApp.view.GoodsWin',
        'PMS.apps.GoodsApp.view.GoodsSkuWin',
        'PMS.apps.GoodsApp.view.SkuWin'
    ],

    refs: [
        {
            selector: 'appPanel centerPanel',
            ref: 'centerPanel'
        },
        {
            selector: 'goodsWin',
            ref: 'goodsWin'
        },
        {
            selector: 'goodsWin goodsBaseForm',
            ref: 'goodsBaseForm'
        },
        {
            selector: 'goodsWin goodsBaseForm goodsSkus grid',
            ref: 'goodsSkusGrid'
        },
        {
            selector: 'goodsWin goodsBaseForm goodsImageList grid',
            ref: 'goodsImageGrid'
        },
        {
            selector: 'goodsWin goodsBaseForm [itemId=imageBoxWrap]',
            ref: 'imageBoxWrap'
        },
        {
            selector: 'goodsWin goodsBaseForm [itemId=goodsCategoryTree]',
            ref: 'goodsCategoryTree'
        },
        {
            selector: 'goodsWin goodsBaseForm [itemId=brandCombo]',
            ref: 'brandCombo'
        },
        {
            selector: 'goodsWin goodsBaseForm [itemId=providerCombo]',
            ref: 'providerCombo'
        },
        {
            selector: 'goodsWin goodsBaseForm [itemId=seriesCombo]',
            ref: 'seriesCombo'
        },
        {
            selector: 'goodsWin tabpanel',
            ref: 'tabPanel'
        },
        {
            selector: 'goodsWin goodsDetailForm ueditor',
            ref: 'goodsUeditorForm'
        },
        {
            selector: 'goodsSkuWin',
            ref: 'goodsSkuWin'
        },
        {
            selector: 'skuWin skuBaseForm',
            ref: 'skuBaseForm'
        }
    ],

    record: null,

    // 品牌 系列 异步的问题
    initSeries: true,

    init: function(){
        console.log("GoodsWinController init");

        this.control({
            "goodsWin":{
                afterrender: function(){
                    var me = this;
                    var tabPanel = me.getTabPanel();
                    var items = tabPanel.items.items;

                    // hack 富文本编辑器 优先初始化
                    for(var i = items.length - 1;i >= 0; i--){
                        tabPanel.setActiveTab(items[i]);
                    }

                    var brandCombo = me.getBrandCombo(),
                        st = brandCombo.getStore(),
                        providerCombo = me.getProviderCombo(),
                        st2 = providerCombo.getStore();

                    Ext.apply(st,{ pageSize: 1000});Ext.apply(st2,{pageSize: 1000});

                    brandCombo.un("change", me.brandComboChange);

                    // 品牌
                    st.load(function(){
                        if(me.record){
                            brandCombo.setValue(me.record.get("brandId"));
                        }
                    });
                    // 供应商
                    st2.load(function(){
                        if(me.record){
                            providerCombo.setValue(me.record.get("providerId"))
                        }
                    });

                    // 显示类别
                    me.initCategoryCombo(function(){
                        if(me.record){
                            me.getGoodsBaseForm().queryById("treeCombo").setValue(me.record.get("catId"));
                        }
                    });

                    // 详情 赋值
                    if(me.record){
//                        me.getGoodsBaseForm().getForm().loadRecord(me.record);
                        me.initSkuGrid(me.record);
                        me.initImageGrid(me.record);

                        me.getGoodsBaseForm().queryById("name").setValue(me.record.get("name"));
                        me.getGoodsBaseForm().queryById("goodsSn").setValue(me.record.get("goodsSn"));
                        me.getGoodsBaseForm().queryById("unit").setValue(me.record.get("unit"));
                        me.getGoodsBaseForm().queryById("stateCombo").setValue(me.record.get("state"));
                        me.getGoodsBaseForm().queryById("periodCombo").setValue(me.record.get("period"));
                        me.getGoodsBaseForm().queryById("sort").setValue(me.record.get("sort"));
                        me.getGoodsBaseForm().queryById("productId").setValue(me.record.get("id"));
                    }else{
                        me.initSkuGrid();
                        me.initImageGrid();
                    }
                }
            },

            "goodsWin goodsDetailForm ueditor":{
                initialize: function(){
                    var me = this;
                    if(me.record){
                        me.getGoodsUeditorForm().setValue(me.record.get("content"));
                    }
                }
            },

            "goodsWin goodsBaseForm button[itemId=uploadGoodsButton]":{
                click: function(btn){
                    var me = this;
                    coreApp.fireEvent("UploadHouse", {
                        targetCtr: me,
                        uploadUrl: me.requestUrl.uploadGoods
                    });
                }
            },
            "goodsWin goodsBaseForm combo[itemId=brandCombo]":{
                change: function(combo){
                    console.log(1);
                    var me = this;
                    var record = combo.findRecordByValue(combo.getValue());
                    var seriesCombo = me.getSeriesCombo();
                    var st = seriesCombo.getStore();
                    if(st){
                        st.removeAll();
                    }
                    seriesCombo.setValue('');
                    var seriesList = record.get("seriesList");
                    if(!seriesList.length){
                        return;
                    }
                    var st2 = Ext.create("Ext.data.Store", {
                        model: 'PMS.apps.GoodsApp.model.BrandSerialModel',
                        data: seriesList
                    });
                    seriesCombo.bindStore(st2);
                    if(me.record && me.initSeries){
                        Ext.each(seriesList, function(item){
                            if(Number(item.seriesId) == Number(me.record.get("seriesId"))){
                                seriesCombo.setValue(item.seriesId);
                            }
                        });
                    }
                    me.initSeries = false;

                }
            },

            // 商品 基本数据 添加规格
            "goodsWin goodsBaseForm goodsSkus button[itemId=addSkuButton]":{
                click: function(){
                    var me = this;
//                    var grid = me.getGoodsSkusGrid(),
//                        store = grid.getStore();
//                    if(store.getCount() > 0){
//                        var rec = store.getAt(0);
//                        if(rec.get("specArray") && rec.get("specArray").length){
//                            Ext.example.msg("", "新增规格必须先清空所有商品基本数据!");
//                            return;
//                        }
//                    }
                    Ext.widget("goodsSkuWin");
                    var combo = me.getGoodsSkuWin().queryById('skuCombo');
                    var st = combo.getStore();
                    Ext.apply(st,{pageSize: 1000});
                    st.loadPage(1);
                }
            },
            "goodsWin goodsBaseForm goodsSkus grid actioncolumn":{
                removeAction: function(grid){
                    var st = grid.getStore();
                    if(st.getCount() <= 0){
                        // Create a model instance
                        var r = Ext.create('PMS.apps.GoodsApp.model.GoodsSkuModel', {
                            'productId': '',
                            'productSn': '',
                            'sellPrice': '',
                            'marketPrice': '',
                            'costPrice': '',
                            'storeNum': 100,
                            'weight': '',
                            'specArray':''
                        });

                        st.insert(0, r);
                    }
                }
            },

            "goodsWin goodsImageList grid":{
                select: function(_, record){
                    var me = this,
                        grid = me.getGoodsImageGrid(),
                        store = grid.getStore();
                    store.each(function(rec){
                        if(rec.get("pic") == record.get("pic")){
                            rec.set("is_main", true);
                        }else{
                            rec.set("is_main", false);
                        }
                    });
                }
            },

            "goodsWin button[itemId=SaveButton]":{
                click: function(){
                    var me = this;
                    var tabPanel = me.getTabPanel();
                    var active = tabPanel.getActiveTab();
                    // 保存基本信息
//                    if(active.index == 0){
                        var  goodsForm = me.getGoodsBaseForm();
                        var pid = me.getGoodsBaseForm().queryById("productId").getValue();
                        if(!goodsForm.getForm().isValid()){
                            return;
                        }
                        var values = goodsForm.getFormValues();
                        console.log("goods save:");
                        console.log(values);
                        if(values.error){
                            Ext.example.msg("错误", values.error);
                            return;
                        }

                        var text = me.getGoodsUeditorForm().getHtmlValue();
                        console.log("ueditor content:");
                        console.log(text);
                        values['content'] = text;

                        Ext.AjaxUtil.saveAction({
                            url : me.requestUrl['save'],
                            data: values,
                            callback: function(re){
                                Ext.example.msg("", "操作成功!");

                                var ctr = coreApp.loadController('PMS.apps.GoodsApp.controller.GoodsController');
                                if(pid){
                                    // 编辑
                                    ctr.from = 'edit';
                                }else{
                                    ctr.from = null;
                                }

                                coreApp.loadWorkPanel('goodsGrid','商品列表', 'PMS.apps.GoodsApp.controller.GoodsController');
                            }
                        });
//                    }else if(active.index == 1){
//                        var pid = me.getGoodsBaseForm().queryById("productId").getValue();
//                        if(!pid){
//                            Ext.example.msg("", "请先保存商品基本信息!");
//                            return;
//                        }
//                        var text = me.getGoodsUeditorForm().getHtmlValue();
//                        console.log("ueditor content:");
//                        console.log(text);
//                        Ext.AjaxUtil.saveAction({
//                            url : me.requestUrl['saveContent'],
//                            data: {id: pid, content: text},
//                            callback: function(re){
//                                Ext.example.msg("", "操作成功!");
//                                coreApp.loadWorkPanel('goodsGrid','商品列表', 'PMS.apps.GoodsApp.controller.GoodsController');
//                            }
//                        });
//                    }
                }
            },

            "goodsSkuWin panel combo":{
                change: function(combo, value){
                    var me = this;
                    var record = combo.findRecordByValue(value);
                    var tabPanel = me.getGoodsSkuWin().queryById("tabPanel"),
                        panels = tabPanel.items.items, bool = false;
                    Ext.each(panels, function(it){
                        if(it._id == value){
                            bool = true;
                        }
                    });
                    if(bool){return;}
                    var p = Ext.widget('skuSelectPanel',{
                        title: record.get("name"),
                        _id: record.get("id"),
                        type: record.get("type"),
                        closable: true,
                        border: false
                    });
                    tabPanel.add(p);
                    tabPanel.setActiveTab(p);
                    Ext.AjaxUtil.getAction({
                        url : me.requestUrl['skuDetail'],
                        data: {id: record.get('id')},
                        callback:function(result){
                            var _tp_ = [], i = 0;
                            if(Number(record.get('type')) == 1){
                                var picList = result.data.picList;
                                for(i = 0;i< picList.length;i++){
                                    _tp_.push({
                                        value: picList[i].picName,
                                        serial: picList[i].pic,
                                        id: picList[i].picId
                                    })
                                }
                            }else{
                                var tp2 = result.data.value.split(",");
                                for(i = 0;i< tp2.length;i++){
                                    _tp_.push({
                                        value: tp2[i]
                                    });
                                }
                            }
                            var store = Ext.create("Ext.data.Store",{
                                model: 'PMS.apps.GoodsApp.model.SkuItemModel',
                                data: _tp_
                            });
                            p.queryById("skuSelectGrid").bindStore(store);
                        }
                    });
                }
            },
            "goodsSkuWin button[itemId=AddSelectButton]":{
                click: function(){
                    coreApp.loadController('PMS.apps.GoodsApp.controller.SkuController');
                    Ext.widget("skuWin");
                    var me = this;
                    me.getSkuBaseForm().setFormValues(null);
                }
            },
            "goodsSkuWin skuSelectPanel grid button[itemId=EditSelectButton]":{
                click: function(btn){
                    coreApp.loadController('PMS.apps.GoodsApp.controller.SkuController');
                    var me = this;
                    var skuid = btn.findParentByType('skuSelectPanel')._id;
                    if(!skuid){
                        return;
                    }
                    Ext.widget("skuWin", {
                        title: '编辑规格'
                    });
                    Ext.AjaxUtil.getAction({
                        url : me.requestUrl['skuDetail'],
                        data: {id: skuid},
                        callback:function(result){
                            var re = Ext.create('PMS.apps.GoodsApp.model.SkuModel', result.data);
                            me.getSkuBaseForm().setFormValues(re);
                        }
                    });
                }
            },

            "goodsSkuWin button[itemId=SaveButton]":{
                click: function(){
                    var me = this,
                        win = me.getGoodsSkuWin(),
                        values = win.getFormValues();
                    win.close();
                    console.log("combine array:");
                    console.log(values);
                    var grid = me.getGoodsSkusGrid();

                    var skuList = [];
                    Ext.each(values, function(ve, i){
                        var obj = {
                            'productsId': '',
                            'productsSn': i+1,
                            'sellPrice': '',
                            'marketPrice': '',
                            'costPrice': '',
                            'storeNum': 100,
                            'weight': '',
                            'specArray': ve
                        };
                        skuList.push(obj);
                    });
                    console.log(skuList);
                    var st = Ext.create("Ext.data.Store",{
                        model: 'PMS.apps.GoodsApp.model.GoodsSkuModel',
                        data: skuList
                    });

                    grid.bindStore(st);
                }
            }
        });
    },

    resetSkuPanel: function(raw){
        var me = this,
            activePanel = me.getGoodsSkuWin().queryById("tabPanel").getActiveTab();
        if(!activePanel){
            return;
        }
        activePanel.setTitle(raw.name);
        activePanel._id = raw.id;
        activePanel.type = raw.type;
        var i = 0, _tp_ = [];
        if(Number(raw.type) == 1){
            var picList = raw.pic;
            for(i = 0;i< picList.length;i++){
                _tp_.push({
                    value: raw.picName[i],
                    serial: raw.pic[i],
                    id: raw.picId[i]
                })
            }
        }else{
            var tp2 = raw.value.split(",");
            for(i = 0;i< tp2.length;i++){
                _tp_.push({
                    value: tp2[i]
                });
            }
        }
        var store = Ext.create("Ext.data.Store",{
            model: 'PMS.apps.GoodsApp.model.SkuItemModel',
            data: _tp_
        });
        activePanel.queryById("skuSelectGrid").bindStore(store);
    },

    // 商品分类
    initCategoryCombo: function(callback){
        var me  = this;
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
                    emptyText: '选择商品分类',
                    fieldLabel: '商品分类'+ '<font color = red>*</font>',
                    labelAlign: 'right',
                    labelWidth:90,
                    name: 'catId',
                    margin: '0 0 10 0',
                    columnWidth:.25
                });

                // Hack 双击 出现两个分类
                var tree = me.getGoodsBaseForm().queryById("treeCombo");
                if(tree){
                    me.getGoodsBaseForm().queryById("baseInfo").remove(tree);
                }

                me.getGoodsBaseForm().queryById("baseInfo").add(treeCombo);
                if(callback){
                    callback();
                }
            }
        });
    },

    // 商品规格
    initSkuGrid: function(record){
        var me = this;
        var skuGrid = me.getGoodsSkusGrid();
        var list;
        if(record){
            list = record.get("productsList");
            if(!list.length){
                list = [{
                    'productsId': '',
                    'productsSn': record.raw["goodsSn"],
                    'sellPrice': record.raw["sellPrice"],
                    'marketPrice': record.raw["marketPrice"],
                    'costPrice': record.raw["costPrice"],
                    'storeNum': record.raw["storeNum"],
                    'weight': record.raw["weight"],
                    'specArray': []
                }]
            }
        }else{
            list = [{
                'productsId': '',
                'productsSn': 1,
                'sellPrice': '',
                'marketPrice': '',
                'costPrice': '',
                'storeNum': 100,
                'weight': '',
                'specArray': []
            }]
        }
        // 商品规格
        var skuStore = Ext.create("Ext.data.Store",{
            model: "PMS.apps.GoodsApp.model.GoodsSkuModel",
            data: list
        });
        skuGrid.bindStore(skuStore);
    },

    // 商品图片
    initImageGrid: function(record){
        var me = this,
            index = -1,
            li = [],
            imageGrid = me.getGoodsImageGrid();
        if(record){
            Ext.each(record.get('picList'), function(it, i){
                li.push({
                    pic: it.pic,
                    is_main: it.pic == record.get("pic")
                });
                if(it.pic == record.get("pic")){
                    index = i;
                }
            });
        }

        var imageStore = Ext.create("Ext.data.Store",{
            model: "PMS.apps.GoodsApp.model.GoodsImageModel",
            data: li
        });
        imageGrid.bindStore(imageStore);
        if(index >= 0){
            imageGrid.getSelectionModel().select(imageStore.getAt(index));
        }
    },

    requestUrl: {
        save: dev_base + 'data/goods/edit?act=save&_dt=' + Math.random(),
        textInfo: dev_base + 'data/goods/info?_dt=' + Math.random(),
        detail: dev_base + 'data/goods/info?_dt=' + Math.random(),
        skuDetail: dev_base + 'data/spec/info?_dt=' + Math.random(),
        listCategory: dev_base + 'data/category/list?_dt=' + Math.random(),
        saveContent: dev_base + 'data/goods/edit?act=saveContent&_dt=' + Math.random()
    }
//    initCategoryTree: function(callback){
//        var me = this;
//        Ext.AjaxUtil.getAction({
//            url: me.requestUrl.listCategory,
//            callback: function(result){
//                if(result.data){
//                    var st = Ext.create("Ext.data.TreeStore", {
//                        extend: 'Ext.data.TreeStore',
//                        model: 'PMS.apps.GoodsApp.model.CategoryModel',
//                        root: {
//                            expended: true,
//                            text:  '根目录',
//                            categoryId: 0,
//                            children:Ext.ToolUtil.createGoodsTreeModel(result.data)
//                        }
//                    });
//                    me.getGoodsCategoryTree().bindStore(st);
//                    me.getGoodsCategoryTree().expandAll();
//                }
//                if(callback){
//                    callback();
//                }
//            }
//        });
//    },
//
//    getTreeSelectIndex: function(categoryId){
//        var me = this, index = 0, re = 0;
//        var root = me.getGoodsCategoryTree().getStore().tree.root.childNodes;
//
//        getIndex(root);
//
//        return re;
//
//        function getIndex(root){
//            Ext.each(root, function(obj){
//                if(obj.raw.categoryId == categoryId){
//                    re = index;
//                }else{
//                    index ++;
//                    if(obj.childNodes && obj.childNodes.length){
//                        getIndex(obj.childNodes);
//                    }
//                }
//            });
//        }
//    }
});