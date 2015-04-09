/**
 * Created with JetBrains WebStorm.
 * User: zyc
 * Date: 12-11-12
 * Time: 下午9:24
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.LoginApp.view.LoginWindow",{
    extend: 'Ext.window.Window',
    alias: 'widget.loginWin',

    title: '印家后台管理系统',
    modal: true,
    width: 400,
    height: 250,
    border: false,
    autoShow: true,
    closeAction:'hide',
    closable: false,
    hidden: true,
    id: "loginWin",
    buttonAlign: 'center',

    initComponent: function () {
        var me = this;

        me.buttons = [
            { text: '登录',  action: 'login', itemId: 'loginBtn' }
        ];
        me.items = [{
            border: false,
            xtype: 'form',
            margin: '40 0 0 0',
            defaults: {
                width: 300
            },
            items:[
                {
                    xtype: 'textfield',
                    fieldLabel: '帐号 '+ '<font color=red> * </font>',
                    name: 'user',
                    margin: '5 0 25 0',
                    labelAlign: 'right',
                    allowBlank: false,
                    blankText: '用户名不能为空',
                    style: 'font-size:14px;font-weight:bold;'
                },{
                    xtype: 'textfield',
                    fieldLabel: '密码 '+ '<font color=red> * </font>',
                    margin: '5 0 5 0',
                    labelAlign: 'right',
                    name: 'pwd',
                    allowBlank: false,
                    blankText: '密码不能为空',
                    inputType:'password',
                    style: 'font-size:14px;font-weight:bold;'
                }
            ]
        }];

        me.callParent();
    }
});