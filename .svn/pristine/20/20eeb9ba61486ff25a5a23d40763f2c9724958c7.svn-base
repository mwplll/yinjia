/**
 * Created with JetBrains WebStorm.
 * User: zyc
 * Date: 12-11-12
 * Time: 下午9:24
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.coreApp.view.AppPanel",{
    extend: 'Ext.container.Viewport',
    alias: 'widget.appPanel',
    layout: 'border',//表格布局

    menuItems: [],
    items: [
        {
            xtype: 'northPanel',
            itemId: 'northPanel'
        },
        {
            xtype: 'westPanel',
            itemId: 'westPanel'
        },
        {
            xtype: 'centerPanel',
            itemId: 'centerPanel'
        }
    ]
});
// Title
Ext.define("PMS.coreApp.view.AppPanel.NorthPanel",{
    extend: 'Ext.panel.Panel',
    alias: 'widget.northPanel',
    region: 'north',
    border: false,
    bbar: [
        {
            html: "<font size='5'>印家后台管理系统</font>",
            xtype: 'component',
            width: 200
        },
//        '-',
        {
            text: '用户管理',
            hidden: true,
            itemId: 'UserManage',
            iconCls: 'user-icon'
        },
        {
            text: '用户管理',
            hidden: true,
            itemId: 'UserDesignManage',
            iconCls: 'user-icon'
        },
//        '-',
        {
            text: '户型管理',
            hidden: true,
            itemId: 'HouseManage',
            iconCls: 'house-icon'
        },
//        '-',
        {
            text: '设计方案管理',
            hidden: true,
            itemId: 'DesignManage',
            iconCls: 'design-icon'
        },
//        '-',
        {
            text: '建材管理',
            hidden: true,
            itemId: 'GoodsManage',
            iconCls: 'good-icon'
        },
//        '-',
        {
            text: '文章管理',
            hidden: true,
            itemId: 'ArticleManage',
            iconCls: 'good-icon'
        },
//        '-',
        {
            text: '订单管理',
            hidden: true,
            itemId: 'OrderManage',
            iconCls: 'order-icon'
        },
//        '-',
        {
            xtype: "tbfill"
        },
        {

            text: "",
            xtype: 'label',
            itemId: 'UserName'
        },
        {
            pressed: false,
            itemId: 'logout',
            text: '退出'
        }
    ]
});

// 菜单栏
Ext.define("PMS.coreApp.view.AppPanel.WestPanel",{
    extend: 'Ext.panel.Panel',
    alias: 'widget.westPanel',
    title: '操作菜单',
    region: 'west',
    collapsible: true,
    split: true,
    width: 200,
    margins: 1,
    //添加两块面板
    layout: 'auto',
    defaults: {
        border: 0,
        collapsible: false
    },
    items: [
    ]
});

// 主体内容
Ext.define("PMS.coreApp.view.AppPanel.CenterPanel",{
    extend: 'Ext.panel.Panel',
    alias: 'widget.centerPanel',
    border: false,
    region: 'center',
    title: '主界面',
    layout:'fit',
    items: []
});