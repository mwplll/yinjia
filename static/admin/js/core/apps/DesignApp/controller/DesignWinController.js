/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.DesignApp.controller.DesignWinController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.DesignApp.model.DesignRoomModel',
        'PMS.apps.DesignApp.model.DesignMaterialManuModel',
        'PMS.apps.DesignApp.model.DesignMaterialGridModel',
        'PMS.apps.DesignApp.model.DesignModel',
        'PMS.apps.HouseApp.model.HouseModel'
    ],
    stores: [
        'PMS.apps.DesignApp.store.DesignRoomStore'
    ],

    views: [
        'PMS.apps.DesignApp.view.DesignWin',
        'PMS.apps.DesignApp.view.AuditWin'
    ],
    refs: [
        {
            selector: 'designWin',
            ref: 'designWin'
        },
        {
            selector: 'designWin tabpanel designBaseForm',
            ref: 'designBaseForm'
        },
        {
            selector: 'designWin tabpanel designBaseForm [itemId=designImageBoxWrap]',
            ref: 'designImageBoxWrap'
        },
        {
            selector: 'designWin tabpanel designBaseForm [itemId=houseImageBoxWrap]',
            ref: 'houseImageBoxWrap'
        },
        {
            selector: 'designWin tabpanel designRooms',
            ref: 'designRoomsGrid'
        },
        {
            selector: 'designWin tabpanel cadRooms grid',
            ref: 'designCadGrid'
        },
        {
            selector: 'designWin tabpanel cadRooms #cadFile',
            ref: 'designCadFile'
        },
        {
            selector: 'designWin tabpanel materialRooms',
            ref: 'materialRooms'
        },
        {
            selector: 'designWin tabpanel materialRooms #materialManuGrid',
            ref: 'materialManuGrid'
        },
        {
            selector: 'designWin tabpanel designBaseForm [itemId=houseBaseForm]',
            ref: 'houseBaseForm'
        },
        {
            selector: 'designWin tabpanel designBaseForm [itemId=detailBaseForm]',
            ref: 'detailBaseForm'
        },
        {
            selector: 'designGrid',
            ref: 'designGrid'
        },
        {
            selector: 'auditWin',
            ref: 'auditWin'
        },
        {
            selector: 'auditWin form',
            ref: 'auditWinForm'
        }
    ],

    record: null,
    cityId: null,
    house_area: null,

    init: function(){
        console.log("DesignWinController init");

        this.control({
            "designWin tabpanel materialRooms": {
                activate: function(tab){
                    var me = this;
                    if(tab.index == 3 && !tab.inited){
                        me.setMaterialValues(me.record);
                        tab.inited = true;
                    }
                }
            },
            "designWin button[itemId=FailButton]":{
                click: function(){
                    Ext.widget("auditWin");
                    var me = this,
                        form = me.getAuditWinForm();

                    form.queryById("id").setValue(me.record.get('id'));
                    form.queryById("reason").setValue('');
                }
            },
            "designWin button[itemId=SuccessButton]":{
                click: function(){
                    var me = this;
                    var pd = {
                        id: me.record.get('id'),
                        isCheck: 1
                    };
                    Ext.AjaxUtil.saveAction({
                        url : me.requestUrl['audit'],
                        data: pd,
                        callback:function(data){
                            me.getAuditWin()&&me.getAuditWin().close();
                            me.getDesignWin().close();
                            var grid = me.getDesignGrid();
                            grid.getStore().reload();
                            Ext.example.msg("", "操作成功!");
                        }
                    });
                }
            },
            "designWin cadRooms button[itemId=LinkButton]":{
                click: function(){
                    var me = this;
                    var v = me.getDesignCadFile().getValue();
                    if(!v){
                        return;
                    }
                    location.href = linkBase + v;
                }
            },

            "auditWin button[itemId=SaveButton']":{
                click: function(){
                    var me = this,
                        form = me.getAuditWinForm(),
                        values = form.getValues();
                    if(form.isValid()){
                        Ext.AjaxUtil.saveAction({
                            url : me.requestUrl['audit'],
                            data: values,
                            callback:function(data){
                                me.getAuditWin() &&  me.getAuditWin().close();
                                me.getDesignWin().close();
                                var grid = me.getDesignGrid();
                                grid.getStore().reload();
                                Ext.example.msg("", "操作成功!");
                            }
                        });
                    }
                }
            }
        });
    },

    doInitial: function(record){
        var me = this;

        me.record = record;
        Ext.widget("designWin",{
            title: '方案详情'
        });

        me.setBaseValues(record);
        me.setRoomValues(record);
        me.setCadValues(record);
//        me.setMaterialValues(record);
    },

    // 基本信息
    setBaseValues: function(record){
        var me = this;
        var houseImageBoxWrap = me.getHouseImageBoxWrap(),
            designImageBoxWrap = me.getDesignImageBoxWrap(),
            designForm = me.getDesignBaseForm(),
            houseImageBox = houseImageBoxWrap.queryById('houseImageBox'),
            designImageBox = designImageBoxWrap.queryById('designImageBox'),
            designRoomsGrid = designForm.queryById('designRoomsGrid');

        var src = image_base +  record.get("mainPic");

        Ext.ImgAdjustUtil.imgAdjust(src, 200, 200, function (h, w) {
            designImageBox.setSrc(src);
            designImageBox.setSize(w,h);
            designImageBox.el.dom.style.marginLeft = (200-w) / 2 + "px";
            designImageBox.el.dom.style.marginTop = (200-h) / 2 + "px";
        });
//        designForm.getForm().loadRecord(record);

        Ext.AjaxUtil.getAction({
            url: me.requestUrl.houseDetail,
            data: {id: record.get('houseType').id},
            callback: function(result){
                var re = Ext.create("PMS.apps.HouseApp.model.HouseModel", result.data);

                var src_house = image_base + re.data.pic + THUMB_SIZE['thumb'];
                Ext.ImgAdjustUtil.imgAdjust(src_house, 200, 200, function (h, w) {
                    houseImageBox.setSrc(src_house);
                    houseImageBox.setSize(w,h);
                    houseImageBox.el.dom.style.marginLeft = (200-w) / 2 + "px";
                    houseImageBox.el.dom.style.marginTop = (200-h) / 2 + "px";
                });

                me.getHouseBaseForm().getForm().loadRecord(re);

                me.house_area = result.data.grossArea;
                me.cityId = result.data.cityId;
            }
        });
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.detailBase,
            data: {id: record.get('id')},
            callback: function(result){
                var re = Ext.create("PMS.apps.DesignApp.model.DesignModel", result.data);
                re.set("totalPrice", record.get("totalPrice"));
                me.getDetailBaseForm().getForm().loadRecord(re);
            }
        });
    },

    // 房间信息
    setRoomValues: function(record){
        var me = this;
        var st = Ext.getStore("PMS.apps.DesignApp.store.DesignRoomStore");
        st.proxy.extraParams = {
            id: record.get('id')
        };
        st.load();
        me.getDesignRoomsGrid().bindStore(st);
    },
    // 施工图信息
    setCadValues: function(record){
        var me = this;
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.cadDetail,
            data: {id: record.get('id')},
            callback: function(result){
                var st = Ext.create("Ext.data.Store",{
                    model: 'PMS.apps.DesignApp.model.DesignRoomModel',
                    data: result.data.picList
                });

                me.getDesignCadGrid().bindStore(st);
                me.getDesignCadFile().setValue(result.data.file);
            }
        });
    },
    // 建材信息
    setMaterialValues: function(record){
        var me = this;
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.manuDetail,
            data: {id: record.get('id')},
            callback: function(result){
                Ext.each(result.data, function(item){
                    item.manual_num = me.house_area;
                });
                var st = Ext.create("Ext.data.Store",{
                    model: 'PMS.apps.DesignApp.model.DesignMaterialManuModel',
                    data: result.data
                });
                me.getMaterialManuGrid().bindStore(st);
            }
        });
        Ext.AjaxUtil.getAction({
            url: me.requestUrl.materialDetail,
            data: {id: record.get('id') || 1},
            callback: function(result){
                var tp = [];
                Ext.each(result.data, function(item){

                    var st = Ext.create("Ext.data.Store",{
                        model: 'PMS.apps.DesignApp.model.DesignMaterialGridModel',
                        data: item.materialList
                    });

                    var total = 0, unitPrice = 0;
                    st.each(function(rec){
                        total += rec.get("totalPrice");
                    });
                    total = Number(total.toFixed(2));
                    unitPrice = Number((total / item.roomArea).toFixed(2));

                    var materialGrid = Ext.widget("materialGrid",{
                        title: item.roomName
                    });
                    materialGrid.queryById('materialList').bindStore(st);
                    materialGrid.queryById('roomArea').setValue(item.roomArea);
                    materialGrid.queryById('unitPrice').setValue(unitPrice);
                    materialGrid.queryById('totalPrice').setValue(total);

                    tp.push(materialGrid);
                });
                me.getMaterialRooms().add(tp);
            }
        });
    },

    requestUrl: {
        del: dev_base + 'data/admin/design/schema/edit?act=del&_dt=' + Math.random(),
        audit: dev_base + 'data/admin/design/schema/edit?act=check&_dt='+ Math.random(),
        detail: dev_base + 'data/design/details?_dt=' + Math.random(),

        list: 'data/admin/design/schema/list?_dt=' + Math.random(),

        detailBase: dev_base + 'data/design/base/info?_dt=' + Math.random(),
        houseDetail: dev_base + '/data/house/info?_dt=' + Math.random(),
        cadDetail: dev_base + '/data/design/cad/info?_dt=' + Math.random(),
        manuDetail: dev_base + '/data/design/manual/info?_dt=' + Math.random(),
        materialDetail: dev_base + '/data/design/material/info?_dt=' + Math.random()
    }
});