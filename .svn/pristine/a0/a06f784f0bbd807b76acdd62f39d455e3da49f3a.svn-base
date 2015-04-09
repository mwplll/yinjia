/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午4:58
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.BaseComp.BaseForm", {
    extend: 'Ext.form.Panel',
    alias: 'widget.baseForm',

    border: false,
    autoScroll: true,
    autoHeight: true,

    defaults: {
        labelAlign: 'right',
        margin: 10,
        width:250,
        labelWidth: 80,
        allowBlank: true,
        border:false ,
        anchor:"60%"
    },

    buttonAlign: 'center',
    required :'<span style="color:red;font-weight:bold" data-qtip="Required">*</span>',
    initComponent:function () {
        var me = this;
        me.tbar = [
            {
                xtype: 'button',
                text:'新增',
                iconCls: 'add_btn',
                action:'Add',
                itemId:"AddBtn"
            }
        ];
        me.bbar = [
            {
                xtype: 'button',
                text:'保存',
                iconCls: 'save_btn',
                action:'Save' ,
                itemId:"SaveBtn"
            }
        ];
        me.callParent();
    },

    setFormValues: function(record){
        var me = this;
        me.getForm().loadRecord(record);
    },

    getFormValues: function(){
        var me = this,
            values = me.getValues();

        return me.getValues();
    },
    emptyForm: function(){
        var me = this;
        me.getForm().reset();
    }
});