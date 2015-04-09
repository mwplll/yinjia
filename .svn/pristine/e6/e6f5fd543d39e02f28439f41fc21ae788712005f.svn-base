/**
 * Created by zyc on 2015/1/17.
 */
Ext.define('PMS.apps.GoodsApp.SkuImageList', {
    extend:'PMS.BaseComp.BaseGrid',
    alias:'widget.skuImageList',

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

    store: 'PMS.apps.GoodsApp.store.SkuImageStore',

    initComponent:function () {
        var me = this;
        me.tbar = [
            {
                xtype:'button',
                text:'批量删除',
                iconCls:'remove',
                itemId:'RemoveAllButton'
            }
        ];
        me.columns = [
            {
                header:"规格图片名称",
                dataIndex:'name',
                align:"center",
                flex:2
            },
            {
                header: "图片",
                dataIndex: 'thumbUrl',
                align: "center",
                flex:3
            },
            {
                header:"创建时间",
                dataIndex:'time',
                align:"center",
                flex:2,
                renderer: function(value){
                    if(typeof value == 'string'){
                        return value;
                    }else if(typeof value == 'number'){
                        value = value * 1000;
                        return Ext.util.Format.date(new Date(value), "Y-m-d H:i:s");
                    }
                }
            },
            {
                header:"操作",
                align:"center",
                flex: 2,
                xtype: 'actioncolumn',
                items: [
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