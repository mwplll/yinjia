/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.GoodsApp.controller.BrandController",{
    extend: 'Ext.app.Controller',
    models: [
         'PMS.apps.GoodsApp.model.BrandModel',
         'PMS.apps.GoodsApp.model.BrandSerialModel'
    ],
    stores: [
         'PMS.apps.GoodsApp.store.BrandStore'
    ],
    views: [
        'PMS.apps.GoodsApp.view.BrandList',
        'PMS.apps.GoodsApp.view.BrandWin'
    ],

    refs: [
        {
            selector: 'brandList',
            ref: 'brandList'
        },
        {
            selector: 'brandWin',
            ref: 'brandWin'
        },
        {
            selector: 'brandWin brandBaseForm',
            ref: 'brandBaseForm'
        },
        {
            selector: 'brandWin brandBaseForm [itemId=imageBoxWrap]',
            ref: 'imageBoxWrap'
        },
        {
            selector: 'brandWin brandBaseForm [itemId=brandSerials] grid',
            ref: 'brandSerialsGrid'
        }
    ],
    init: function(){
        console.log("BrandController init");

        this.control({
            'brandList':{
                afterrender: function(){
                    var me = this, grid = me.getBrandList(),
                        st = grid.getStore();
                    Ext.apply(st, {pageSize: 15});
                    st.loadPage(1);
                }
            },
            'brandList actioncolumn':{
                click: function(grid,cell,row,col,e,record){
                    var me = this;
                    var url = me.requestUrl['del'];
                    var className = e.getTarget().className;
                    if(className.indexOf("delete-col") >= 0){ //删除
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                Ext.AjaxUtil.getAction({
                                    url : url,
                                    data: {id: record.get("id")},
                                    callback:function(data){
                                        grid.getStore().reload();
                                        Ext.example.msg("", "操作成功!");
                                    }
                                });
                            }
                        });
                    }else if(className.indexOf("edit-col") >= 0){
                        coreApp.loadWorkPanel('brandWin','编辑品牌');
                        var imageBoxWrap = me.getImageBoxWrap(),
                            brandForm = me.getBrandBaseForm(),
                            imageBox = imageBoxWrap.queryById('imageBox');
                        if(record.get("logo")){
                            var src = image_base + record.get("logo");
                            Ext.ImgAdjustUtil.imgAdjust(src, 200, 200, function (h, w) {
                                imageBox.setSrc(src);
                                imageBox.setSize(w,h);
                                imageBox.el.dom.style.marginLeft = (200-w) / 2 + "px";
                                imageBox.el.dom.style.marginTop = (200-h) / 2 + "px";
                            });
                        }

                        brandForm.getForm().loadRecord(record);

                        var st = Ext.create("Ext.data.Store", {
                            model: 'PMS.apps.GoodsApp.model.BrandSerialModel',
                            data: record.get('seriesList')
                        });
                        var serialsList = me.getBrandSerialsGrid();
                        serialsList.bindStore(st);
                    }
                }
            },
            'brandWin':{
                afterrender: function(){
                    var me = this;
                    var serialsList = me.getBrandSerialsGrid();
                    serialsList.getStore().removeAll();
                }
            },
            "brandWin brandBaseForm button[itemId=uploadBrandButton]":{
                click: function(btn){
                    var me = this;
                    coreApp.fireEvent("UploadImage", {
                        targetCtr: me,
                        uploadUrl: me.requestUrl.uploadBrand
                    });
                }
            },
            "brandWin button[itemId=ReturnButton]":{
                click: function(){
                    var me = this;
                    coreApp.loadWorkPanel('brandList','品牌列表');
                }
            },
            "brandWin button[itemId=SaveButton]":{
                click: function(){
                    var me = this,
                        brandForm = me.getBrandBaseForm();
                    if(!brandForm.getForm().isValid()){
                        return;
                    }
                    var values = brandForm.getFormValues();

//                    if(!values.serialsList.length){
//                        Ext.example.msg("", "请填写系列名称！");
//                    }

                    var url = me.requestUrl['save'];
                    Ext.AjaxUtil.saveAction({
                        url : url,
                        data: values,
                        callback: function(re){
                            Ext.example.msg("", "操作成功!");
                            coreApp.loadWorkPanel( 'brandList','品牌列表');
                        }
                    });
                }
            }
        });

        // 自定义事件 监听图片上传完成
        this.on({
            AfterImageUpload: function (data) {
                var me = this;
                var imageBoxWrap = me.getImageBoxWrap(),
                    brandForm = me.getBrandBaseForm(),
                    imageBox = imageBoxWrap.queryById('imageBox'),
                    picTextField = brandForm.queryById('picTextField');

                picTextField.setValue(data.serial);
                var src = image_base + data.serial;

                Ext.ImgAdjustUtil.imgAdjust(src, 200, 200, function (h, w) {
                    imageBox.setSrc(src);
                    imageBox.setSize(w,h);
                    imageBox.el.dom.style.marginLeft = (200-w) / 2 + "px";
                    imageBox.el.dom.style.marginTop = (200-h) / 2 + "px";
                });
            }
        });
    },

    requestUrl: {
        uploadBrand: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=brand_logo",
        list: dev_base + 'data/brand/list?_dt=' + Math.random(),
        del:  dev_base + 'data/brand/edit?act=delete&_dt=' + Math.random(),
        save:  dev_base + 'data/brand/edit?act=save&_dt=' + Math.random(),
        sort:  dev_base + 'data/brand/edit?act=sort&_dt=' + Math.random()
    }
});