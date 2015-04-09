/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.UsersApp.view.UsersGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.usersGrid',

    border:false,
    autoScroll: true,
    store: 'PMS.apps.UsersApp.store.UsersStore',

    initComponent:function (){
        var me = this;
        me.columns = [
            {
                header:"用户名",
                dataIndex:'userName',
                align:"center",
                flex:1
            },
            {
                header:"电话",
                dataIndex:'tel',
                align:"center",
                flex:1
            },
            {
                header:"性别",
                dataIndex:'userSex',
                align:"center",
                flex:1,
                renderer: function (value) {
                    value = Number(value);
                    if(value == 0){
                        return '男';
                    }else if(value == 1){
                        return '女';
                    }else{
                        return '';
                    }
                }
            },
            {
                header:"生日",
                dataIndex:'birthday',
                align:"center",
                flex:1
            },
            {
                header:"注册时间",
                dataIndex:'createTime',
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
                header:"操作",
                align:"center",
                xtype: 'actioncolumn',
                width: 50,
                items: [
//                    {
//                        iconCls: 'edit-col',
//                        itemId: 'EditBtn',
//                        tooltip: '修改'
//                    },
                    {
                        iconCls: 'delete-col',
                        tooltip: '删除'
                    }
                ]
            }
        ];


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

Ext.define("PMS.apps.UsersApp.view.UsersWin",{
    extend: 'Ext.window.Window',
    alias: 'widget.usersWin',

    width: 300,

    title: '新增用户',
    modal: true,
    border: false,
    autoShow: true,

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: "form",
                defaults: {
                    border: false,
                    allowBlank: false,
                    blankText: "不能为空",
                    msgTarget: "side",
                    labelWidth: 80,
                    width: 250,
                    labelAlign: "right"
                },
                bodyPadding: 10,
                items: [
                    {
                        xtype: "textfield",
                        hidden: true,
                        allowBlank: true,
                        name: 'id'
                    },
                    {
                        xtype: "textfield",
                        fieldLabel: "用户名:",
                        disabled: true,
                        allowBlank: false,
                        validatorText: "不能为空",
                        name: "userName"
                    }  ,
                    {
                        xtype: "textfield",
                        fieldLabel: "电话:",
                        name: "tel",
                        vtype: 'positive',
                        allowBlank: true
                    }

                ]
            }
        ];
        me.buttons = [
            {
                text: '确认保存',
                formBind: true,
                itemId: 'SaveBtn',
                action: 'SaveAction'
            },
            {
                text: '返回',
                handler: this.close,
                scope: this
            }
        ];
        me.callParent();
    }
});