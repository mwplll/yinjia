/**
 * Created by zyc on 2015/1/17.
 */
Ext.define('PMS.apps.GoodsApp.PropertyList', {
    extend:'PMS.BaseComp.BaseGrid',
    alias:'widget.propertyList',

    width: '100%',
    height: '100%',

    layout:'fit',

    autoScroll: true,

    selModel:Ext.create('Ext.selection.CheckboxModel', {
        injectCheckbox:'first',
        mode:'MULTI',
        checkOnly:'true'
    }),

    store: 'PMS.apps.GoodsApp.store.PropertyStore',

    initComponent:function () {
        var me = this;

        me.tbar = [
            {
                xtype:'button',
                text: '添加属性',
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
                header:"属性名称",
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
                header:"属性数据",
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