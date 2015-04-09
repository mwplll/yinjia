/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午5:04
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.coreApp.controller.MainController", {
    extend: 'Ext.app.Controller',

    stores: ['PMS.coreApp.store.MenuList'],

    views: ['PMS.coreApp.view.AppPanel'],

    refs: [
        {
            selector: 'appPanel',
            ref: 'appPanel'
        },
        {
            selector: 'appPanel westPanel',
            ref: 'menuPanel'
        },
        {
            selector: 'appPanel centerPanel',
            ref: 'centerPanel'
        },
        {
            selector: 'appPanel northPanel',
            ref: 'northPanel'
        },
        {
            selector: 'appPanel northPanel [itemId=UserManage]',
            ref: 'northPanelOfUser'
        },
        {
            selector: 'appPanel northPanel [itemId=UserDesignManage]',
            ref: 'northPanelOfUserDesign'
        },
        {
            selector: 'appPanel northPanel [itemId=UserName]',
            ref: 'northPanelOfName'
        },
        {
            selector: 'appPanel northPanel [itemId=HouseManage]',
            ref: 'northPanelOfHouse'
        },
        {
            selector: 'appPanel northPanel [itemId=DesignManage]',
            ref: 'northPanelOfDesign'
        },
        {
            selector: 'appPanel northPanel [itemId=GoodsManage]',
            ref: 'northPanelOfMaterial'
        },
        {
            selector: 'appPanel northPanel [itemId=ArticleManage]',
            ref: 'northPanelOfArticle'
        },
        {
            selector: 'appPanel northPanel [itemId=OrderManage]',
            ref: 'northPanelOfOrder'
        }
    ],

    init: function () {
        this.control({
            'appPanel':{
                afterrender: function(){
                    var me = this;

                    var hash = Ext.ToolUtil.getHashParam();
                    if(!hash){
                        if(me.role == 10){
                            hash = 'UserManage';
                        }else if(me.role == 11){
                            hash = 'HouseManage';
                        }else if(me.role == 12){
                            hash = 'GoodsManage';
                        }else if(me.role == 13){
                            hash = 'ArticleManage';
                        }
                    }
                    me.loadModule(hash);
                }
            },
            'appPanel northPanel button':{
                click: function(btn){
                    var item = btn.itemId,
                        name = btn.text,
                        me = this;

                    if(item == 'logout'){
                        Ext.Msg.confirm('退出', "确认退出？", function(btn){
                            if(btn == 'yes'){
                                me.logoutHandler();
                            }
                        });
                        return;
                    }
                    me.loadModule(item);
                }
            },
            'appPanel westPanel treepanel':{
                itemclick: function(view, record){
                    var me = this;
                    if(!record.raw.ctr){
                        return;
                    }
                    me.loadWorkPanel(record.raw.xtype, record.raw.text, record.raw.ctr);
                }
            }
        });
    },

    role: '',
    doInitial: function (user) {
        var me = this;
        me.role = Number(user.isSpecial);

        me.initHashName(me.role);

        Ext.widget("appPanel", {
            welcome: "",
            height: Ext.ToolUtil.getWindowHeight()
        });

        me.initMenuByAction(user.isSpecial);
        me.getNorthPanelOfName().setText(user.userName);

    },

    loadModule: function(item){
        var me = this;
        window.location.hash = item;
        var menuList = MenuList[item] || [],
            menuPanel = me.getMenuPanel();
        menuPanel.removeAll();

        menuPanel.setTitle(menuList[0].name);
        for(var i = 0, len = menuList.length; i < len; i++){
            var treeData ={};
            // 对像深拷贝
            Ext.merge(treeData, menuList[i]);
            if(!menuList[i].xtype){
                menuPanel.add(new Ext.panel.Panel(treeData));
            }else if(menuList[i].xtype == 'treepanel'){
                var tree = new Ext.tree.Panel(treeData);
                tree.expandAll();
                menuPanel.add(tree);
            }
        }
        me.getCenterPanel().removeAll();
    },

    logoutHandler: function(){
        Ext.AjaxUtil.getAction({
            url: dev_base + "data/user/logout",
            callback: function(re){
                location.reload();
            }
        });
    },

    /**
     * 添加事件，单击树形菜单显示不同工作区
     */
    loadWorkPanel: function (xtype, title, ctr) {
        var me = this;
        console.log(xtype);

        // 获取叶子节点对应的 controller
        var controller;

        if(ctr){
            controller = coreApp.loadController(ctr);
            controller.record = null;
        }

        me.getCenterPanel().removeAll();

        //显示该 controller 的 view
        var viewer = Ext.widget(xtype);

        me.getCenterPanel().add(viewer);
        me.getCenterPanel().setTitle(title);

    },

    /**
     * 根据权限显示菜单
     * @param role
     */
    initMenuByAction: function(role){
        var me = this, tp = {}, t = {};
        var UserManage = me.getNorthPanelOfUser();
        var UserDesignManage = me.getNorthPanelOfUserDesign();
        var HouseManage = me.getNorthPanelOfHouse();
        var DesignManage = me.getNorthPanelOfDesign();
        var MaterialManage = me.getNorthPanelOfMaterial();
        var ArticleManage = me.getNorthPanelOfArticle();
        var OrderManage = me.getNorthPanelOfOrder();
        role = Number(role);
        switch (role){
            case 10:
                UserManage.show();
                HouseManage.show();
                DesignManage.show();
                MaterialManage.show();
                ArticleManage.show();
                OrderManage.show();
                window.location.hash = 'UserManage';
                break;
            case 11:
                HouseManage.show();
                UserDesignManage.show();
                DesignManage.show();
                window.location.hash = 'HouseManage';
                break;
            case 12:
                MaterialManage.show();
                window.location.hash = 'GoodsManage';
                break;
            case 13:
                ArticleManage.show();
                window.location.hash = 'ArticleManage';
                break;
            default :
                HouseManage.show();
                DesignManage.show();
                MaterialManage.show();
                ArticleManage.show();
                break;
        }

        return tp;
    },

    initHashName: function(role){
        role = Number(role);
        switch (role){
            case 10:
                window.location.hash = 'UserManage';
                break;
            case 11:
                window.location.hash = 'HouseManage';
                break;
            case 12:
                window.location.hash = 'GoodsManage';
                break;
            case 13:
                window.location.hash = 'ArticleManage';
                break;
            default :
                window.location.hash = 'UserManage';
                break;
        }
    }
});