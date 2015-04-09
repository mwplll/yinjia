/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.ArticleApp.view.ArticleWin", {
    extend: 'Ext.panel.Panel',
    alias: 'widget.articleWin',
    requires: [
        'Ext.ux.TreeCombo'
    ],
    border: false,
    layout: 'fit',
    buttonAlign:'center',
    autoScroll: true,

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'articleBaseForm',
                itemId: 'articleBaseForm',
//                title: '基本信息',
                border: 0,
                autoScroll: true,
                index: 0
            }
        ];
        me.buttons =  [
            {
                text: '确认保存',
                itemId: 'SaveButton'
            },
            {
                text: '返回',
                hidden: true
            }
        ];
        me.callParent()
    }
});

Ext.define("PMS.apps.ArticleApp.view.ArticleBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.articleBaseForm',
    padding: '10 5 20 5',
    defaults: {
        padding: '10 5'
    },
    items:[
        {
            xtype: 'fieldset',
            title: "基本信息",
            itemId: 'baseInfo',
            defaults:{
                labelAlign:"right",
                labelWidth:90,
                margin: '0 0 10 0',
                columnWidth:.25
            } ,
            border: true,
            collapsible: true,
            layout: 'column',
            items: [
                {
                    xtype: "textfield",
                    hidden: true,
                    name: 'id',
                    itemId: 'articleId'
                },
                {
                    xtype: "textfield",
                    columnWidth:.9,
                    maxLength: 50,
                    allowBlank: false,
                    maxLengthText: '最多输入50个字',
                    fieldLabel: "标题" + '<font color = red>*</font>',
                    name: 'title',
                    itemId: 'title'
                },
                {
                    xtype: "textarea",
                    columnWidth:.9,
                    maxLength: 50,
                    height: 100,
                    allowBlank: false,
                    fieldLabel: "简介" + '<font color = red>*</font>',
                    name: 'summary',
                    itemId: 'summary'
                },

                {
                    xtype: "numberfield",
                    columnWidth:.3,
                    allowBlank: true,
                    minValue: 0,
                    fieldLabel: "排序",
                    name: 'sort',
                    itemId: 'sort'
                },
                {
                    xtype: 'combo',
                    fieldLabel: '置顶'+ '<font color = red>*</font>',
                    columnWidth:.3,
                    name: 'top',
                    store: Ext.create("Ext.data.Store", {
                        fields: ['value', 'name'],
                        data: [
                            {value: "1", name: "是"},
                            {value: "0", name: "否"}
                        ]
                    }),
                    valueField: "value",
                    displayField: "name",
                    queryMode: 'local',
                    editable: false,
                    allowBlank: false,
                    value: "0"
                },
                {
                    xtype: 'combo',
                    fieldLabel: '状态'+ '<font color = red>*</font>',
                    columnWidth:.3,
                    name: 'state',
                    store: Ext.create("Ext.data.Store", {
                        fields: ['value', 'name'],
                        data: [
                            {value: "2", name: "下架"},
                            {value: "0", name: "上架"}
                        ]
                    }),
                    valueField: "value",
                    displayField: "name",
                    queryMode: 'local',
                    editable: false,
                    allowBlank: false,
                    value: "0"
                }
            ]
        },
//        {
//            xtype: 'fieldset',
//            title: '商品分类' + '<font color = red>*</font>',
//            defaults:{
//                labelAlign:"right",
//                labelWidth: 90
//            } ,
//            border: true,
//            collapsible: true,
//            layout: 'hbox',
//            items: [
//                {
//                    xtype: 'treepanel',
//                    border: false,
//                    itemId: 'ArticleCategoryTree',
//                    width: 700,
//                    rootVisible: false
//                }
//            ]
//        },
        ,

        {
            xtype: 'fieldset',
            collapsible: true,
            title: '文章主图',
            defaults:{
                labelWidth: 100,
                border: false,
                margin: "0 0 10 0",
                allowBlank: false,
                labelAlign: 'right'
            },
            layout: 'column',
            items:[
                {
                    width: 200,
                    height: 200,
                    border: true,
                    itemId: 'imageBoxWrap',
                    margin: "0 0 10 45",
                    items: [
                        {
                            xtype: 'image',
                            itemId: 'imageBox',
                            border: true,
                            width: 200,
                            height: 200,
                            region: 'center'
                        }
                    ]
                },
                {
                    xtype: 'button',
                    itemId: 'uploadArticleButton',
                    width: 40,
                    margin: '0 0 0 20',
                    text: '上传'
                },

                {
                    xtype: 'textfield',
                    name: 'pic',
                    itemId: "picTextField",
                    width: 350,
                    hidden: true,
                    fieldLabel: '主图'
                }
            ]
        },
        {
            xtype: 'fieldset',
            title: '文章内容',
            defaults:{
                labelAlign:"right",
                labelWidth:90
            } ,
            border: true,
            itemId: "articleDetailForm",
            collapsible: true,
            items: [
                {xtype: 'articleDetailForm'}

            ]
        }
    ],

    getFormValues: function(){
        var me = this;
        var values = me.getForm().getValues();

        var tmp = me.validate(values);
        if(tmp.success){
            return values;
        }else{
            return tmp;
        }
    },

    validate: function(values){
        var error = '', success = true;
        if(!values.title){
            error = '请输入标题';
            success = false;
        }else if(!values.summary){
            error = '请输入文章简介';
            success = false;
        }else if(!values.catId){
            error = '请选择文章分类';
            success = false;
        }
        return {
            success: success,
            error: error
        }
    }

});

// 详情描述
Ext.define("PMS.apps.ArticleApp.view.ArticleDetail",{
    extend: 'Ext.form.Panel',
    alias: 'widget.articleDetailForm',

    requires: [
        'PMS.BaseComp.Ueditor'
    ],

    items: [
        {
            xtype:'ueditor',
            id:'ux',
            name:'artcont',
            labelWidth: 50,
            width: '100%',
            height: 600,
            allowBlank: false
        }
    ],

    afterRender: function(){
        var me = this;
        me.callParent();

    }
});
