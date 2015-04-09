Ext.define("PMS.apps.GoodsApp.view.SupplyWin", {
    extend: 'Ext.window.Window',
    alias: 'widget.supplyWin',

    width:300,

    title: '新增供应商',
    modal: true,
    autoShow: true,
    draggable: true,

    border: false,
    buttonAlign:'center',

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'panel',
                border: false,
                items:[
                    {
                        xtype: 'supplyBaseForm',
                        border: false,
                        itemId: 'supplyBaseForm'
                    }
                ]
            }
        ];
        me.buttons =  [
            {
                text: '确认保存',
                itemId: 'SaveButton',
                action: 'SaveAction'
            },
            {
                text: '返回',
                handler: this.close,
                scope: this
            }
        ];
        me.callParent()
    }
});
Ext.define("PMS.apps.GoodsApp.view.SupplyBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.supplyBaseForm',
    defaults: {
        labelWidth: 100,
        labelAlign: 'right',
        padding:"5 0 5 0",
        blankText:"不能为空",
        border: false
    },
    items:[
        {
            xtype: "numberfield",
            hidden: true,
            allowBlank: true,
            name: 'id'
        },
        {
            xtype: "textfield",
            fieldLabel: "供应商名称:",
            allowBlank: false,
            name: 'name'
        }
    ],

    getFormValues: function(){
        var me = this,
            values = me.getForm().getValues();
        var pd = {
            name: values.name,
            id: values.id || null
        };
        if(!pd.name){
            return {
                error: '请填写名称'
            }
        }
        return pd;
    },

    setFormValues: function(record){
        var me = this;
        me.getForm().loadRecord(record);
    }

});