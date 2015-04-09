/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 12-8-17
 * Time: 上午9:44
 * To change this template use File | Settings | File Templates.
 */

var MenuList = {
    // 系统管理
    "SystemManage": [
        {
            "xtype": 'treepanel',
            "collapsible": false,
            "rootVisible": false,
            "name": '系统参数管理',
            "border": 0,
            "root": {
                text: '系统参数管理',
                children: [
                    {
                        "text": "首页内容",
                        "children": [
                            {
                                ctr: 'PMS.apps.UsersApp.controller.UsersController',
                                xtype: 'usersGrid',
                                text: '首页', action: '', leaf: true
                            }
                        ]
                    },
                    {
                        "text": "帮助中心",
                        "children": [
                            {
                                ctr: 'PMS.apps.UsersApp.controller.UsersController',
                                xtype: 'usersGrid',
                                text: '帮助中心', action: '', leaf: true
                            }
                        ]
                    }
                ]
            }
        }
    ],
    // 用户管理
    "UserManage":[
        {
            "xtype": 'treepanel',
            "collapsible": false,
            "rootVisible": false,
            "border": 0,
            "name": '用户管理',
            "itemId": "designerTreeMenu",
            "root": {
                "children": [
                    {
                        text: '管理员用户',
                        children: [
                            {
                                ctr: 'PMS.apps.UsersApp.controller.AdminController',
                                xtype: 'adminGrid',
                                text: '管理员列表', action: '', leaf: true
                            }
                        ]
                    },
                    {
                        text: '普通用户',
                        children: [
                            {
                                ctr: 'PMS.apps.UsersApp.controller.UsersController',
                                xtype: 'usersGrid',
                                text: '用户列表', action: '', leaf: true
                            }
                        ]
                    },
                    {
                        text: '设计师用户',
                        children: [
                            {
                                xtype: 'designersGrid',
                                ctr: 'PMS.apps.DesignersApp.controller.DesignersController',
                                text: '待审核', action: '', leaf: true, type: '2'
                            },
                            {
                                xtype: 'designersGrid',
                                ctr: 'PMS.apps.DesignersApp.controller.DesignersController',
                                text: '审核成功', action: '', leaf: true, type: '1'
                            },
                            {
                                xtype: 'designersGrid',
                                ctr: 'PMS.apps.DesignersApp.controller.DesignersController',
                                text: '审核失败', action: '', leaf: true, type: '0'
                            }
                        ]
                    }
                ]
            }
        }
    ],
    // 用户管理(设计师)
    "UserDesignManage":[
        {
            "xtype": 'treepanel',
            "collapsible": false,
            "rootVisible": false,
            "border": 0,
            "name": '用户管理',
            "itemId": "designerTreeMenu",
            "root": {
                "children": [
                    {
                        text: '设计师用户',
                        children: [
                            {
                                xtype: 'designersGrid',
                                ctr: 'PMS.apps.DesignersApp.controller.DesignersController',
                                text: '待审核', action: '', leaf: true, type: '2'
                            },
                            {
                                xtype: 'designersGrid',
                                ctr: 'PMS.apps.DesignersApp.controller.DesignersController',
                                text: '审核成功', action: '', leaf: true, type: '1'
                            },
                            {
                                xtype: 'designersGrid',
                                ctr: 'PMS.apps.DesignersApp.controller.DesignersController',
                                text: '审核失败', action: '', leaf: true, type: '0'
                            }
                        ]
                    }
                ]
            }
        }
    ],

    // 户型管理
    "HouseManage": [
        {
            "xtype": 'treepanel',
            "collapsible": false,
            "rootVisible": false,
            "border": 0,
            "name": '户型管理',
            "root": {
                children: [
                    {
                        "text": '户型管理',
                        "children": [
                            {
                                ctr: 'PMS.apps.HouseApp.controller.HouseController',
                                xtype: 'houseGrid',
                                text: '户型列表', action: '', leaf: true
                            },
                            {
                                ctr: 'PMS.apps.HouseApp.controller.HouseController',
                                xtype: 'houseWin',
                                text: '添加户型', action: '', leaf: true
                            }
                        ]
                    },
                    {
                        "text": '楼盘管理',
                        "children": [
                            {
                                ctr: 'PMS.apps.BuildingApp.controller.BuildingController',
                                xtype: 'buildingGrid',
                                text: '楼盘列表', action: '', leaf: true
                            }
                        ]
                    }
                ]
            }
        }
    ],

    // 设计管理
    "DesignManage": [
        {
            "xtype": 'treepanel',
            "collapsible": false,
            "rootVisible": false,
            "name": "设计管理",
            "itemId": "designTreeMenu",
            "border": 0,
            "root": {
                text: '设计管理',
                children: [
                    {
                        "text": '方案管理',
                        "children": [
                            {
                                ctr: 'PMS.apps.DesignApp.controller.DesignController',
                                xtype: 'designGrid',
                                text: '待审核的设计方案', action: '', leaf: true, type: '2'
                            },
                            {
                                ctr: 'PMS.apps.DesignApp.controller.DesignController',
                                xtype: 'designGrid',
                                text: '审核成功的设计方案', action: '', leaf: true, type: '0'
                            },
                            {
                                ctr: 'PMS.apps.DesignApp.controller.DesignController',
                                xtype: 'designGrid',
                                text: '仓库中的设计方案', action: '', leaf: true, type: '3'
                            },
                            {
                                ctr: 'PMS.apps.DesignApp.controller.DesignController',
                                xtype: 'designGrid',
                                text: '审核失败的设计方案', action: '', leaf: true, type: '4'
                            }
                        ]
                    },
                    {
                        text: '评论管理',
                        children: [
                            {
                                ctr: 'PMS.apps.DesignApp.controller.CommentController',
                                xtype: 'commentGrid',
                                text: '评论列表', action: '', leaf: true
                            }
                        ]
                    },
                    {
                        text: '施工风格管理',
                        children: [
                            {
                                ctr: 'PMS.apps.DesignApp.controller.DesignStyleController',
                                xtype: 'designStyleList',
                                text: '施工风格列表', action: '', leaf: true
                            }
                        ]
                    }

                ]
            }
        }
    ],

    // 建材管理
    "GoodsManage": [
        {
            "xtype": 'treepanel',
            "collapsible": false,
            "rootVisible": false,
            "name": "建材管理",
            "border": 0,
            "root":{
                children:[
                    {
                        "text": '商品管理',
                        "children": [
                            {
                                ctr: 'PMS.apps.GoodsApp.controller.GoodsController',
                                xtype: 'goodsGrid',
                                text: '商品列表', action: '', leaf: true},
                            {
                                ctr: 'PMS.apps.GoodsApp.controller.GoodsWinController',
                                xtype: 'goodsWin',
                                text: '商品添加', action: '', leaf: true}
                        ]
                    },
                    {
                        "text": '商品分类',
                        "children": [
                            {
                                ctr: 'PMS.apps.GoodsApp.controller.CategoryController',
                                xtype: 'goodsCategoryList',
                                text: '分类列表', action: '', leaf: true
                            }
//                            {
//                                ctr: 'PMS.apps.GoodsApp.controller.GoodsController',
//                                xtype: 'goodsGrid',
//                                text: '属性列表', action: '', leaf: true
//                            }
                        ]
                    },
                    {
                        "text": '品牌管理',
                        "children": [
                            {
                                ctr: 'PMS.apps.GoodsApp.controller.BrandController',
                                xtype: 'brandWin',
                                text: '添加品牌', action: '', leaf: true},
                            {
                                ctr: 'PMS.apps.GoodsApp.controller.BrandController',
                                xtype: 'brandList',
                                text: '品牌列表', action: '', leaf: true}
                        ]
                    },
                    {
                        "text": '规格管理',
                        "children": [
                            {
                                ctr: 'PMS.apps.GoodsApp.controller.SkuController',
                                xtype: 'skuList',
                                text: '规格列表', action: '', leaf: true
                            },
                            {
                                ctr: 'PMS.apps.GoodsApp.controller.SkuImageController',
                                xtype: 'skuImageList',
                                text: '规格图库', action: '', leaf: true
                            }
                        ]
                    },
                    {
                        "text": '供应商管理',
                        "children": [
                            {
                                ctr: 'PMS.apps.GoodsApp.controller.SupplyController',
                                xtype: 'supplyList',
                                text: '供应商列表', action: '', leaf: true
                            }
//                            {
//                                ctr: 'PMS.apps.GoodsApp.controller.SupplyController',
//                                xtype: 'supplyWin',
//                                text: '添加供应商', action: '', leaf: true
//                            }
                        ]
                    }
                ]
            }
        }
    ],

    // 文章管理
    "ArticleManage": [
        {
            "xtype": 'treepanel',
            "collapsible": false,
            "rootVisible": false,
            "name": "文章管理",
            "border": 0,
            "root":{
                children:[
                    {
                        "text": '文章管理',
                        "children": [
                            {
                                ctr: 'PMS.apps.ArticleApp.controller.ArticleController',
                                xtype: 'articleGrid',
                                text: '文章列表', action: '', leaf: true},
                            {
                                ctr: 'PMS.apps.ArticleApp.controller.ArticleWinController',
                                xtype: 'articleWin',
                                text: '文章添加', action: '', leaf: true}
                        ]
                    },
                    {
                        "text": '文章分类',
                        "children": [
                            {
                                ctr: 'PMS.apps.ArticleApp.controller.CategoryController',
                                xtype: 'articleCategoryList',
                                text: '分类列表', action: '', leaf: true
                            }
                        ]
                    }
                ]
            }
        }
    ],

    // 订单管理
    "OrderManage": [
        {
            "xtype": 'treepanel',
            "collapsible": false,
            "rootVisible": false,
            "name": "订单管理",
            "border": 0,
            "root":{
                children:[
                    {
                        "text": '设计订单',
                        "children": [
                            {
                                ctr: 'PMS.apps.OrderApp.controller.OrderController',
                                xtype: 'orderGrid',
                                text: '订单列表', action: '', leaf: true
                            }
                        ]
                    }
                ]
            }
        }
    ]
};
Ext.define('PMS.coreApp.store.MenuList', {
    extend: 'Ext.data.TreeStore',
    root: []
});