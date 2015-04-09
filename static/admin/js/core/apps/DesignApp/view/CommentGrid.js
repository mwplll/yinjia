/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.DesignApp.view.CommentGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.commentGrid',

    border:false,
    autoScroll: true,

    store: 'PMS.apps.DesignApp.store.CommentStore',

    initComponent:function () {
        var me = this;
        me.tbar = [];
        me.columns = [
//            {
//                header:"设计图",
//                dataIndex:'thumbUrl',
//                align:"center",
//                flex:1
//            },
            {
                header:"设计方案名称",
                dataIndex:'designLink',
                align:"center",
                flex:1
            },
            {
                header:"评分",
                dataIndex:'point',
                align:"center",
                flex:1
            },
            {
                header:"评论内容",
                dataIndex:'content',
                align:"center",
                flex:2,
                renderer: function (value) {
                    return "<p style='width: 100%;border:0;background:none; word-wrap: break-word;white-space:pre-wrap;'>" + value + "</p>";
                }
            },
            {
                header:"评论时间",
                dataIndex:'time',
                align:"center",
                flex:2,
                renderer: function (value) {
                    if (value) {
                        return Ext.util.Format.date(new Date(value * 1000), "Y-m-d H:i:s");
                    }
                    return "无";
                }

            },
            {
                header:"评论人",
                dataIndex:'userName',
                align:"center",
                flex:1
            },
            {
                header:"操作",
                align:"center",
                width: 50,
                xtype: 'actioncolumn',
                items: [
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除',
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