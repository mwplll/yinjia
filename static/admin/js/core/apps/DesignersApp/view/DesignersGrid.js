/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.DesignersApp.view.DesignersGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.designersGrid',

    border:false,
    autoScroll: true,
    store: 'PMS.apps.DesignersApp.store.DesignersStore',

    initComponent:function (){
        var me = this;
        me.columns = [
            {
                header:"用户名",
                dataIndex:'userName',
                align:"center",
                flex:3
            },
            {
                header:"编号",
                dataIndex:'designerSn',
                align:"center",
                flex:3
            },
            {
                header:"电话",
                dataIndex:'tel',
                align:"center",
                flex:3
            },
            {
                header:"真实姓名",
                dataIndex:'realName',
                align:"center",
                flex:3
            },
            {
                header:"身份证号",
                dataIndex:'cid',
                align:'center',
                flex:3
            },
            {
                header:"审核状态",
                hidden: true,
                dataIndex:'state',
                align:"center",
                flex:3,
                renderer: function(value) {
                    var ret;
                    if(value == '4')
                        ret = '未提交审核';
                    if(value == '2')
                        ret = '待审核' ;
                    if(value == '1')
                        ret = '审核通过' ;
                    if(value == '0')
                        ret = '审核不通过' ;

                    return ret;
                }
            },
            {
                header:"审核失败原因",
                dataIndex:'reason',
                align:'center',
                flex:3
            },
            {
                header:"操作",
                align:"center",
                flex: 2,
                xtype: 'actioncolumn',
                items: [
//                    {
//                        iconCls: 'edit-col',
//                        tooltip: '修改'
//                    },
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除'
                    },
                    {
                        iconCls: 'revert',
                        tooltip: '审核'
                    }
                ]
            },
            {
                header:"操作",
                align:"center",
                hidden: true,
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

        me.tbar = [];

        me.bbar = Ext.create('Ext.PagingToolbar', {
            store:me.store,
            emptyMsg:'没有数据',
            displayInfo:true,
            displayMsg:'当前显示{0}-{1}条记录 / 共{2}条记录 ',
            beforePageText:'第',
            afterPageText:'页/共{0}页',
            nextText:'下一页',
            prevText:'上一页',
            lastText:'最后一页',
            firstText:'第一页',
            refreshText:'刷新'
        });
        me.callParent();
    }
});
