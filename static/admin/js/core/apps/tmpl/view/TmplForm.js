/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.TmplApp.view.TmplForm", {
    extend: 'PMS.BaseComp.BaseForm',
    alias: 'widget.tmplForm',

    initComponent:function () {
        var me = this;
        me.items = [

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

        return values;
    },
    emptyForm: function(){
        var me = this;

        me.getForm().reset();
    }
});