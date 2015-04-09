/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.UsersApp.view.AdminGrid", {
    extend: 'PMS.BaseComp.BaseGrid',
    alias: 'widget.adminGrid',

    border:false,
    autoScroll: true,
    store: 'PMS.apps.UsersApp.store.AdminStore',

    initComponent:function (){
        var me = this;
        me.columns = [
            {
                header:"用户名",
                dataIndex:'user',
                align:"center",
                flex:1
            },
            {
                header:"角色",
                dataIndex:'text',
                align:"center",
                flex:1
            },
            {
                header:"操作",
                align:"center",
                xtype: 'actioncolumn',
                width: 150,
                items: [
                    {
                        iconCls: 'edit-col',
                        action: 'up',
                        tooltip: '编辑',
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

Ext.define("PMS.apps.UsersApp.view.AdminWin",{
    extend: 'Ext.window.Window',
    alias: 'widget.adminWin',

    width: 300,

    title: '新增管理员',
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
                        allowBlank: false,
                        validatorText: "不能为空",
                        name: "user"
                    },
                    {
                        xtype: "textfield",
                        fieldLabel: "密码:",
                        name: "pwd",
                        allowBlank: true
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: '角色'+ '<font color = red>*</font>',
                        name: 'isSpecial',
                        store: Ext.create("Ext.data.Store", {
                            fields: ['value', 'name'],
                            data: [
                                {value: "10", name: "超级管理员"},
                                {value: "11", name: "设计方案管理员"},
                                {value: "12", name: "材料管理员"},
                                {value: "13", name: "文章管理员"}
                            ]
                        }),
                        valueField: "value",
                        displayField: "name",
                        queryMode: 'local',
                        editable: false,
                        allowBlank: false
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