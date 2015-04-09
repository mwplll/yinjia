/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.ArticleApp.controller.CategoryController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.ArticleApp.model.CategoryModel'
    ],
    stores: [

    ],
    views: [
        'PMS.apps.ArticleApp.view.CategoryList',
        'PMS.apps.ArticleApp.view.CategoryWin'
    ],

    refs: [
        {
            selector: 'articleCategoryList',
            ref: 'articleCategoryList'
        },
        {
            selector: 'articleCategoryWin',
            ref: 'articleCategoryWin'
        },
        {
            selector: 'articleCategoryWin form',
            ref: 'categoryAddForm'
        },
        {
            selector: 'articleCategoryWin button[action=SaveAddButton]',
            ref: 'saveAddButton'
        },
        {
            selector: 'articleCategoryWin button[action=SaveUpdateButton]',
            ref: 'saveUpdateButton'
        },
        {
            selector: 'articleCategoryList button[action=AddCategoryButton]',
            ref: 'addCategoryButton'
        }
    ],
    init: function(){
        console.log("ArticleCategoryController init");
        this.control({
            'articleCategoryList':{
                afterrender: function(){
                    var me = this;
                    me.initTreeGrid();
                },
                //弹出  编辑类别  窗口
                itemdblclick: function(grid, record){
                    var me = this;
                    Ext.widget('articleCategoryWin');
                    var form = me.getCategoryAddForm(),
                        parentNameComp = form.queryById('parentName');
                    form.getForm().loadRecord(record);

                    parentNameComp.hide();
                    me.getSaveUpdateButton().show();
                    me.getArticleCategoryWin().setTitle("编辑类别");
                }
            },

            'articleCategoryList button[action=AddCategoryButton]':{
                click: function(){
                    var me = this;
                    var selection = me.getArticleCategoryList().getSelectionModel().getSelection(),
                        name, parentId;
                    Ext.widget('articleCategoryWin');

                    me.getSaveAddButton().show();
                    if(selection.length){
                        // 二级子类或以下
                        name = selection[0].raw.text;
                        parentId = selection[0].raw.categoryId;
                    }else{
                        // ROOT 下面 一级子类
                        name = "ROOT";
                        parentId = 0;
                    }

                    var form = me.getCategoryAddForm(),
                        parentNameComp = form.queryById('parentName'),
                        parentIdComp = form.queryById('parentId');
                    parentNameComp.setValue(name);
                    parentIdComp.setValue(parentId);
                    parentNameComp.show();
                }
            },
            'articleCategoryList button[action=ExpendButton]':{
                click: function(){
                    var me = this;
                    me.expendAction('expend');
                }
            },
            'articleCategoryList button[action=CollapseButton]':{
                click: function(){
                    var me = this;
                    me.expendAction('collapse');
                }
            },
            'articleCategoryList button[action=RemoveCategoryButton]':{
                click: function(){
                    var me = this,
                        tree = me.getArticleCategoryList(),
                        selections = tree.getSelectionModel().getSelection();
                    if(!selections.length){
                        Ext.example.msg("提示", '请先选择要删除的类别!');
                        return;
                    }
                    me.removeCategoryAction(selections[0]);
                }
            },
            'articleCategoryList actioncolumn':{
                click: function(grid, rowIndex, colIndex, actionItem, event, record){
                    var me = this;
                    var className = event.getTarget().className;
                    if(className.indexOf("delete-col") >= 0){ //删除
                        if(!record.data.leaf){ //非叶子节点不能删除
                            return;
                        }
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                me.removeCategoryAction(record);
                            }
                        });
                    }else if(className.indexOf("edit-col") >= 0){
                        Ext.widget('articleCategoryWin');

                        var form = me.getCategoryAddForm(),
                            parentIdComp = form.queryById('parentName');

                        form.getForm().loadRecord(record);
                        form.queryById("enableCombo").setValue(Number(record.get("enable")));
                        parentIdComp.hide();
                        me.getSaveUpdateButton().show();
                        me.getArticleCategoryWin().setTitle("编辑类别");
                    }

                }
            },

            'articleCategoryWin button[action=SaveAddButton]': {
                click: function(){
                    var me = this;
                    me.saveAction('add');
                }
            },
            'articleCategoryWin button[action=SaveUpdateButton]': {
                click: function(){
                    var me = this;
                    me.saveAction('update');
                }
            }
        });
    },
    initTreeGrid: function(){
        var me = this;
        me.getAddCategoryButton().show();
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.list,
            callback: function(result){
                if(result.data){
                    var st = Ext.create("Ext.data.TreeStore", {
                        extend: 'Ext.data.TreeStore',
                        model: 'PMS.apps.ArticleApp.model.CategoryModel',
                        root: {
                            expended: true,
                            text:  '根目录',
                            categoryId:0,
                            children: Ext.ToolUtil.createArticleTreeModel(result.data)
                        }
                    });
                    me.getArticleCategoryList().bindStore(st);
                    me.getArticleCategoryList().expandAll();
                }
            }
        });
    },


    // 展开 收起
    expendAction: function(action){
        var me = this,
            tree = me.getArticleCategoryList();
        if(action == 'expend'){
            tree.expandAll();
        }else{
            tree.collapseAll();
        }
    },

    // 添加 编辑子类别
    saveAction: function(action){
        var me = this,
            tree = me.getArticleCategoryList(),
            values = me.getCategoryAddForm().getValues(),
            postData = {
                name: values.text,
                fatherId: values.parentId,
                id: values.id,
                state: values.enable
            };

        if(!postData.name){
            Ext.example.msg("提示","名称不能为空!");
            return;
        }
        Ext.AjaxUtil.saveAction({
            url: me.requestUrl.save,
            data: postData,
            callback: function(result){
                me.initTreeGrid();
                me.getArticleCategoryWin() && me.getArticleCategoryWin().close();
            }
        });
    },

    // 删除类别
    removeCategoryAction: function(record){
        var me = this, id = record.raw.categoryId;
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.del,
            data: {id: id},
            callback: function(result){
                me.initTreeGrid();
            }
        });
    },
    requestUrl: {
        del: dev_base + 'data/article/category/edit?act=del&_dt=' + Math.random(),
        save: dev_base + 'data/article/category/edit?act=save&_dt=' + Math.random(),
        list:  dev_base + 'data/article/category/list?_dt=' + Math.random()
    }
});