/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.ArticleApp.controller.ArticleWinController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.ArticleApp.model.ArticleModel',
        'PMS.apps.ArticleApp.model.CategoryModel'
    ],
    stores: [
    ],

    views: [
        'PMS.apps.ArticleApp.view.ArticleWin'
    ],

    refs: [
        {
            selector: 'appPanel centerPanel',
            ref: 'centerPanel'
        },
        {
            selector: 'articleWin',
            ref: 'articleWin'
        },
        {
            selector: 'articleWin articleBaseForm',
            ref: 'articleBaseForm'
        },
        {
            selector: 'articleWin articleBaseForm [itemId=imageBoxWrap]',
            ref: 'imageBoxWrap'
        },
        {
            selector: 'articleWin articleBaseForm [itemId=articleCategoryTree]',
            ref: 'articleCategoryTree'
        },
        {
            selector: 'articleWin articleDetailForm ueditor',
            ref: 'articleUeditorForm'
        }
    ],

    record: null,

    init: function(){
        console.log("ArticleWinController init");

        this.control({
            "articleWin":{
                afterrender: function(){
                    var me = this;

                    // 显示类别
                    me.initCategoryCombo(function(){
                        if(me.record){
                            me.getArticleBaseForm().queryById("treeCombo").setValue(me.record.get("catId"));
                        }
                    });

                    // 详情 赋值
                    if(me.record){
                        me.getArticleBaseForm().getForm().loadRecord(me.record);

                        var src = image_base + me.record.get("pic");
                        if(src){
                            var imageBoxWrap = me.getImageBoxWrap(),
                                imageBox = imageBoxWrap.queryById('imageBox');
                            Ext.ImgAdjustUtil.imgAdjust(src, 200, 200, function (h, w) {
                                imageBox.setSrc(src);
                                imageBox.setSize(w,h);
                                imageBox.el.dom.style.marginLeft = (200-w) / 2 + "px";
                                imageBox.el.dom.style.marginTop = (200-h) / 2 + "px";
                            });
                        }
                    }else{}
                }
            },

            "articleWin articleDetailForm ueditor":{
                initialize: function(){
                    var me = this;
                    if(me.record){
                        me.getArticleUeditorForm().setValue(me.record.get("content"));
                    }
                }
            },

            "articleWin articleBaseForm button[itemId=uploadArticleButton]":{
                click: function(btn){
                    var me = this;
                    coreApp.fireEvent("UploadHouse", {
                        targetCtr: me,
                        uploadUrl: me.requestUrl.uploadArticle
                    });
                }
            },

            "articleWin button[itemId=SaveButton]":{
                click: function(){
                    var me = this;
                    // 保存基本信息
                    var  articleForm = me.getArticleBaseForm();
                    var pid = me.getArticleBaseForm().queryById("articleId").getValue();
//                    if(!articleForm.getForm().isValid()){
//                        return;
//                    }
                    var values = articleForm.getFormValues();
                    console.log("article save:");
                    console.log(values);
                    if(values.error){
                        Ext.example.msg("错误", values.error);
                        return;
                    }

                    var text = me.getArticleUeditorForm().getHtmlValue();
                    console.log("ueditor content:");
                    console.log(text);
                    values['content'] = text;

                    Ext.AjaxUtil.saveAction({
                        url : me.requestUrl['save'],
                        data: values,
                        callback: function(re){
                            Ext.example.msg("", "操作成功!");
                            coreApp.loadWorkPanel('articleGrid','文章列表', 'PMS.apps.ArticleApp.controller.ArticleController');
                        }
                    });
                }
            }
        });


        // 自定义事件 监听图片上传完成
        this.on({
            AfterImageUpload: function (data) {
                var me = this;
                var imageBoxWrap = me.getImageBoxWrap(),
                    articleForm = me.getArticleBaseForm(),
                    imageBox = imageBoxWrap.queryById('imageBox'),
                    picTextField = articleForm.queryById('picTextField');

                picTextField.setValue(data.serial);
                var src = image_base + data.serial;

                Ext.ImgAdjustUtil.imgAdjust(src, 200, 200, function (h, w) {
                    imageBox.setSrc(src);
                    imageBox.setSize(w,h);
                    imageBox.el.dom.style.marginLeft = (200-w) / 2 + "px";
                    imageBox.el.dom.style.marginTop = (200-h) / 2 + "px";
                });
            }
        });
    },

    // 文章分类
    initCategoryCombo: function(callback){
        var me  = this;
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.listCategory,
            callback: function (result) {
                if(!result.data){
                    return;
                }
                var st = Ext.create("Ext.data.TreeStore", {
                    extend: 'Ext.data.TreeStore',
                    model: 'PMS.apps.ArticleApp.model.CategoryModel',
                    root: {
                        expanded: true,
                        text:  '根目录',
                        id: 0,
                        categoryId: 0,
                        children: Ext.ToolUtil.createArticleTreeModel(result.data)
                    }
                });
                var treeCombo = Ext.create('Ext.ux.TreeCombo', {
                    store: st,
                    itemId: 'treeCombo',
                    emptyText: '选择文章分类',
                    fieldLabel: '文章分类'+ '<font color = red>*</font>',
                    labelAlign: 'right',
                    labelWidth:90,
                    name: 'catId',
                    margin: '0 0 10 0',
                    columnWidth:.25
                });

                // Hack 双击 出现两个分类
                var tree = me.getArticleBaseForm().queryById("treeCombo");
                if(tree){
                    me.getArticleBaseForm().queryById("baseInfo").remove(tree);
                }

                me.getArticleBaseForm().queryById("baseInfo").add(treeCombo);
                if(callback){
                    callback();
                }
            }
        });
    },

    // 商品图片
    initImageGrid: function(record){
        var me = this,
            index = -1,
            li = [],
            imageGrid = me.getArticleImageGrid();
        if(record){
            Ext.each(record.get('picList'), function(it, i){
                li.push({
                    pic: it.pic,
                    is_main: it.pic == record.get("pic")
                });
                if(it.pic == record.get("pic")){
                    index = i;
                }
            });
        }

        var imageStore = Ext.create("Ext.data.Store",{
            model: "PMS.apps.ArticleApp.model.ArticleImageModel",
            data: li
        });
        imageGrid.bindStore(imageStore);
        if(index >= 0){
            imageGrid.getSelectionModel().select(imageStore.getAt(index));
        }
    },

    requestUrl: {
        uploadArticle: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=article",
        save: dev_base + 'data/article/edit?act=save&_dt=' + Math.random(),
        detail: dev_base + 'data/article/info?_dt=' + Math.random(),
        listCategory: dev_base + 'data/article/category/list?_dt=' + Math.random()
    }
});