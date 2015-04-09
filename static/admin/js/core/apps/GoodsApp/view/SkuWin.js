Ext.define("PMS.apps.GoodsApp.view.SkuWin", {
    extend: 'Ext.window.Window',
    alias: 'widget.skuWin',

    width:600,
    minHeight: 500,

    title: '新增规格',
    modal: true,
    border: false,
    autoShow: true,
    draggable: true,

    buttonAlign:'center',

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'panel',
                border: false,
                items:[
                    {
                        xtype: 'skuBaseForm',
                        border: false,
                        itemId: 'skuBaseForm'
                    }
                ]
            }
        ];
        me.buttons =  [
            {
                text: '确认保存',
                itemId: 'SaveButton',
                action: 'SaveAction'
            },
            {
                text: '返回',
                handler: this.close,
                scope: this
            }
        ];
        me.callParent()
    }
});
Ext.define("PMS.apps.GoodsApp.view.SkuBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.skuBaseForm',
    defaults: {
        labelWidth: 100,
        labelAlign: 'right',
        padding:"5 0 5 0",
        blankText:"不能为空",
        border: false
    },
    items:[
        {
            xtype: "numberfield",
            hidden: true,
            allowBlank: true,
            name: 'id'
        },
        {
            xtype: "textfield",
            fieldLabel: "规格名称:",
            allowBlank: false,
            name: 'name'
        },
        {
            xtype: 'combo',
            fieldLabel: '显示类型',
            itemId: "typeCombo",
            name: 'type',
            store: Ext.create("Ext.data.Store", {
                fields: ['value', 'name'],
                data: [
                    {value: "0", name: "文字"},
                    {value: "1", name: "图片"}
                ]
            }),
            valueField: "value",
            displayField: "name",
            queryMode: 'local',
            editable: false,
            value: "0"
        },
        {
            xtype: 'skuItem',
            margin: '0 0 0 100',
            itemId: 'skuItem'
        }
    ],

    afterRender: function () {
        var me = this;

        me.callParent();
        me.bindEvents();
    },

    bindEvents: function () {
        var me = this;
        var combo = me.queryById("typeCombo"),
            skuItem =  me.queryById("skuItem"),
            gridText = skuItem.queryById("skuItemTextGrid"),
            gridImage = skuItem.queryById("skuItemImageGrid");

        combo.on("change", function () {
            var v = Number(combo.getValue());
            if(v == 1){
                gridText.hide();
                gridImage.show();
//                grid.columns[0].show();
            }else{
                gridText.show();
                gridImage.hide();
//                grid.columns[0].hide();
            }
        });
        var rowEditing;
        gridText.queryById("addSkuItemButton").on("click", function () {
            rowEditing = gridText.getPlugin('rowEditingPlugin');
            rowEditing.cancelEdit();

            // Create a model instance
            var r = Ext.create('PMS.apps.GoodsApp.model.SkuItemModel', {
                'value': '',
                'serial': '',
                'thumbUrl': ''
            });

            gridText.getStore().add(r);

            rowEditing.startEdit(gridText.getStore().getCount() - 1, 0);
        });
        gridImage.queryById("addSkuItemButton").on("click", function () {
            rowEditing = gridImage.getPlugin('rowEditingPlugin');
            rowEditing.cancelEdit();

            // Create a model instance
            var r = Ext.create('PMS.apps.GoodsApp.model.SkuItemModel', {
                'value': '',
                'serial': '',
                'thumbUrl': ''
            });

            gridImage.getStore().add(r);

            rowEditing.startEdit(gridImage.getStore().getCount() - 1, 1);
        });
    },

    getFormValues: function(){
        var me = this,
            gridImage = me.queryById("skuItem").queryById("skuItemImageGrid"),
            gridText = me.queryById("skuItem").queryById("skuItemTextGrid"),
            store,
            values = me.getForm().getValues();
        var pd = {
            name: values.name,
            id: values.id || null,
            type: Number(values.type)
        };
        if(pd.type == 1){
            // 图片类型
            var pic = [], picName = [], picId = [], fg = false;
            store = gridImage.getStore();
            store.each(function(re){
                if(re.get('serial')){
                    pic.push(re.get("serial"));
                    picName.push(re.get("value"));
                    picId.push((re.get("id") || ''));
                }else{
                    fg = true;
                }
            });
            if(fg || !pic.length){
                return {
                    error: '请上传规格图片',
                    success: false
                }
            }
            pd['picId'] = picId;
            pd['pic'] = pic;
            pd['value'] = pic.toString();
            pd['picName'] = picName;
        }else{
            var tp = [];
            store = gridText.getStore();
            store.each(function(re){
                if(re.get('value')){
                    tp.push(re.get("value"));
                }
            });

            if(!tp.length){
                return {
                    error: '请填写规格值',
                    success: false
                }
            }
            pd['value'] = tp.toString();
        }
        console.log("sku data:");
        console.log(pd);
        return pd;
    },

    setFormValues: function(record){
        var me = this,
            gridText = me.queryById("skuItem").queryById("skuItemTextGrid"),
            gridImage = me.queryById("skuItem").queryById("skuItemImageGrid");
        gridText.bindStore(Ext.create("Ext.data.Store", {
            model: 'PMS.apps.GoodsApp.model.SkuItemModel',
            data: []
        }));
        gridImage.bindStore(Ext.create("Ext.data.Store", {
            model: 'PMS.apps.GoodsApp.model.SkuItemModel',
            data: []
        }));
        if(!record){
            gridImage.hide();
            gridText.show();
            return;
        }
        me.getForm().loadRecord(record);
        var tp = [], i = 0;
        if(Number(record.get('type')) == 1){
            var picList = record.get("picList");
            for(i = 0;i<picList.length;i++){
                tp.push({
                    value: picList[i].picName,
                    serial: picList[i].pic,
                    id: picList[i].picId
                })
            }
            gridText.hide();
            gridImage.show();

            var st = Ext.create("Ext.data.Store", {
                model: 'PMS.apps.GoodsApp.model.SkuItemModel',
                data: tp
            });
            gridImage.bindStore(st);
        }else{
            gridText.show();
            gridImage.hide();
            var tp2 = record.get("value").split(",");
            for(i = 0;i< tp2.length;i++){
                tp.push({
                    value: tp2[i]
                })
            }
            var st = Ext.create("Ext.data.Store", {
                model: 'PMS.apps.GoodsApp.model.SkuItemModel',
                data: tp
            });
            gridText.bindStore(st);
        }
    }

});

Ext.define("PMS.apps.GoodsApp.view.SkuItem",{
    extend: 'Ext.form.FieldSet',
    alias: 'widget.skuItem',

    items:[
        {
            xtype: 'grid',
            columnWidth: 1,
            itemId: 'skuItemTextGrid',
            margin: "0 0 20 0",
            maxWidth: 450,
            maxHeight: 330,
            autoScroll: true,
            border: false,
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 1,
                    pluginId: 'rowEditingPlugin'
                })
            ],
            selType: 'cellmodel',
            columns: [
                {
                    header: '规格值',
                    dataIndex: 'value',
                    sortable: false,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'textfield',
                        allowBlank: true
                    }
                } ,
                {
                    menuDisabled: true,
                    sortable: false,
                    align:"center",
                    header: '操作',
                    xtype: 'actioncolumn',
                    width: 150,
                    items: [
                        {
                            iconCls: 'delete-col',
                            tooltip: '删除',
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
                            itemId: "addSkuItemButton"
                        }
                    ]
                }
            ]
        },
        {
            xtype: 'grid',
            columnWidth: 1,
            itemId: 'skuItemImageGrid',
            margin: "0 0 20 0",
            maxWidth: 450,
            maxHeight: 330,
            autoScroll: true,
            border: false,
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 1,
                    pluginId: 'rowEditingPlugin'
                })
            ],
            selType: 'cellmodel',
            columns: [
                {
                    header: '规格图片',
                    dataIndex: 'thumbUrl',
                    sortable: false,
//                    hidden: true,
                    align: "center",
                    xtype: 'actioncolumn',
                    flex: 1,
                    renderer: function(v){
                        var btn = "<br/><button class='selectImageButton'>选择图片</button>";
                        return v + btn;
                    }
                },
                {
                    header: '规格值',
                    dataIndex: 'value',
                    sortable: false,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'textfield',
                        allowBlank: true
                    }
                } ,
                {
                    menuDisabled: true,
                    sortable: false,
                    align:"center",
                    header: '操作',
                    xtype: 'actioncolumn',
                    width: 150,
                    items: [
                        {
                            iconCls: 'delete-col',
                            tooltip: '删除',
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
                            itemId: "addSkuItemButton"
                        }
                    ]
                }
            ]
        }
    ]
});