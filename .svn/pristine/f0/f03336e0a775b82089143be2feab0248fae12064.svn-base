Ext.define("PMS.apps.GoodsApp.view.BrandWin", {
    extend: 'Ext.panel.Panel',
    alias: 'widget.brandWin',
    border: false,
    buttonAlign:'center',
    autoScroll: true,
    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'brandBaseForm',
                border: false,
                autoScroll: true,
                itemId: 'BrandBaseForm'
            }
        ];
        me.buttons =  [
            {
                text: '确认保存',
                itemId: 'SaveButton'
            },
            {
                text: '返回',
                itemId: 'ReturnButton'
            }
        ];
        me.callParent()
    }

});
Ext.define("PMS.apps.GoodsApp.view.BrandBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.brandBaseForm',
    defaults: {
        labelWidth: 100,
        labelAlign: 'right',
        padding:"5 0 5 0",
        blankText:"不能为空"
    },
    padding:"10 10 10 20",

    items:[
        {
            xtype: 'fieldset',
            collapsible: true,
            title: '品牌信息',
            defaults:{
                labelWidth: 100,
                border: false,
                margin: "0 0 10 0",
                columnWidth:.25,
                allowBlank: false,
                labelAlign: 'right'
            },
            layout: 'column',
            items: [
                {
                    xtype: "textfield",
                    hidden: true,
                    allowBlank: true,
                    name: 'id'
                },
                {
                    xtype: "textfield",
                    fieldLabel: "品牌名称" + '<font color = red>*</font>',
                    allowBlank: false,
                    name: 'name'
                },
                {
                    xtype: "textfield",
                    fieldLabel: "英文名称" + '<font color = red>*</font>',
                    allowBlank: false,
                    name: 'enName'
                },
                {
                    xtype: "numberfield",
                    fieldLabel: "排序",
                    vtype: 'positive',
                    allowBlank: true,
                    name: 'sort'
                },
                {
                    xtype: "textfield",
                    fieldLabel: "官网地址",
                    allowBlank: true,
                    name: 'url'
                }
            ]
        },
        {
            xtype: 'brandSerials',
            itemId: 'brandSerials',
            collapsible: true,
            title: '品牌系列'
        },
        {
            xtype: 'fieldset',
            collapsible: true,
            title: '品牌logo',
            defaults:{
                labelWidth: 100,
                border: false,
                margin: "0 0 10 0",
                allowBlank: true,
                labelAlign: 'right'
            },
            layout: 'column',
            items:[
                {
                    width: 200,
                    height: 200,
                    border: true,
                    itemId: 'imageBoxWrap',
                    margin: "0 0 10 45",
                    items: [
                        {
                            xtype: 'image',
                            itemId: 'imageBox',
                            border: true,
                            width: 200,
                            height: 200,
                            region: 'center'
                        }
                    ]
                },
                {
                    xtype: 'button',
                    itemId: 'uploadBrandButton',
                    width: 40,
                    margin: '0 0 0 20',
                    text: '上传'
                },
                {
                    xtype: 'textfield',
                    name: 'logo',
                    itemId: "picTextField",
                    hidden: true
                }
            ]
        },
        {
            xtype: 'fieldset',
            collapsible: true,
            title: '品牌描述',
            defaults:{
                labelWidth: 100,
                border: false,
                margin: "0 0 10 0",
                allowBlank: false,
                labelAlign: 'right'
            },
            items: [
                {
                    xtype: "textarea",
                    fieldLabel: "品牌描述",
                    width: 800,
                    height: 200,
                    allowBlank: true,
                    name: 'content'
                }
            ]
        }
    ],

    getFormValues: function(){
        var me = this;
        var values = me.getForm().getValues(),
            roomsGrid = me.queryById('brandSerials').queryById('brandSerialsGrid'),
            store = roomsGrid.getStore();
        var seriesId = [], series = [];
        store.each(function (record) {
            if(record.get("seriesName")){
                series.push(record.get("seriesName"));
                seriesId.push((record.get("seriesId") || null));
            }
        });
        values['seriesId'] = seriesId;
        values['seriesName'] = series;

        return values;
    }

});

Ext.define("PMS.apps.GoodsApp.view.BrandSerials",{
    extend: 'Ext.form.FieldSet',
    alias: 'widget.brandSerials',

    items:[
        {
            xtype: 'grid',
            columnWidth: 1,
            itemId: 'brandSerialsGrid',
            margin: "0 0 20 20",
            maxWidth: 300,
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
                    header: '系列名称',
                    dataIndex: 'seriesName',
                    sortable: false,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'textfield',
                        allowBlank: true
                    }
                } ,
                {
                    header: '操作',
                    menuDisabled: true,
                    sortable: false,
                    align:"center",
                    xtype: 'actioncolumn',
                    width: 50,
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
                            itemId: "addSerialButton"
                        }
                    ]
                }
            ]
        }
    ],

    afterRender: function () {
        var me = this;

        me.callParent();
        me.bindEvents();
    },

    bindEvents: function () {
        var me = this;
        var rowEditing;
        var grid = me.queryById("brandSerialsGrid");

        // 新增
        grid.queryById("addSerialButton").on("click", function () {
            rowEditing = grid.getPlugin('rowEditingPlugin');
            rowEditing.cancelEdit();

            // Create a model instance
            var r = Ext.create('PMS.apps.GoodsApp.model.BrandSerialModel', {
                name: ''
            });

            grid.getStore().insert(0, r);
            rowEditing.startEdit(0, 0);
        });
    }
});