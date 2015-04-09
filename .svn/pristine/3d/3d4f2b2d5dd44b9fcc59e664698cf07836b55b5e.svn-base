/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.HouseApp.view.HouseGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.houseGrid',

    border:false,
    autoScroll: true,

    store: 'PMS.apps.HouseApp.store.HouseStore',

    initComponent:function () {
        var me = this;
        me.columns = [
            {
                header:"户型图",
                dataIndex:'thumbUrl',
                align:"center",
                flex:1
            },
            {
                header:"户型名称",
                dataIndex:'name',
                align:"center",
                flex:3
            },
            {
                header:"城市",
                dataIndex:'position',
                align:"center",
                flex:2
            },
            {
                header:"楼盘",
                dataIndex:'building',
                align:"center",
                flex:2
            },
            {
                header:"可使用面积 (m²)",
                dataIndex:'usableArea',
                align:"center",
                flex:1
            },
            {
                header:"总面积 (m²)",
                dataIndex:'grossArea',
                align:"center",
                flex:1
            },
            {
                header:"设计方案数",
                dataIndex:'houseDesignNum',
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
            items:[
                {
                    xtype:"toolbar",
                    border: false,
                    itemId: 'filterToolbar',
                    items: [
                        {
                            xtype: "combo",
                            itemId: 'SearchCityCombo',
                            emptyText: '选择城市',
                            name: 'cityId',
                            valueField: 'id',
                            queryMode: 'local',
                            labelAlign: 'right',
                            displayField: 'name',
                            editable: true,
                            value:''
                        },
                        {
                            xtype: "combo",
                            itemId: 'SearchAreaCombo',
                            emptyText: '选择区域',
                            name: 'areaId',
                            valueField: 'id',
                            queryMode: 'local',
                            labelAlign: 'right',
                            displayField: 'name',
                            editable: true,
                            value:''
                        },
                        {
                            xtype: "combo",
                            itemId: 'SearchBuildingCombo',
                            emptyText: '选择楼盘',
                            name: 'buildingId',
                            valueField: 'id',
                            queryMode: 'local',
                            labelAlign: 'right',
                            displayField: 'name',
                            editable: true,
                            value:''
                        },
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