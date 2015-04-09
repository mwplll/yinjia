/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.GoodsApp.view.GoodsWin", {
    extend: 'Ext.panel.Panel',
    alias: 'widget.goodsWin',
    requires: [
        'Ext.ux.TreeCombo'
    ],
    border: false,
    layout: 'fit',
    buttonAlign:'center',
    autoScroll: true,

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'tabpanel',
                itemId: 'tabPanel',
                items: [
                    {
                        xtype: 'goodsBaseForm',
                        itemId: 'goodsBaseForm',
                        title: '基本信息',
                        autoScroll: true,
                        index: 0
                    },
                    {
                        xtype: 'goodsDetailForm',
                        itemId: 'goodsDetailForm',
                        autoScroll: true,
                        title: '描述信息',
                        index: 1
                    }
                ]
            }
        ];
        me.buttons =  [
            {
                text: '确认保存',
                itemId: 'SaveButton'
            },
            {
                text: '返回',
                hidden: true
            }
        ];
        me.callParent()
    }
});

Ext.define("PMS.apps.GoodsApp.view.GoodsBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.goodsBaseForm',
    padding: '10 5 20 5',
    defaults: {
        padding: '10 5'
    },
    items:[
        {
            xtype: 'fieldset',
            title: "商品名称",
            itemId: 'baseInfo',
            defaults:{
                labelAlign:"right",
                labelWidth:90,
                margin: '0 0 10 0',
                columnWidth:.25
            } ,
            border: true,
            collapsible: true,
            layout: 'column',
            items: [
                {
                    xtype: "textfield",
                    hidden: true,
                    name: 'id',
                    itemId: 'productId'
                },
                {
                    xtype: "textfield",
                    columnWidth:.9,
                    maxLength: 50,
                    allowBlank: false,
                    maxLengthText: '最多输入50个字',
                    fieldLabel: "商品名称" + '<font color = red>*</font>',
                    name: 'name',
                    itemId: 'name'
                },
                {
                    xtype: "textfield",
                    allowBlank: false,
                    fieldLabel: "型号"+ '<font color = red>*</font>',
                    name: 'goodsSn',
                    itemId: 'goodsSn'
                },
                {
                    xtype: "textfield",
                    fieldLabel: "计量单位"+ '<font color = red>*</font>',
                    name: 'unit',
                    itemId: 'unit',
                    allowBlank: false,
                    value: '件'
                },
                {
                    xtype: "combo",
                    fieldLabel: "状态" + '<font color = red>*</font>',
                    name: "state",
                    allowBlank: false,
                    itemId: "stateCombo",
                    store: Ext.create("Ext.data.Store", {
                        fields: ['value', 'name'],
                        data: [
                            {value: "0" , name: "上架"},
                            {value: "2", name: "下架"},
                            {value: "3", name: "待审"}
                        ]
                    }),
                    valueField: "value",
                    value: "0",
                    displayField: "name",
                    queryMode: 'local',
                    editable: false
                },
                {
                    xtype: "combo",
                    fieldLabel: "供应商" + '<font color = red>*</font>',
                    name: "provider",
                    allowBlank: false,
                    itemId: "providerCombo",
                    store: 'PMS.apps.GoodsApp.store.SupplyStore',
                    valueField: "id",
                    value: "",
                    displayField: "name",
                    queryMode: 'local',
                    editable: false
                },
                {
                    xtype: "combo",
                    fieldLabel: "品牌" + '<font color = red>*</font>',
                    name: "brand",
                    allowBlank: false,
                    itemId: "brandCombo",
                    store: 'PMS.apps.GoodsApp.store.BrandStore',
                    valueField: "id",
                    displayField: "name",
                    queryMode: 'local',
                    editable: false
                },
                {
                    xtype: "combo",
                    fieldLabel: "品牌系列",
                    name: "seriesId",
                    itemId: "seriesCombo",
                    valueField: "seriesId",
                    displayField: "seriesName",
                    queryMode: 'local',
                    editable: false
                },

                {
                    xtype: "combo",
                    fieldLabel: "装修阶段" + '<font color = red>*</font>',
                    name: "period",
                    allowBlank: false,
                    itemId: "periodCombo",
                    store: Ext.create("Ext.data.Store", {
                        fields: ['value', 'name'],
                        data: [
                            {value: "0", name: "水电阶段"},
                            {value: "1", name: "泥水阶段"},
                            {value: "2", name: "木工阶段"},
                            {value: "3", name: "漆作阶段"},
                            {value: "4", name: "成品安装阶段"},
                            {value: "5", name: "软装阶段"},
                            {value: "10", name: "其他"}
                        ]
                    }),
                    valueField: "value",
                    value: "",
                    displayField: "name",
                    queryMode: 'local',
                    editable: false
                },
                {
                    xtype: "numberfield",
                    fieldLabel: "排序",
                    name: 'sort',
                    itemId: 'sort',
                    minValue: 0,
                    vtype: 'positive'
                }
            ]
        },
//        {
//            xtype: 'fieldset',
//            title: '商品分类' + '<font color = red>*</font>',
//            defaults:{
//                labelAlign:"right",
//                labelWidth: 90
//            } ,
//            border: true,
//            collapsible: true,
//            layout: 'hbox',
//            items: [
//                {
//                    xtype: 'treepanel',
//                    border: false,
//                    itemId: 'goodsCategoryTree',
//                    width: 700,
//                    rootVisible: false
//                }
//            ]
//        },
        {
            xtype: 'fieldset',
            title: '扩展属性',
            hidden: true,
            defaults:{
                labelAlign:"right",
                labelWidth:90
            } ,
            border: true,
            itemId: "productAttrField",
            collapsible: true,
            items: [

            ]
        },
        {
            xtype: 'goodsSkus',
            title: '基本数据'+ '<font color = red>*</font>',
            margin: '10 0 0 0',
            collapsible: true,
            itemId: "goodsSkus"
        },
        {
            title: '产品相册' + '<font color = red>*</font>',
            border: true,
            margin: '10 0 0 0',
            labelAlign:"right",
            labelWidth:90,
            collapsible: true,
            xtype: 'goodsImageList',
            itemId: 'goodsImageList'
        }
    ],

    getFormValues: function(){
        var me = this;
        var values = me.getForm().getValues();

        var skuGrid = me.queryById("goodsSkus").queryById("goodsSkusGrid");
        var imageGrid = me.queryById("goodsImageList").queryById("goodsImageGrid");

        var skuStore = skuGrid.getStore();
        var imageStore = imageGrid.getStore();

        var sellPrice = [], marketPrice = [], costPrice = [],weight = [],
            storeNum = [], specArray = [], pic = [], productsId = [], productsSn = [];
        var storeNumTotal = 0;
        skuStore.each(function(rec){
            sellPrice.push(rec.get("sellPrice"));
            marketPrice.push(rec.get("marketPrice"));
            costPrice.push(rec.get("costPrice"));
            weight.push(Number(rec.get("weight")));
            storeNum.push(rec.get("storeNum"));
            specArray.push(JSON.stringify(rec.get("specArray")));
            productsId.push(null);
            productsSn.push(rec.get("productsSn"));
            storeNumTotal += Number(rec.get("storeNum"));
        });

        imageStore.each(function(rec){
            pic.push(rec.get("pic"));
            if(rec.get("is_main")){
                values['mainPic'] = rec.get("pic");
            }
        });

        // 设置默认图片
        if(!pic.length){
            pic.push(goods_default_image);
            values['mainPic'] = goods_default_image;
        }

        values['sellPrice'] = sellPrice;
        values['marketPrice'] = marketPrice;
        values['costPrice'] =costPrice;
        values['weight'] = weight;
        values['storeNum'] = storeNum;
        values['specArray'] = specArray;
        values['productsId'] = productsId;
        values['productsSn'] = productsSn;

        values['pic'] = pic;
        values['brandId'] = values['brand'];
        values['providerId'] = values['provider'];

        values['goodsSellPrice'] = sellPrice[0];
        values['goodsMarketPrice'] = marketPrice[0];
        values['goodCostPrice'] = costPrice[0];
        values['goodsWeight'] = weight[0];
        values['goodsStoreNum'] = storeNumTotal;
        values['goodsId'] = values['id'] || null;

        var tmp = me.validate(values);
        if(tmp.success){
            return values;
        }else{
            return tmp;
        }
    },

    validate: function(values){
        var error = '', success = true;
        Ext.each(values.costPrice, function(p){
            if(!p || p < 0 ){
                error = '请填写成本价格';
                success = false;
            }
        });
        Ext.each(values.marketPrice, function(p){
            if(!p || p < 0 ){
                error = '请填写市场价格';
                success = false;
            }
        });
        Ext.each(values.sellPrice, function(p){
            if(!p || p < 0 ){
                error = '请填写销售价格';
                success = false;
            }
        });
//        Ext.each(values.weight, function(p){
//            if(!p || p < 0 ){
//                error = '请填写重量';
//                success = false;
//            }
//        });
        Ext.each(values.storeNum, function(p){
            if(!p || p < 0 ){
                error = '请填写库存';
                success = false;
            }
        });

        if(!values.name){
            error = '请输入商品名称';
            success = false;
        }else if(!values.catId){
            error = '请选择商品分类';
            success = false;
        }else if(!values.goodsSn){
            error = '请填写商品型号';
            success = false;
        }else if(!values.sellPrice.length){
            error = '请增加商品基本数据';
            success = false;
        }else if(!values.pic.length){
            error = '请上传商品图片';
            success = false;
        }else if(!values.mainPic){
            error = '请选择商品主图';
            success = false;
        }else if(values.period === ''
            || values.period === undefined
            || values.period === null){
            error = '请选择装修阶段';
            success = false;
        }else if(!values.unit){
            error = '请填写计量单位';
            success = false;
        }else if(!values.goodsSn){
            error = '请填写型号';
            success = false;
        }else if(values.brandId === ''
            || values.brandId === undefined
            || values.brandId === null){
            error = '请选择商品品牌';
            success = false;
        }else if(values.providerId === ''
            || values.providerId === undefined
            || values.providerId === null){
            error = '请选择供应商';
            success = false;
        }
        return {
            success: success,
            error: error
        }
    }

});

// 商品规格
Ext.define("PMS.apps.GoodsApp.view.GoodsSkus",{
    extend: 'Ext.form.FieldSet',
    alias: 'widget.goodsSkus',
    items:[
        {
            xtype: 'grid',
            columnWidth: 1,
            itemId: 'goodsSkusGrid',
            margin: "0 0 20 0",
            border: false,
            viewConfig: {
                markDirty:false
            },
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 1,
                    pluginId: 'rowEditingPlugin'
                })
            ],
            selType: 'cellmodel',
            columns: [
                {
                    header: '商品货号',
                    dataIndex: 'productsSn',
                    sortable: false,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'textfield',
                        allowBlank: true
                    }
                } ,
                {
                    header: '商品规格',
                    dataIndex: 'specArrayText',
                    sortable: false,
                    align: "center",
                    flex: 2
                } ,
                {
                    header: "库存",
                    dataIndex: 'storeNum',
                    sortable: true,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'numberfield',
                        allowBlank: true,
                        minValue: 0,
                        vtype: 'positive'
                    }
                },
                {
                    header: "市场价格",
                    dataIndex: 'marketPrice',
                    sortable: true,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'numberfield',
                        allowBlank: true,
                        minValue: 0,
                        vtype: 'positive'
                    }
                },
                {
                    header: "销售价格",
                    dataIndex: 'sellPrice',
                    sortable: true,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'numberfield',
                        allowBlank: true,
                        minValue: 0,
                        vtype: 'positive'
                    }
                },
                {
                    header: "成本价格",
                    dataIndex: 'costPrice',
                    sortable: true,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'numberfield',
                        allowBlank: true,
                        minValue: 0,
                        vtype: 'positive'
                    }
                },
                {
                    header: "重量(千克)",
                    dataIndex: 'weight',
                    sortable: true,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'numberfield',
                        allowBlank: true,
                        minValue: 0,
                        vtype: 'positive'
                    }
                },
                {
                    menuDisabled: true,
                    sortable: false,
                    header: "操作",
                    align:"center",
                    xtype: 'actioncolumn',
                    width: 50,
                    items: [
                        {
                            iconCls: 'delete-col',
                            tooltip: '删除',
                            handler: function(grid, rowIndex, colIndex) {
                                grid.getStore().removeAt(rowIndex);
                                this.fireEvent("removeAction", grid);
                            }
                        }
                    ]
                }
            ],
            tbar: [
                {
                    xtype: "toolbar",
                    border: false,
                    items: [
                        {
                            xtype: "button",
                            text: "添加规格",
                            iconCls: "add",
                            itemId: "addSkuButton"
                        }
                    ]
                }
            ]
        }
    ],

    afterRender: function () {
        var me = this;
        me.callParent();
//        me.bindEvents();
    },

    bindEvents: function () {
        var me = this;
        var rowEditing;
        var grid = me.queryById("goodsSkusGrid");

        // 新增规格
        grid.queryById("addSkuButton").on("click", function () {
            rowEditing = grid.getPlugin('rowEditingPlugin');
            rowEditing.cancelEdit();

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

            grid.getStore().insert(0, r);
            rowEditing.startEdit(0, 0);
        });
    }
});

// 商品图片
Ext.define("PMS.apps.GoodsApp.view.GoodsImageList",{
    extend: 'Ext.form.FieldSet',
    alias: 'widget.goodsImageList',

    items:[
        {
            xtype: 'grid',
            columnWidth: 1,
            itemId: 'goodsImageGrid',
            border: false,
            maxWidth: 400,
            viewConfig: {
                markDirty:false
            },
            selType: 'checkboxmodel',
            selModel: {
                checkOnly: true,
                mode:'SINGLE',
                injectCheckbox: 1
            },
            columns: [
                {
                    header: '图片',
                    dataIndex: 'thumbUrl',
                    sortable: false,
                    align: "center",
                    flex: 1
                } ,
                {
                    header: "是否主图",
                    dataIndex: 'is_main',
                    sortable: true,
                    align: "center",
                    flex: 1,
                    renderer: function(va){
                        if(va){
                            return '<a style="color:red;">主图</a>';
                        }
                    }
                },
                {
                    sortable: false,
                    align:"center",
                    header: "操作",
                    xtype: 'actioncolumn',
                    width: 150,
                    items: [
                        {
                            iconCls: 'delete-col',
                            tooltip: '删除',
                            handler: function(grid, rowIndex, colIndex) {
                                grid.getStore().removeAt(rowIndex);
                            }
                        },
                        {
                            xtype: 'button',
                            text: '设为主图',
                            handler: function(grid, rowIndex, colIndex) {
                                grid.getStore().removeAt(rowIndex);
                            }
                        }
                    ]
                }
            ],
            tbar: [
                {
                    xtype: "toolbar",
                    border: false,
                    items: [
                        {
                            xtype: "button",
                            text: "新增",
                            iconCls: "add",
                            itemId: "addImageButton"
                        }
                    ]
                }
            ]
        }
    ],

    initComponent: function(){
        var me = this;

        me.callParent();
    },

    afterRender: function () {
        var me = this;

        me.callParent();
        me.bindEvents();
    },

    bindEvents: function () {
        var me = this;
        var grid = me.queryById("goodsImageGrid");

        // 新增
        grid.queryById("addImageButton").on("click", function () {
            coreApp.fireEvent("UploadGoods", {
                targetCtr: me,
                uploadUrl: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=goods"
            });
        });

        // 自定义事件 监听图片上传完成
        me.on({
            AfterImageUpload: function (data) {
                var  url = image_base + data.serial;
                // Create a model instance
                var r = Ext.create('PMS.apps.GoodsApp.model.GoodsImageModel', {
                    'thumbUrl': "<img src='"+ url + "' height='40px'>",
                    'pic': data.serial,
                    'is_main': false
                });

                grid.getStore().add(r);
            }
        });
    }
});

// 详情描述
Ext.define("PMS.apps.GoodsApp.view.GoodsDetail",{
    extend: 'Ext.form.Panel',
    alias: 'widget.goodsDetailForm',

    requires: [
        'PMS.BaseComp.Ueditor'
    ],

    items: [
        {
            xtype:'ueditor',
            id:'ux',
            name:'artcont',
            labelWidth: 50,
            width: '100%',
            height: 600,
            allowBlank: false
        }
    ],

    afterRender: function(){
        var me = this;
        me.callParent();

    }
});
