/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.GoodsApp.controller.SkuController",{
    extend: 'Ext.app.Controller',
    models: [
         'PMS.apps.GoodsApp.model.SkuModel',
         'PMS.apps.GoodsApp.model.SkuItemModel'
    ],
    stores: [
         'PMS.apps.GoodsApp.store.SkuStore'
    ],
    views: [
        'PMS.apps.GoodsApp.view.SkuList',
        'PMS.apps.GoodsApp.view.SkuWin'
    ],

    refs: [
        {
            selector: 'goodsSkuWin',
            ref: 'goodsSkuWin'
        },
        {
            selector: 'skuList',
            ref: 'skuList'
        },
        {
            selector: 'skuWin',
            ref: 'skuWin'
        },
        {
            selector: 'skuWin skuBaseForm',
            ref: 'skuBaseForm'
        },
        {
            selector: 'skuWin skuBaseForm skuItem grid[itemId=skuItemImageGrid]',
            ref: 'skuItemImageGrid'
        }
    ],
    init: function(){
        console.log("SkuController init");

        this.control({
            "skuList":{
                afterrender: function(){
                    var me = this,
                        grid = me.getSkuList(),
                        st = grid.getStore();
                    Ext.apply(st,{ pageSize: 15});
                    st.loadPage(1);
                },
                itemdblclick: function(grid, record){
                    var me = this;
                    Ext.widget("skuWin", {
                        title: '编辑规格'
                    });
                    Ext.AjaxUtil.getAction({
                        url : me.requestUrl['detail'],
                        data: {id: record.get('id')},
                        callback:function(result){
                            var re = Ext.create('PMS.apps.GoodsApp.model.SkuModel', result.data);
                            me.getSkuBaseForm().setFormValues(re);
                        }
                    });
                }
            },
            "skuList button[itemId=AddButton]": {
                click: function(grid, record){
                    var me = this;
                    Ext.widget("skuWin");
                    me.getSkuBaseForm().setFormValues(null);
                }
            },
            "skuList button[itemId=RemoveAllButton]": {
                click: function(){
                    var me = this,
                        grid = me.getSkuList();
                    var selection = grid.getSelectionModel().getSelection();
                    if(!selection.length){
                        Ext.example.msg("", "请先选择要删除的数据");
                        return;
                    }
                    var ids = [];
                    Ext.each(selection, function(el){
                        ids.push(el.get('id'));
                    });
                    Ext.AjaxUtil.getAction({
                        url : me.requestUrl['del'],
                        data: {ids: "[" + ids.toString() + "]"},
                        callback:function(data){
                            grid.getStore().reload();
                            Ext.example.msg("", "操作成功!");
                        }
                    });
                }
            },

            "skuList actioncolumn":{
                editHandler: function(grid, record){
                    Ext.widget("skuWin", {
                        title: '编辑规格'
                    });
                    var me = this;
                    Ext.AjaxUtil.getAction({
                        url : me.requestUrl['detail'],
                        data: {id: record.get('id')},
                        callback:function(result){
                            var re = Ext.create('PMS.apps.GoodsApp.model.SkuModel', result.data);
                            me.getSkuBaseForm().setFormValues(re);
                        }
                    });
                },

                delHandler: function(grid, record){
                    var me = this;
                    Ext.Msg.confirm('删除', "确认删除？", function(btn){
                        if(btn == 'yes'){
                            Ext.AjaxUtil.getAction({
                                url : me.requestUrl['del'],
                                data: {ids: "[" + record.get("id")+ "]"},
                                callback:function(data){
                                    grid.getStore().reload();
                                    Ext.example.msg("", "操作成功!");
                                }
                            });
                        }
                    });
                }
            },
            "skuWin button[itemId=SaveButton]": {
                click: function(){
                    var me = this,
                        form = me.getSkuBaseForm();
                    if(!form.getForm().isValid()){
                        return;
                    }
                    var values = form.getFormValues();
                    if(values.error){
                        Ext.example.msg("", values.error);
                        return;
                    }
                    var url = me.requestUrl['save'];
                    Ext.AjaxUtil.saveAction({
                        url : url,
                        data: values,
                        callback: function(re){
                            Ext.example.msg("", "操作成功!");
                            me.getSkuWin().close();
                            Ext.getStore("PMS.apps.GoodsApp.store.SkuStore").reload();
                            var goodsSkuWin = me.getGoodsSkuWin();
                            if(!goodsSkuWin || !values.id){
                                return;
                            }else{
                                var ctr = coreApp.getController("PMS.apps.GoodsApp.controller.GoodsWinController");
                                ctr.resetSkuPanel(values);
                            }
                        }
                    });
                }
            },

            "skuWin skuBaseForm skuItem grid[itemId=skuItemImageGrid] actioncolumn[dataIndex=thumbUrl]":{
                click: function(grid,cell,row,col,e,record){
                    var me = this;
                    var className = e.getTarget().className;
                    if(className.indexOf("selectImageButton") >= 0){
                        me._selectIndex = row;
                        coreApp.fireEvent("UploadImage", {
                            targetCtr: me,
                            uploadUrl: dev_base + 'data/image/upload?type=spec&_dt=' + Math.random()
                        });
                    }
                }
            }
        });

        // 自定义事件 监听图片上传完成
        this.on({
            AfterImageUpload: function (data) {
                var me = this,
                    grid = me.getSkuItemImageGrid(),
                    store = grid.getStore(),
                    record = store.getAt(me._selectIndex);
                record.set("serial", data.serial);

                var url = image_base + data.serial,
                    img = "<img src='"+ url+ "' height='40px'>";
                record.set("thumbUrl", img);
            }
        });
    },

    // 上传规格图片 记录record index
    _selectIndex: -1,

    requestUrl: {
        save:  dev_base + 'data/spec/edit?act=save&_dt=' + Math.random(),
        list: dev_base + 'data/spec/list?_dt=' + Math.random(),
        del: dev_base + 'data/spec/edit?act=delete&_dt=' + Math.random(),
        detail: dev_base + 'data/spec/info?_dt=' + Math.random()
    }
});