/**
 * Created by zyc on 2015/1/17.
 */
Ext.define('PMS.apps.GoodsApp.SupplyList', {
    extend:'PMS.BaseComp.BaseGrid',
    alias:'widget.supplyList',

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

    store: 'PMS.apps.GoodsApp.store.SupplyStore',

    initComponent:function () {
        var me = this;

        me.tbar = [
            {
                xtype:'button',
                text: '添加供应商',
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
                header:"供应商名称",
                dataIndex:'name',
                align:"center",
                flex:3
            },
            {
                header:"操作",
                align:"center",
                flex: 2,
                xtype: 'actioncolumn',
                items: [
                    {
                        iconCls: 'edit-col',
                        tooltip: '修改'
                    },
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除'
                    }
                ]
            }
        ];
        //  调用父类的构造函数
        me.callParent(arguments);
    }
});