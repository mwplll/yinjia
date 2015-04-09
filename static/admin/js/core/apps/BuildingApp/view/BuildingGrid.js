Ext.define("PMS.apps.BuildingApp.view.BuildingGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.buildingGrid',

    border:false,
    autoScroll: true,

    store: 'PMS.apps.BuildingApp.store.BuildingStore',

    initComponent:function () {
        var me = this;
        me.tbar = [
            {
                text: '新增',
                iconCls: 'add',
                action: 'Add'
            },
            {
                xtype: 'tbfill'
            },
            {
                fieldLabel: "城市",
                xtype: "combo",
                itemId: 'SearchCityCombo',
                name: 'city_id',
                valueField: 'id',
                queryMode: 'local',
                labelAlign: 'right',
                displayField: 'name',
                editable: false,
                value:''
            },
            {
                fieldLabel: "区域",
                xtype: "combo",
                itemId: 'SearchAreaCombo',
                name: 'areaId',
                valueField: 'id',
                queryMode: 'local',
                labelAlign: 'right',
                displayField: 'name',
                editable: false,
                value:''
            }
        ];

        me.columns = [
            {
                header:"楼盘名称",
                dataIndex:'name',
                align:"center",
                flex:4
            },
            {
                header:"房产公司",
                dataIndex:'company',
                align:"center",
                flex:2
            },
            {
                header:"省份",
                dataIndex: 'prov',
                align:"center",
                flex:2
            },
            {
                header:"城市",
                dataIndex:'city',
                align:"center",
                flex:2
            },
            {
                header:"区域",
                dataIndex:'area',
                align:"center",
                flex:2
            },
            {
                header:"设计方案数量",
                dataIndex:'designNum',
                align:"center",
                flex:2
            },
            {
                header:"推荐楼盘",
                dataIndex:'recommend',
                align:"center",
                flex:2,
                renderer: function(value){
                    if(Number(value) == 1){
                        return '是';
                    }else{
                        return '';
                    }
                }
            },
            {
                menuDisabled: true,
                sortable: false,
                align:"center",
                xtype: 'actioncolumn',
                width: 100,
                items: [

                    {
                        iconCls: 'arrow-up',
                        tooltip: '推荐',
                        action: 'recommend',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("recommendHandler", grid, record, 'yes');
                        }
                    },
                    {
                        iconCls: 'arrow-down',
                        margin: '0 10 0 10',
                        tooltip: '取消推荐',
                        action: 'unrecommend',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("recommendHandler", grid, record, 'no');
                        }
                    },
                    {
                        iconCls: 'edit-col',
                        tooltip: '修改',
                        action: 'edit',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", grid, record);
                        }
                    },
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除',
                        action: 'delete',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("delHandler", grid, record);
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
                    border: true,
                    items: [
                        {
                            text: '新增',
                            iconCls: 'add',
                            action: 'Add'
                        }
                    ]
                },
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
    //                            fieldLabel: "区域",
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