/**
 * Created with IntelliJ IDEA.
 * User: pzb
 * Date: 12-8-1
 * Time: 下午10:28
 * To change this template use File | Settings | File Templates.
 */

Ext.define('PMS.apps.ArticleApp.view.CategoryWin', {
    extend:'Ext.window.Window',
    alias:'widget.articleCategoryWin',

    width: 350,

    title: '添加类别',
    border: false,
    autoShow: true,

    buttonAlign: 'center',
    layout: 'fit',

    initComponent:function () {
        var me = this;

        me.items = [
            {
                xtype:'form',
                border: false,
                defaults:{
                    labelAlign:'right',
                    labelWidth:100,
                    border:false,
                    allowBlank: false,
                    margin:'10 0 10 0'
                },
                items:[
                    {
                        xtype:'textfield',
                        name:"id",
                        hidden: true,
                        allowBlank: true
                    },
                    {
                        xtype:'textfield',
                        fieldLabel:'类别名称',
                        name:"text",
                        emptyText:'空',
                        blankText:"名称不能为空"
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: '是否显示',
                        name: 'enable',
                        itemId: 'enableCombo',
                        store: Ext.create("Ext.data.Store", {
                            fields: ['value', 'name'],
                            data: [
                                {value: 0, name: "是"},
                                {value: 1, name: "否"}
                            ]
                        }),
                        valueField: "value",
                        displayField: "name",
                        queryMode: 'local',
                        editable: false,
                        value: 0
                    },
                    {
                        xtype:'textfield',
                        disabled: true,
                        editable: false,
                        fieldLabel:'父类别',
                        allowBlank: true,
                        itemId: 'parentName',
                        name:"parentName"
                    },
                    {
                        xtype:'textfield',
                        hidden: true,
                        allowBlank: true,
                        itemId: 'parentId',
                        name:"parentId"
                    }
                ]
            }
        ];
        me.buttons = [
            {
                text:'确定添加',
                formBind:true,
                action:'SaveAddButton',
                hidden:true
            },
            {
                text:'确定保存',
                formBind:true,
                action:'SaveUpdateButton',
                hidden:true
            },
            {
                text:'返回',
                handler:this.close,
                scope:this
            }
        ];
        me.callParent(arguments);
    }
});