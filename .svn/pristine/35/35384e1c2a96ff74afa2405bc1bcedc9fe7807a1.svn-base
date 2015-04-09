/**
 * Created by zyc on 2015/1/17.
 */
Ext.define('PMS.apps.GoodsApp.BrandList', {
    extend:'PMS.BaseComp.BaseGrid',
    alias:'widget.brandList',

    width: '100%',
    height: '100%',

    layout:'fit',

    autoScroll: true,

    store: 'PMS.apps.GoodsApp.store.BrandStore',

    initComponent:function () {
        var me = this;
        me.columns = [
            {
                header:"排序",
                dataIndex:'sort',
                align:"center",
                flex:2
            },
            {
                header:"品牌名称",
                dataIndex:'name',
                align:"center",
                flex:2
            },
            {
                header:"英文名称",
                dataIndex:'enName',
                align:"center",
                flex:2
            },
            {
                header:"品牌logo",
                dataIndex:'thumbUrl',
                align:"center",
                flex:2
            },
            {
                header:"网址",
                dataIndex:'url',
                align:"center",
                flex:4
            },
            {
                header:"品牌系列",
                dataIndex:'serialText',
                align:"center",
                flex:4
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
                        tooltip: '编辑'
                    },
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除'
                    }
                ]
            }
        ];

        me.tbar = [];

        me.callParent(arguments);
    }
});