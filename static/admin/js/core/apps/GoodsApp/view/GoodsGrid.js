/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.GoodsApp.view.GoodsGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.goodsGrid',
    requires: [
        'Ext.ux.TreeCombo'
    ],
    border:false,
    autoScroll: true,
    layout: 'fit',
    store: 'PMS.apps.GoodsApp.store.GoodsStore',
    selType: 'checkboxmodel',
    selModel: {
        checkOnly: true,
        mode:'MULTI',
        injectCheckbox: 0
    },
    initComponent:function () {
        var me = this;
        me.columns = [
            {
                header:"商品主图",
                dataIndex:'thumbUrl',
                align:"center",
                flex:1
            },
            {
                header:"商品名称",
                dataIndex:'nameText',
                align:"center",
                flex:2
            },
            {
                header:"分类",
                dataIndex:'cat',
                align:"center",
                flex:1
            },
            {
                header:"销售价格(元)",
                dataIndex:'price',
                align:"center",
                flex:1
            },
            {
                header:"库存",
                dataIndex:'storeNum',
                align:"center",
                flex:1
            },
            {
                header:"所属装修阶段",
                dataIndex:'periodText',
                align:"center",
                flex:1
            },
            {
                header:"状态",
                dataIndex:'stateText',
                align:"center",
                flex:1
            },
            {
                header:"排序",
                dataIndex:'sort',
                align:"center",
                flex:1
            },
            {
                menuDisabled: true,
                sortable: false,
                align:"center",
                header: '操作',
                xtype: 'actioncolumn',
                width: 150,
                items: [
                    {
                        iconCls: 'edit-col',
                        action: 'up',
                        tooltip: '编辑',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", 'edit', grid, record);
                        }
                    },
                    {
                        iconCls: 'arrow-up',
                        margin: '0 10 0 10',
                        action: 'up',
                        tooltip: '上架',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", 'up', grid, record);
                        }
                    },
                    {
                        iconCls: 'arrow-down',
                        tooltip: '下架',
                        action: 'down',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", 'down', grid, record);
                        }
                    },
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除',
                        action: 'delete',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", 'del', grid, record);
                        }
                    }
                ]
            }
        ];
        me.tbar = {
            xtype:"container",
            border:false,
            items:[{
                xtype:"toolbar",
                border: true,
                items: [
                    {
                        text: '添加商品',
                        iconCls: 'add',
                        itemId: 'addButton'
                    },
                    {
                        text: '批量删除',
                        iconCls: 'remove',
                        itemId: 'removeButton',
                        handler: function(){
                            me.fireEvent("actionHandler", 'del');
                        }
                    },
                    {
                        text: '批量上架',
                        iconCls: 'fa fa-arrow-up',
                        itemId: 'upButton',
                        handler: function(){
                            me.fireEvent("actionHandler", 'up');
                        }
                    },
                    {
                        text: '批量下架',
                        iconCls: 'fa fa-arrow-down',
                        itemId: 'downButton',
                        handler: function(){
                            me.fireEvent("actionHandler", 'down');
                        }
                    },
                    {
                        text: '批量待审',
                        iconCls: 'fa fa-file-o',
                        itemId: 'auditButton',
                        handler: function(){
                            me.fireEvent("actionHandler", 'audit');
                        }
                    },
                    {
                        text: '回收站',
                        iconCls: 'trash-icon',
                        hidden: true,
                        itemId: 'recycleButton'
                    },
                    '->',
                    {
                        xtype: 'combo',
//                        emptyText: '按',
                        width: 100,
                        name: "brand",
                        itemId: "brandCombo",
                        store: Ext.create("Ext.data.Store",{
                            fields: ['value', 'name'],
                            data: [
                                {value: "0", name: "按商品名"},
                                {value: "1", name: "按品牌"}
                            ]
                        }),
                        valueField: "value",
                        value: "0",
                        displayField: "name",
                        queryMode: 'local',
                        editable: false
                    },
                    {
                        xtype    : 'textfield',
                        name     : '关键字',
                        itemId   : 'keywordsText',
                        emptyText: '输入检索内容'
                    },
                    {
                        xtype: 'button',
                        itemId: 'SearchButton',
                        iconCls: 'fa fa-search',
                        text: '搜索'
                    }
                ]
            },
                {
                xtype:"toolbar",
                border: false,
                itemId: 'filterToolbar',
                items: [
//                    {
//                        xtype: 'treecombo',
//                        emptyText: '选择商品分类',
//                        name: "cat",
//                        itemId: "catCombo",
//                        store: Ext.create('Ext.data.TreeStore', {
//                            root: {
//                                text: 'Root',
//                                id: '0',
//                                expanded: true,
//                                children: []
//                            }
//                        })
//                    },
                    {
                        xtype: 'combo',
                        emptyText: '所属装修阶段',
                        name: "period",
                        width: 150,
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
                        editable: true
                    },
                    {
                        xtype: 'combo',
                        emptyText: '选择上下架',
                        name: "state",
                        width: 120,
                        itemId: "stateCombo",
                        store: Ext.create("Ext.data.Store", {
                            fields: ['value', 'name'],
                            data: [
                                {value: 0, name: "上架"},
                                {value: 2, name: "下架"},
                                {value: 3, name: "待审"}
                            ]
                        }),
                        valueField: "value",
                        value: "",
                        displayField: "name",
                        queryMode: 'local',
                        editable: true
                    },
                    {
                        xtype: 'combo',
                        emptyText: '选择库存',
                        name: "storeNum",
                        width: 120,
                        itemId: "storeNumCombo",
                        store: Ext.create("Ext.data.Store", {
                            fields: ['value', 'name'],
                            data: [
                                {value: '0,0', name: "无货"},
                                {value: '0,10', name: "低于10"},
                                {value: '10,100', name: "10-100"},
                                {value: '100,10000', name: "100以上"}
                            ]
                        }),
                        valueField: "value",
                        value: "",
                        displayField: "name",
                        queryMode: 'local',
                        editable: true
                    },
//                    {
//                        xtype: 'combo',
//                        emptyText: '选择品牌',
//                        name: "brand",
//                        itemId: "brandCombo",
//                        store: 'PMS.apps.GoodsApp.store.BrandStore',
//                        valueField: "value",
//                        value: "",
//                        displayField: "name",
//                        queryMode: 'local',
//                        editable: true
//                    },
                    {
                        xtype: 'button',
                        iconCls: 'fa fa-search',
                        itemId: 'FilterButton',
                        text: '筛选'
                    }
                ]
            }
            ]
        };

        me.callParent();
    }
});