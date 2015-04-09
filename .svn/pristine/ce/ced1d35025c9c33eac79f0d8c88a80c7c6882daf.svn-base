Ext.define("PMS.apps.DesignersApp.view.DesignersCheckWin",{
    extend: 'Ext.window.Window',
    alias: 'widget.designersCheckWin',

    width: 540,
    height:450,

    title: '新增用户',
    modal: true,
    border: false,
    autoShow: true,
    layout: 'fit',

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: "form",
                border: false,
                layout: {
                    type: 'hbox',
                    align: 'stretch'
                },
                items: [
                    {
                        xtype: 'fieldset',
                        width: 300,
                        title: '用户信息',

                        //layout: 'fit',
                        defaults: {
                            labelAlign:'left',
                            ancher: '100%',
                            labelWidth: 100
                        },
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
                                disabled: true,
                                name: "tel",
                                vtype: 'positive',
                                allowBlank: true
                            },
                            {
                                xtype: "textfield",
                                fieldLabel: "真实姓名:",
                                allowBlank: false,
                                disabled: true,
                                name: "realName"
                            },
                            {
                                xtype: "textfield",
                                fieldLabel: "身份证号:",
                                disabled: true,
                                allowBlank: false,
                                vtype: 'positive',
                                name: "cid"
                            },
                            {
                                xtype: "textareafield",
                                fieldLabel: "审核不通过原因",
                                labelAlign:'top',
                                width: 255,
                                height: 220,
                                vtype: 'positive',
                                name: "reason"                      
                            }
                        ]
                    },
                    {
                        padding: '10 0 10 0',
                        margin: '0 0 0 5',
                        border: false,
                        layout: 'vbox',
                        items: [
                            {
                                xtype: 'fieldset',
                                title: '身份证正面',
                                width: 220,
                                items: [
                                    {
                                        xtype: 'image',
                                        itemId: 'frontPic',
                                        height: 150,
                                        width: 200,
                                        src: ''
                                    }
                                ]
                            },
                            {
                                xtype: 'fieldset',
                                title: '身份证背面',
                                width: 220,
                                items: [
                                    {
                                        xtype: 'image',
                                        itemId: 'backPic',
                                        height: 150,
                                        width: 200,
                                        src: ''
                                    }
                                ]
                            }
                        ]
                    }
                ]
            }
        ];
        me.buttons = [
            {
                text: '通过',
                formBind: true,
                itemId: 'pass',
                action: 'SaveAction'
            },
            {
                text: '不通过',
                formBind: true,
                itemId: 'fail',
                action: 'SaveAction'
            },
            {
                text: '取消',
                handler: this.close,
                scope: this
            }

        ];
        me.callParent();
    }
});