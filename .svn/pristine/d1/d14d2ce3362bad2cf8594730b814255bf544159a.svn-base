
Ext.define("PMS.apps.DesignApp.view.AuditWin",{
    extend: 'Ext.window.Window',
    alias: 'widget.auditWin',

    width: 400,

    title: '审核失败',
    modal: true,
    border: false,
    autoShow: true,

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: "form",
                width: '100%',
                defaults: {
                    border: false,
                    allowBlank: false,
                    blankText: "不能为空",
                    msgTarget: "side",
                    labelWidth: 100,
                    labelAlign: "right"
                },
                bodyPadding: 10,
                items: [
                    {
                        xtype: "textfield",
                        hidden: true,
                        allowBlank: false,
                        itemId: 'id',
                        name: 'id'
                    },  {
                        xtype: "textfield",
                        hidden: true,
                        allowBlank: true,
                        name: 'isCheck',
                        value: 0
                    },
                    {
                        xtype: "textarea",
                        fieldLabel: "审核失败原因",
                        allowBlank: false,
                        width: 350,
                        itemId: 'reason',
                        validatorText: "不能为空",
                        name: "reason"
                    }
                ]
            }
        ];
        me.buttons = [
            {
                text: '确认保存',
                formBind: true,
                itemId: 'SaveButton'
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