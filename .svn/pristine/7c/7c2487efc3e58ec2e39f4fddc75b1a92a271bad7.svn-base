/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.ArticleApp.view.ArticleGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.articleGrid',
    requires: [
        'Ext.ux.TreeCombo'
    ],
    border:false,
    autoScroll: true,
    layout: 'fit',
    store: 'PMS.apps.ArticleApp.store.ArticleStore',
    selType: 'checkboxmodel',
    selModel: {
        checkOnly: true,
        mode:'MULTI',
        injectCheckbox: 0
    },
    initComponent:function () {
        var me = this;
        me.columns = [
//            {
//                header:"文章主图",
//                dataIndex:'thumbUrl',
//                align:"center",
//                flex:1
//            },
            {
                header:"标题",
                dataIndex:'title',
                align:"center",
                flex:2
            },
            {
                header:"分类",
                dataIndex:'category',
                align:"center",
                flex:1
            },
            {
                header:"作者",
                dataIndex:'author',
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
        me.tbar = [];

        me.callParent();
    }
});