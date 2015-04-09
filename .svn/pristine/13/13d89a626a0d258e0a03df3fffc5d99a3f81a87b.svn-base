/**
 * Created with IntelliJ IDEA.
 * User: pzb
 * Date: 12-8-1
 * Time: 下午10:28
 * To change this template use File | Settings | File Templates.
 */

Ext.define('PMS.apps.DesignApp.view.DesignStyleWin', {
    extend:'Ext.window.Window',
    alias:'widget.designStyleWin',

    width: 350,

    title: '添加风格',
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
                        name:"styleId",
                        hidden: true,
                        allowBlank: true
                    },
                    {
                        xtype:'textfield',
                        disabled: true,
                        editable: false,
                        fieldLabel:'施工风格',
                        allowBlank: true,
                        itemId: 'styleName',
                        name:"styleName"
                    },
                    {
                        xtype:'textfield',
                        fieldLabel:'风格名称',
                        name:"text",
                        itemId:"nameField",
                        emptyText:'空',
                        blankText:"名称不能为空"
                    },
                    {
                        xtype:'numberfield',
                        fieldLabel:'价格',
                        name:"price",
                        itemId:"priceField",
                        emptyText:'空',
                        blankText:"价格不能为空"
                    },

                    {
                        xtype:'textfield',
                        hidden: true,
                        allowBlank: true,
                        name:"leaf"
                    }
                ]
            }
        ];
        me.buttons = [
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