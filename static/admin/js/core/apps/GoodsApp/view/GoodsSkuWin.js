Ext.define("PMS.apps.GoodsApp.view.GoodsSkuWin", {
    extend: 'Ext.window.Window',
    alias: 'widget.goodsSkuWin',

    width: 700,
    minHeight: 500,

    title: '设置商品规格',
    modal: true,
    border: false,
    autoShow: true,
    draggable: true,

    buttonAlign:'center',

    initComponent: function(){
        var me = this;
        me.items = [
            {
                layout: 'hbox',
                border: false,
                defaults:{
                    labelAlign:"right",
                    labelWidth:90,
                    margin: '10 0 10 10'
                },
                items: [
                    {
                        xtype: "combo",
                        fieldLabel: "请选择规格项",
                        name: "sku",
                        itemId: "skuCombo",
                        store: 'PMS.apps.GoodsApp.store.SkuStore',
                        valueField: "id",
                        displayField: "name",
                        queryMode: 'local',
                        editable: false
                    },
                    {
                        xtype: 'button',
                        float: 'right',
                        itemId: 'AddSelectButton',
                        text: '没有找到，新增规格项'
                    }
                ]
            },
            {
                xtype: 'tabpanel',
                itemId: 'tabPanel',
                border: false,
                layout: 'fit',
                defaults:{
                    closable: true,
                    border: false
                },
                items:[
//                    {
//                        xtype: 'skuSelectPanel',
//                        title: '111111',
//                        _id:    "",
//                        border: false
//                    }
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
    },

    getFormValues: function(){
        var me = this,
            tabPanel = me.queryById("tabPanel"),
            items = tabPanel.items.items;
        if(!items.length){
            return [];
        }
        var re = [];
        Ext.each(items, function(it){
            var grid = it.queryById("skuSelectGrid");
//            var store = grid.getStore();
            var selection = grid.getSelectionModel().getSelection();
            var tp = [];
            Ext.each(selection, function(record){
                var obj = {
                    id: it._id,
                    name: it.title,
                    type: Number(it.type)
                };
                if(obj['type'] == 1){
                    obj['value'] = record.get("serial");
                    obj['picName'] = record.get("value");
                }else{
                    obj['value'] = record.get("value");
                }
                tp.push(obj);
            });
            re.push(tp);
        });

        return Ext.ToolUtil.combineArray(re);
    }
});
Ext.define("PMS.apps.GoodsApp.view.SkuSelectPanel",{
    extend: 'Ext.panel.Panel',
    alias: 'widget.skuSelectPanel',

    title: '',
    items:[
        {
            xtype: 'grid',
            columnWidth: 1,
            itemId: 'skuSelectGrid',
            margin: "0 0 20 0",
            border: false,
            tbar: [
                {
                    xtype: 'button',
                    itemId: 'EditSelectButton',
                    text: '编辑规格'
                }
            ],
            selType: 'checkboxmodel',
            selModel: {
                checkOnly: true,
                mode:'MULTI',
                injectCheckbox: 0
            },
            columns: [
                {
                    header: '规格图片',
                    dataIndex: 'thumbUrl',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: '规格值',
                    dataIndex: 'value',
                    sortable: false,
                    align: "center",
                    flex: 1
                } ,
                {
                    menuDisabled: true,
                    sortable: false,
                    hidden: true,
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
            ]
        }
    ]

});