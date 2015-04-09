/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午4:58
 * To change this template use File | Settings | File Templates.
 */
/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午4:58
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.BaseComp.BaseQueryForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.baseQueryForm',

    title: '查询',
    width: '100%',
    autoScroll: true,

    buttonAlign:"left",
    bodyPadding: 10,
    collapsible: true,
    flex: 1,

    initComponent: function(){
        var me = this;
        me.defaults = {
            border: false,
            labelWidth: 100,
            labelAlign: 'right',
            margin: '5px 0'
        };
        me.items = [
            {
                xtype: 'textfield',
                fieldLabel: '关键字检索',
                name: 'keyword',
                emptyText: '请输入关键字'
            }
        ];

        me.buttons = [
            {
                text:'确认查询',
                action:'Confirm'
            },
            '-',
            {
                text:'重置',
                action:'Reset'
            },
            '-',
            {
                text:'查询所有',
                action:'QueryAll'
            }
        ];

        me.callParent();
    }
});