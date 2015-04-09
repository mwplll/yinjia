/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.DesignApp.view.DesignGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.designGrid',

    border:false,
    autoScroll: true,

    store: 'PMS.apps.DesignApp.store.DesignStore',

    initComponent:function () {
        var me = this;
        me.tbar = [];
        me.columns = [
            {
                header:"设计图",
                dataIndex:'thumbUrl',
                align:"center",
                flex:1
            },
            {
                header:"设计方案名称",
                dataIndex:'designLink',
                align:"center",
                flex:2
            },
            {
                header:"设计师",
                dataIndex:'userName',
                align:"center",
                flex:1
            },
            {
                header:"设计费(元)",
                dataIndex:'price',
                align:"center",
                flex:1
            },
            {
                header:"定金(元)",
                dataIndex:'deposit',
                align:"center",
                flex:1
            },
            {
                header:"装修预估价(元)",
                dataIndex:'totalPrice',
                align:"center",
                flex:1
            },
            {
                header:"是否首页推荐",
                dataIndex:'recommendText',
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
                header:"操作",
                align:"center",
                flex: 2,
                xtype: 'actioncolumn',
                items: [
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", 'del', grid, record);
                        }
                    },
                    {
                        iconCls: 'arrow-up',
                        margin: '0 10 0 10',
                        action: 'up',
                        tooltip: '推荐',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", 'up', grid, record);
                        },
                        isDisabled: function(view, rowIdx, colIdx, item, record) {
                            return Number(record.data.state) != 0;
                        }
                    },
                    {
                        iconCls: 'arrow-down',
                        tooltip: '不推荐',
                        action: 'down',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", 'down', grid, record);
                        },
                        isDisabled: function(view, rowIdx, colIdx, item, record) {
                            return Number(record.data.state) != 0;
                        }
                    },
                    {
                        iconCls: 'revert',
                        tooltip: '审核',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("editHandler", 'edit', grid, record);
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
                    '->',
                    {
                        xtype    : 'textfield',
                        name     : '关键字',
                        itemId   : 'keywordsText',
                        emptyText: '输入关键字'
                    },
                    {
                        xtype: 'button',
                        itemId: 'SearchButton',
                        iconCls: 'fa fa-search',
                        text: '搜索'
                    }
                ]
            }
            ]
        };
        me.callParent();
    }
});