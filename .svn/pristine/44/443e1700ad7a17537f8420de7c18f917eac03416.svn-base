/**
 * Created by zyc on 2015/1/17.
 */
Ext.define('PMS.apps.GoodsApp.SkuList', {
    extend:'PMS.BaseComp.BaseGrid',
    alias:'widget.skuList',

    width: '100%',
    height: '100%',

    layout:'fit',

    autoScroll: true,

    selType: 'checkboxmodel',
    selModel: {
        checkOnly: true,
        mode:'MULTI',
        injectCheckbox: 0
    },

    store: 'PMS.apps.GoodsApp.store.SkuStore',

    initComponent:function () {
        var me = this;

        me.tbar = [
            {
                xtype:'button',
                text: '添加规格',
                iconCls:'add',
                itemId: 'AddButton'
            },
            {
                xtype:'button',
                text:'批量删除',
                iconCls:'remove',
                itemId:'RemoveAllButton'
            },
            '->',
            {
                xtype:'label',
                text:'小提示：双击编辑',
                height:18
            }
        ];
        me.columns = [
            {
                header:"规格名称",
                dataIndex:'name',
                align:"center",
                flex:3
            },
            {
                header:"显示方式",
                dataIndex:'typeText',
                align:"center",
                flex:2
            },
            {
                header:"规格数据",
                dataIndex:'items',
                align:"center",
                flex:6
            },
            {
                header:"操作",
                align:"center",
                flex: 2,
                xtype: 'actioncolumn',
                items: [
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
        //  调用父类的构造函数
        me.callParent(arguments);
    }
});