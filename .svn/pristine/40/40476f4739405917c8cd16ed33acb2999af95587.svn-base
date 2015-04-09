Ext.onReady(function() {
    Ext.Loader.setConfig({
        enabled : true,
        paths : {
            'PMS.application' : 'js/core',
            'PMS.BaseComp' : 'js/core/BaseComp',
            'Ext.ux' : 'js/core/BaseComp',
            'Ext.base' : 'js/global'
        }
});

// Grid CellEditting Plugin
Ext.require('Ext.selection.CellModel');

Ext.Loader.loadScript('js/global/config.js');

Ext.Loader.loadScript('lib/tips.js');
Ext.Loader.loadScript('lib/jquery/jquery-1.11.1.min.js');

//Ext.Loader.loadScript('js/util/utility.js');
Ext.Loader.loadScript('js/util/AjaxUtil.js');
Ext.Loader.loadScript('js/util/ImgAdjustUtil.js');
Ext.Loader.loadScript('js/util/FormValidateUtil.js');
Ext.Loader.loadScript('js/util/overrideUtil.js');
Ext.Loader.loadScript('js/util/ToolUtil.js');

Ext.application({
    name : 'PMS',
    appFolder : 'js/core',
    requires:[
        'PMS.BaseComp.BaseForm',
        'PMS.BaseComp.BaseGrid',
        'PMS.BaseComp.BasePanel',
        'PMS.BaseComp.BaseQueryForm'
    ],

    launch : function() {
        var me = this;

        coreApp = this;

        me.on("LoginSuccess", me.whoAmiHandler);

        // 户型管理 上传图片
        me.on("UploadHouse", function (event) {
            var uploadCtr = me.loadController('PMS.apps.UploadApp.controller.Upload');
            uploadCtr.targetCtr = event.targetCtr;
            uploadCtr.uploadUrl = event.uploadUrl;
            uploadCtr.doInitial();
        });
        // 商品管理 上传图片
        me.on("UploadGoods", function (event) {
            var uploadCtr = me.loadController('PMS.apps.UploadApp.controller.Upload');
            uploadCtr.targetCtr = event.targetCtr;
            uploadCtr.uploadUrl = event.uploadUrl;
            uploadCtr.doInitial();
        });
        // 上传图片
        me.on("UploadImage", function (event) {
            var uploadCtr = me.loadController('PMS.apps.UploadApp.controller.Upload');
            uploadCtr.targetCtr = event.targetCtr;
            uploadCtr.uploadUrl = event.uploadUrl;
            uploadCtr.doInitial();
        });

        me.whoAmiHandler();

    },

    controllers : [
        'PMS.coreApp.controller.MainController'
    ],

    loadController: function (name) {
        var me = this, ctr;
        if (me.controllers.containsKey(name)) {
            ctr = me.getController(name);
        } else {
            ctr = me.getController(name);
        }
        return ctr;
    },

    loadWorkPanel: function( xtype, title, ctr){
        var me = this;
        var mainCtr = me.loadController('PMS.coreApp.controller.MainController');
        mainCtr.loadWorkPanel(xtype, title, ctr);
    },

    whoAmiHandler: function () {
        var me = this;
        Ext.AjaxUtil.getActionAndReturn({
//            url: dev_base + "data/check/administrator",
            url: dev_base + "data/user/info",
            callback: function(re){
                if (re.errorCode == 22000 && re.data.id && Number(re.data.isSpecial)>=10) {
                    var appPanel = me.loadController('PMS.coreApp.controller.MainController');
                    appPanel.doInitial(re.data);
                    Ext.example.msg("", "欢迎使用印家后台管理系统!");
                }else {
                    me.loadController('PMS.apps.LoginApp.controller.LoginController');
                    var loginWin = Ext.getCmp("loginWin");
                    if(!loginWin){
                        Ext.widget("loginWin");
                    }else{
                        loginWin.show();
                    }
                }
            }
        });
    }
    });
});
