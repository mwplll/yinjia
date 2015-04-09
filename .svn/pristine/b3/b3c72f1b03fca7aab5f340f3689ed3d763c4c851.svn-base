/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 12-11-19
 * Time: 上午9:54
 * To change this template use File | Settings | File Templates.
 */

Ext.define('PMS.apps.LoginApp.controller.LoginController',{
    extend: 'Ext.app.Controller',
    refs:[
        {
            selector: 'loginWin',
            ref: 'loginWindow'
        },
        {
            selector: 'loginWin > form',
            ref: 'loginForm'
        }
    ],
    views: ['PMS.apps.LoginApp.view.LoginWindow'],

    init:function(){
        console.log("LoginController init......");
        this.control({
            'loginWin button[itemId=loginBtn]': {
                click: this.onLogin
            },
            'loginWin textfield[name=pwd]':{
                specialkey: this.entertosubmit
            }
        });
    },

    doInitial: function(){
        var me = this;
        Ext.widget("loginWin");
    },

    // 登录系统
    onLogin: function () {
        var me = this, loginForm = me.getLoginForm();
        var values = loginForm.getValues();
        Ext.AjaxUtil.saveAction({
            url: dev_base + "data/administrator/login",
            data: values,
            crossDomain: Global_CrossDomain,
            callback: function(re){
                if(re.errorCode == 22000 && re.data){
                    me.getLoginWindow().close();
                    me.application.fireEvent("LoginSuccess");
                    loginForm.getForm().reset();
                }else {
                    Ext.example.msg("提示","登录失败！请验证输入信息是否正确");
                    loginForm.getForm().reset();
                }
            }
        });
    },

    /**
     * 添加键盘事件 按enter登录
     * @param field
     * @param e
     */
    entertosubmit: function(field, e){
        var me = this;
        if (e.getKey() == Ext.EventObject.ENTER) {
            me.onLogin();
        }
    }
});