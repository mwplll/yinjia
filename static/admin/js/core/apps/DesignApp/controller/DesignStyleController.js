/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.DesignApp.controller.DesignStyleController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.DesignApp.model.DesignStyleModel'
    ],
    stores: [

    ],
    views: [
        'PMS.apps.DesignApp.view.DesignStyleList',
        'PMS.apps.DesignApp.view.DesignStyleWin'
    ],

    refs: [
        {
            selector: 'designStyleList',
            ref: 'designStyleList'
        },
        {
            selector: 'designStyleWin',
            ref: 'designStyleWin'
        },
        {
            selector: 'designStyleWin form',
            ref: 'designStyleAddForm'
        },
        {
            selector: 'designStyleWin button[action=SaveUpdateButton]',
            ref: 'saveUpdateButton'
        },
        {
            selector: 'designStyleList button[action=AddStyleButton]',
            ref: 'addStyleButton'
        }
    ],
    init: function(){
        console.log("DesignStyleController init");
        this.control({
            'designStyleList':{
                afterrender: function(){
                    var me = this;
                    me.initTreeGrid();
                }
            },

            'designStyleList button[action=AddStyleButton]':{
                click: function(){
                    var me = this;
                    var selection = me.getDesignStyleList().getSelectionModel().getSelection(),
                        name, parentId;
                    Ext.widget('designStyleWin');

                    me.getSaveUpdateButton().show();
                    var form = me.getDesignStyleAddForm();
                    form.queryById("priceField").hide();
                    form.queryById("styleName").hide();

                }
            },
            'designStyleList button[action=ExpendButton]':{
                click: function(){
                    var me = this;
                    me.expendAction('expend');
                }
            },
            'designStyleList button[action=CollapseButton]':{
                click: function(){
                    var me = this;
                    me.expendAction('collapse');
                }
            },
            'designStyleList button[action=RemoveCategoryButton]':{
                click: function(){
                    var me = this,
                        tree = me.getDesignStyleList(),
                        selections = tree.getSelectionModel().getSelection();
                    if(!selections.length){
                        Ext.example.msg("提示", '请先选择要删除的类别!');
                        return;
                    }
                    me.removeCategoryAction(selections[0]);
                }
            },
            'designStyleList actioncolumn':{
                click: function(grid, rowIndex, colIndex, actionItem, event, record){
                    var me = this;
                    var className = event.getTarget().className;
                    if(className.indexOf("delete-col") >= 0){ //删除
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                me.removeCategoryAction(record);
                            }
                        });
                    }else if(className.indexOf("edit-col") >= 0){
                        Ext.widget('designStyleWin');

                        var form = me.getDesignStyleAddForm();

                        form.getForm().loadRecord(record);
                        me.getSaveUpdateButton().show();

                        if(!record.get("leaf")){
                            form.queryById("priceField").hide();
                            form.queryById("styleName").hide();
                        }else{
                            form.queryById("styleName").show();
                            form.queryById("nameField").setDisabled(true);
                            form.queryById("nameField").setLabel("项目名称");
                            form.queryById("priceField").show();
                        }

                        me.getDesignStyleWin().setTitle("编辑");
                    }

                }
            },
            'designStyleWin button[action=SaveUpdateButton]': {
                click: function(){
                    var me = this;
                    me.saveAction('update');
                }
            }
        });
    },
    initTreeGrid: function(){
        var me = this;
        me.getAddStyleButton().show();
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.list,
            callback: function(result){
                // 准备构造树结构
                var tp = [], st = {};
                Ext.each(result.data, function(item){
                    item.text = item.name;
                    item.leaf = true;
                    if(st[item.styleId]){
                        if(st[item.styleId].children){
                            st[item.styleId].children.push(item);
                            st[item.styleId].price += Number(item.price);
                        }else{
                            st[item.styleId].children = [item];
                            st[item.styleId].price = Number(item.price);
                        }
                    }else{
                        st[item.styleId] = {
                            styleId: item.styleId,
                            name: item.styleName,
                            text: item.styleName,
                            leaf: false,
                            price: Number(item.price),
                            children: [item]
                        };
                    }
                });
                for(var key in st){
                    tp.push(st[key]);
                }
                if(tp.length){
                    var store = Ext.create("Ext.data.TreeStore", {
                        extend: 'Ext.data.TreeStore',
                        model: 'PMS.apps.DesignApp.model.DesignStyleModel',
                        root: {
                            expended: true,
                            text:  '根目录',
                            categoryId:0,
                            children: tp
                        }
                    });
                    me.getDesignStyleList().bindStore(store);
                    me.getDesignStyleList().expandAll();
                }
            }
        });
    },


    // 展开 收起
    expendAction: function(action){
        var me = this,
            tree = me.getDesignStyleList();
        if(action == 'expend'){
            tree.expandAll();
        }else{
            tree.collapseAll();
        }
    },

    // 添加 编辑子类别
    saveAction: function(action){
        var me = this,
            tree = me.getDesignStyleList(),
            form = me.getDesignStyleAddForm(),
            values = form.getValues(),
            postData = {
                id: values.styleId
            };
        if(!values.styleId){
            // 新增
            if(!values.text){
                Ext.example.msg("提示", '请输入风格名称!');
                return;
            }
            postData = {
                name: values.text,
                manualList: [
//                    {manualName: '水电基础装饰部分', price: 0},
//                    {manualName: '泥水基础装饰部分', price: 0},
//                    {manualName: '木作基础装饰部分', price: 0},
//                    {manualName: '油漆基础装饰部分', price: 0},
//                    {manualName: '其他杂项(搬运、清理、打扫)', price: 0}
                    {manualName: '施工费', price: 550}
                ]
            };
            Ext.AjaxUtil.saveAction({
                url: me.requestUrl.add,
                data: postData,
                callback: function(result){
                    me.initTreeGrid();
                    me.getDesignStyleWin() && me.getDesignStyleWin().close();
                }
            });
            return;
        }
        if(values.leaf == 'false'){
            postData['name'] = values.text;
        }else{
            postData['name'] = form.queryById("styleName").getValue();
            postData['manualList'] = [{
                manualId: values.id,
                manualName: form.queryById("nameField").getValue(),
                price: values.price
            }]
        }

        Ext.AjaxUtil.saveAction({
            url: me.requestUrl.save,
            data: postData,
            callback: function(result){
                me.initTreeGrid();
                me.getDesignStyleWin() && me.getDesignStyleWin().close();
            }
        });
    },

    // 删除类别
    removeCategoryAction: function(record){
        var me = this, id = record.raw.styleId;

        var url = me.requestUrl.del;
        if(record.data.leaf){
            url = me.requestUrl.del2;
            id = record.raw.id;
        }
        Ext.AjaxUtil.getAction({
            url: url,
            data: {id: id},
            callback: function(result){
                me.initTreeGrid();
            }
        });
    },
    requestUrl: {
        del: dev_base + 'data/design/manual/edit?act=del&_dt=' + Math.random(),
        del2: dev_base + 'data/design/manual/edit?act=delManual&_dt=' + Math.random(),
        save: dev_base + 'data/design/manual/edit?act=update&_dt=' + Math.random(),
        add: dev_base + 'data/design/manual/edit?act=add&_dt=' + Math.random(),
        list:  dev_base + 'data/admin/design/manual/list?_dt=' + Math.random()
    }
});