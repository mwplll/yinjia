/**
 * Created by zyc on 2015/1/17.
 */
Ext.define('PMS.apps.DesignApp.view.DesignStyleList', {
    extend:'Ext.tree.Panel',
    alias:'widget.designStyleList',
    lines: true,

    layout:'fit',

    useArrows: true,
    autoScroll: true,

//    viewConfig: {
//        plugins: {
//            ptype: 'treeviewdragdrop',
//            pluginId:'dragTreePlugin',
//            containerScroll: false
//        }
//    },
    selType: 'rowmodel',
    selModel: {
        mode: 'SINGLE'
    },
    singleExpand: false,
    rootVisible: false,
    root: {

    },
    columns: [{
        xtype: 'treecolumn',
        text: '施工风格名称',
        flex: 1,
        sortable: true,
        dataIndex: 'name'
    },{
        text: '价格',
        width: 100,
        textAlign: 'center',
        dataIndex: 'price',
        sortable: false,
        renderer: function(value, _d, record){
            if(!record.data.leaf){
                return '总价：' + value;
            }else{
                return value;
            }
        }
    }, {
        text: '操作',
        flex:1,
        menuDisabled: true,
        xtype: 'actioncolumn',
        tooltip: '操作',
        align: 'center',
        items: [
            {
                iconCls: 'edit-col',
                tooltip: '编辑'
            },
            {
                iconCls: 'delete-col',
                tooltip: '删除',
                isDisabled: function(view, rowIdx, colIdx, item, record) {
                    return record.data.leaf;
                }
            }
        ]
    }],
    initComponent:function () {
        var me = this;
        me.tbar = [
            {
                xtype:'button',
                text: '展开所有',
                iconCls:'add',
                action: 'ExpendButton'
            },
            {
                xtype:'button',
                text: '收起所有',
                iconCls:'remove',
                action: 'CollapseButton'
            },
            {
                xtype:'button',
                text:'添加风格',
                iconCls:'add',
                action:'AddStyleButton'
            },
            {
                xtype:'button',
                text:'删除风格',
                iconCls:'remove',
                hidden: true,
                action:'RemoveStyleButton'
            },
            '->',
            {
                xtype:'label',
                text:'小提示：双击编辑',
                height:18
            }
        ];
        //  调用父类的构造函数
        me.callParent(arguments);
    }
});