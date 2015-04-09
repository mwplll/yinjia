/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.TmplApp.view.TmplGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.tmplGrid',

    border:false,
    autoScroll: true,

    store: 'PMS.apps.TmplApp.store.TmplStore',

    initComponent:function () {
        var me = this;
        me.columns = [
            {
                menuDisabled: true,
                sortable: false,
                align:"center",
                hidden: true,
                xtype: 'actioncolumn',
                width: 50,
                items: [
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除',
                        handler: function(grid, rowIndex, colIndex, node, e, record, rowEl){
                            this.fireEvent("actionHandler", 'del', grid, record);
                        }
                    }
                ]
            }
        ];

        me.callParent();
    }
});