/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.OrderApp.view.OrderGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.orderGrid',

    border:false,
    autoScroll: true,

    store: 'PMS.apps.OrderApp.store.OrderStore',

    initComponent:function () {
        var me = this;
        me.columns = [
            {
                header:"订单号",
                dataIndex:'sn',
                align:"center",
                flex:1
            },
            {
                header:"用户名",
                dataIndex:'user',
                align:"center",
                flex:1
            },
            {
                header:"订单金额",
                dataIndex:'amount',
                align:"center",
                flex:1
            },
            {
                header:"订单状态",
                dataIndex:'statusText',
                align:"center",
                flex:1
            },
            {
                header:"下单时间",
                dataIndex:'timeText',
                align:"center",
                flex:1
            },
            {
                menuDisabled: true,
                sortable: false,
                align:"center",
                hidden: true,
                xtype: 'actioncolumn',
                width: 50,
                items: [
                    {
                        iconCls: 'edit-col',
                        tooltip: '删除',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("actionHandler", 'edit', grid, record);
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
//                    {
//                        text: '添加订单',
//                        iconCls: 'add',
//                        itemId: 'addButton'
//                    },
                    {
                        text: '批量删除',
                        iconCls: 'remove',
                        itemId: 'removeButton',
                        handler: function(){
                            me.fireEvent("actionHandler", 'del');
                        }
                    },
                    {
                        text: '回收站',
                        iconCls: 'trash-icon',
                        itemId: 'recycleButton'
                    }
                ]
            },{
                xtype:"toolbar",
                border: false,
                itemId: 'filterToolbar',
                items: [
                    {
                        xtype: 'combo',
                        emptyText: '选择支付状态',
                        name: "period",
                        itemId: "periodCombo",
                        store: Ext.create("Ext.data.Store", {
                            fields: ['value', 'name'],
                            data: [
                                {value: "0", name: "已支付"},
                                {value: "1", name: "未支付"},
                                {value: "2", name: "退款成功"}
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
                        emptyText: '选择发货状态',
                        name: "state",
                        itemId: "stateCombo",
                        store: Ext.create("Ext.data.Store", {
                            fields: ['value', 'name'],
                            data: [
                                {value: 0, name: "未发货"},
                                {value: 2, name: "已发货"},
                                {value: 3, name: "部分发货"}
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
                        emptyText: '选择订单状态',
                        name: "storeNum",
                        itemId: "storeNumCombo",
                        store: Ext.create("Ext.data.Store", {
                            fields: ['value', 'name'],
                            data: [
                                {value: '0,0', name: "1"},
                                {value: '0,10', name: "2"},
                                {value: '10,100', name: "3"},
                                {value: '100,10000', name: "4"}
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
                        emptyText: '选择订单条件',
                        name: "condition",
                        itemId: "conditionCombo",
                        store: Ext.create("Ext.data.Store", {
                            fields: ['value', 'name'],
                            data: [
                                {value: '0,0', name: "收件人姓名"},
                                {value: '0,10', name: "订单号"},
                                {value: '10,100', name: "商户真实名称"}
                            ]
                        }),
                        valueField: "value",
                        value: "",
                        displayField: "name",
                        queryMode: 'local',
                        editable: true
                    },
                    {
                        xtype    : 'textfield',
                        name     : '关键字',
                        itemId   : 'keywordsText',
                        emptyText: ''
                    },
                    {
                        xtype: 'button',
                        iconCls: 'fa fa-search',
                        itemId: 'FilterButton',
                        text: '筛选'
                    }
                ]
            }]
        };
        me.callParent();
    }
});