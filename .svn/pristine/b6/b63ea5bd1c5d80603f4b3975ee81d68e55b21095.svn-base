/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午4:58
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.BaseComp.BaseGrid", {
    extend: 'Ext.grid.Panel',
    alias: 'widget.baseGrid',

    border:false,
    autoScroll: true,

    tbar: [
        {
            text: '新增',
            iconCls: 'add',
            action: 'Add'
        }
    ] ,
    initComponent:function(){
        this.bbar =Ext.create('Ext.PagingToolbar', {
            emptyMsg: '没有数据',
            store:this.store,
            displayInfo: true,
            displayMsg: '当前显示{0}-{1}条记录 / 共{2}条记录 ',
            beforePageText: '第',
            afterPageText: '页/共{0}页',
            nextText: '下一页',
            prevText: '上一页',
            lastText: '最后一页',
            firstText: '第一页',
            refreshText: '刷新'
        }) ;

        this.callParent();
    }
});