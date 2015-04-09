/**
 * Created by zyc on 2015/1/17.
 */
Ext.define('PMS.apps.GoodsApp.view.CategoryList', {
    extend:'Ext.tree.Panel',
    alias:'widget.goodsCategoryList',
    lines: true,

    layout:'fit',

    useArrows: true,
    autoScroll: true,

    viewConfig: {
        plugins: {
            ptype: 'treeviewdragdrop',
            pluginId:'dragTreePlugin',
            containerScroll: false
        }
    },
    selType: 'rowmodel',
    selModel: {
        mode: 'SINGLE'
    },
//    singleExpand: true,
    rootVisible: false,
    root: {

    },
    columns: [{
        xtype: 'treecolumn',
        text: '分类名称',
        flex: 1,
        sortable: true,
        dataIndex: 'name'
    },{
        text: '是否显示',
        width: 100,
        textAlign: 'center',
        dataIndex: 'enable',
        sortable: true,
        renderer: function(value){
            var r = Number(value);
            if(r == 0){
                return '显示';
            }else{
                return '不显示';
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
                    return !record.data.leaf;
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
                text:'添加子类别',
                iconCls:'add',
                action:'AddCategoryButton'
            },
            {
                xtype:'button',
                text:'删除类别',
                iconCls:'remove',
                hidden: true,
                action:'RemoveCategoryButton'
            },
            '->',
            {
                xtype:'label',
                text:'小提示：双击编辑该类别',
                height:18
            }
        ];
        //  调用父类的构造函数
        me.callParent(arguments);
    }
});