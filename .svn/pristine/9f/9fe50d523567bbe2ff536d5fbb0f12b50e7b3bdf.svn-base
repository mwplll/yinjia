Ext.define("PMS.apps.DesignersApp.view.DesignersWin",{
    extend: 'Ext.window.Window',
    alias: 'widget.designersWin',

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
                    },
                    {
                        xtype: "textfield",
                        fieldLabel: "电话:",
                        name: "tel",
                        vtype: 'positive',
                        allowBlank: true
                    },
                    {
                        xtype: "textfield",
                        fieldLabel: "真实姓名:",
                        allowBlank: false,
                        name: "realName"
                    },
                    {
                        xtype: "textfield",
                        fieldLabel: "身份证号:",
                        allowBlank: false,
                        vtype: 'positive',
                        name: "cid"
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