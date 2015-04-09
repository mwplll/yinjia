/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.HouseApp.controller.HouseController",{
    extend: 'Ext.app.Controller',

    requires: [
        'Ext.base.AddressData'
    ],

    models: [
        'PMS.apps.HouseApp.model.HouseModel',
        'PMS.apps.BuildingApp.model.AddressModel',
        'PMS.apps.BuildingApp.model.BuildingModel',
        'PMS.apps.HouseApp.model.HouseRoomModel'
    ],
    stores: [
        'PMS.apps.HouseApp.store.HouseStore',
        'PMS.apps.HouseApp.store.BuildingStore'
    ],
    views: [
        'PMS.apps.HouseApp.view.HouseGrid',
        'PMS.apps.HouseApp.view.HouseWin'
    ],

    refs: [
        {
            selector: 'houseGrid',
            ref: 'houseGrid'
        },
        {
            selector: 'houseWin',
            ref: 'houseWin'
        },
        {
            selector: 'houseWin houseBaseForm',
            ref: 'houseBaseForm'
        },
        {
            selector: 'houseWin houseBaseForm [itemId=imageBoxWrap]',
            ref: 'imageBoxWrap'
        },
        {
            selector: 'houseWin houseBaseForm [itemId=cityCombo]',
            ref: 'cityCombo'
        },
        {
            selector: 'houseWin houseBaseForm [itemId=areaCombo]',
            ref: 'areaCombo'
        },
        {
            selector: 'houseGrid combo[itemId=SearchCityCombo]',
            ref: 'searchCityCombo'
        },
        {
            selector: 'houseGrid combo[itemId=SearchAreaCombo]',
            ref: 'searchAreaCombo'
        },
        {
            selector: 'houseGrid combo[itemId=SearchBuildingCombo]',
            ref: 'searchBuildingCombo'
        },
        {
            selector: 'appPanel centerPanel',
            ref: 'centerPanel'
        }
    ],

    address: null,

    init: function(){
        console.log("HouseController init");

        // 初始化 address
        this.address = new Ext.base.AddressData();
        this.control({
            "houseGrid": {
                afterrender: function(){
                    var me = this;
                    // 浙江省 id
                    var default_id = '330000';
                    var cities = me.address.filterDataByParent(me.address.city_cn_data, default_id);
                    var store = Ext.create("Ext.data.Store",{
                        model: 'PMS.apps.BuildingApp.model.AddressModel',
                        data: cities
                    });
                    me.getSearchCityCombo().bindStore(store);

                    // store中绑定type参数
                    var st = me.getHouseGrid().getStore();
                    st.loadPage(1);
                },
                itemdblclick: function(grid, record){
                    this.editHandler(grid, record);
                }
            },

            'houseGrid actioncolumn':{
                editHandler: function(type, grid, record){
                    var me = this;
                    var enable_id = {
                        del: 1,
                        up: 0,
                        down: 2
                    };
                    if(type == 'edit'){
                        me.editHandler(grid, record);
                    }else if(type == 'del'){
                        Ext.Msg.confirm('删除', "确认删除？", function(btn){
                            if(btn == 'yes'){
                                action(type)
                            }
                        });
                    }else{
                        action(type)
                    }

                    function action(t){
                        Ext.AjaxUtil.getAction({
                            url : me.requestUrl['updateState'],
                            data: {state: enable_id[t], id: record.get("id")},
                            callback:function(data){
                                grid.getStore().reload();
                                Ext.example.msg("", "操作成功!");
                            }
                        });
                    }
                }
            },

            "houseGrid combo[itemId=SearchCityCombo]":{
                change: function(combo){
                    var me = this;
                    var value = combo.getValue();
                    var areas = me.address.filterDataByParent(me.address.city_cn_data, value);
                    var store = Ext.create("Ext.data.Store",{
                        model: 'PMS.apps.BuildingApp.model.AddressModel',
                        data: areas
                    });
                    me.getSearchAreaCombo().bindStore(store);
                    me.getSearchAreaCombo().setValue('');
                }
            },
            "houseGrid combo[itemId=SearchAreaCombo]":{
                change: function(combo){
                    var me = this;
                    var value = combo.getValue();

                    Ext.AjaxUtil.getAction({
                        url: me.requestUrl['searchBuildingByArea'],
                        data: {
                            areaId: value,
                            cityId: me.getSearchCityCombo().getValue()
                        },
                        callback: function (result) {
                            var store = Ext.create("Ext.data.Store",{
                                model: 'PMS.apps.BuildingApp.model.BuildingModel',
                                data: result.data.buildingList
                            });

                            var buildCombo = me.getSearchBuildingCombo();

                            buildCombo.setValue('');
                            buildCombo.bindStore(store);
                        }
                    });
                }
            },

            // 条件 筛选
            "houseGrid button[itemId=FilterButton]":{
                click: function(){
                    var me = this,
                        grid = me.getHouseGrid(),
                        store = grid.getStore(),
                        city_id = me.getSearchCityCombo().getValue(),
                        build_id = me.getSearchBuildingCombo().getValue(),
                        area_id = me.getSearchAreaCombo().getValue();
                    var pd = {};
                    if(city_id !== ''&& city_id !== undefined&& city_id !== null){
                        pd['cityId'] = Number(city_id);
                    }
                    if(area_id !== ''&& area_id !== undefined && area_id !== null){
                        pd['areaId'] = Number(area_id);
                    }
                    if(build_id !== ''&& build_id !== undefined && build_id !== null){
                        pd['buildingId'] = Number(build_id);
                    }
                    pd['states[]'] = [0,2];
                    console.log("condition:");
                    console.log(pd);
                    store.proxy.extraParams = pd;
                    store.loadPage(1);
                }
            },

            "houseWin":{
                afterrender: function(){
                    var me = this;

                    // 初始化 address
                    me.address = new Ext.base.AddressData();
                    me.initAddress();
                }
            },
            "houseWin combo[itemId=cityCombo]":{
                change: function(combo){
                    var me = this;
                    var value = combo.getValue();
                    var areas = me.address.filterDataByParent(me.address.city_cn_data, value);
                    var store = Ext.create("Ext.data.Store",{
                        model: 'PMS.apps.BuildingApp.model.AddressModel',
                        data: areas
                    });
                    me.getAreaCombo().bindStore(store);
                }
            },
            "houseWin combo[itemId=areaCombo]":{
                change: function(combo){
                    var me = this,
                        value = combo.getValue(),
                        baseForm = me.getHouseBaseForm();
                    var buildCombo = baseForm.queryById('buildingCombo'),
                        st = buildCombo.getStore();
                    Ext.apply(st.proxy,{
                        extraParams: {
                            areaId: value,
                            cityId: me.getCityCombo().getValue()
                        }
                    });
                    st.load();
                    if(me.firstRender){
                        me.firstRender = false;
                        if(me.record){
                            buildCombo.setValue(me.record.get("buildingId"));
                        }
                    }else{
                        buildCombo.setValue('');
                    }
                }
            },
            "houseWin houseBaseForm button[itemId=uploadHouseButton]":{
                click: function(btn){
                    var me = this;
                    coreApp.fireEvent("UploadHouse", {
                        targetCtr: me,
                        uploadUrl: me.requestUrl.uploadHouse
                    });
                }
            },
            "houseWin button[itemId=ReturnButton]":{
                click: function(){
                    var me = this;
                    coreApp.loadWorkPanel( 'houseGrid','户型列表');
                }
            },
            "houseWin button[itemId=SaveButton]":{
                click: function(){
                    var me = this,
                        houseForm = me.getHouseBaseForm();
                    var values = houseForm.getFormValues();
                    if(!values.pic){
                        Ext.example.msg("", "请上传户型图!");
                        return
                    }
                    if(!houseForm.getForm().isValid()){
                        return;
                    }

                    var url = me.requestUrl['add'];
                    if(values['id']){
                        url = me.requestUrl['update']
                    }
                    Ext.AjaxUtil.saveAction({
                        url : url,
                        data: values,
                        callback: function(re){
                            Ext.example.msg("", "操作成功!");
                            coreApp.loadWorkPanel( 'houseGrid','户型列表');
                            me.getHouseGrid().getStore().loadPage(1);
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
                    houseForm = me.getHouseBaseForm(),
                    imageBox = imageBoxWrap.queryById('imageBox'),
                    picTextField = houseForm.queryById('picTextField');

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
    initAddress: function(callback){
        var me = this;

        // 浙江省 id
        var default_id = '330000';
        var cities = me.address.filterDataByParent(me.address.city_cn_data, default_id);
        var store = Ext.create("Ext.data.Store",{
            model: 'PMS.apps.BuildingApp.model.AddressModel',
            data: cities
        });
        me.getCityCombo().bindStore(store);
        if(callback){
            callback();
        }
    },

    firstRender: true,
    record: null,
    editHandler: function(grid, record){
        var me = this;
        coreApp.loadWorkPanel( 'houseWin','编辑户型');

        var imageBoxWrap = me.getImageBoxWrap(),
            houseForm = me.getHouseBaseForm(),
            imageBox = imageBoxWrap.queryById('imageBox'),
            houseRoomsGrid = houseForm.queryById('houseRoomsGrid');

        var src = image_base + record.get("pic");

        me.firstRender = true;
        me.record = record;
        Ext.ImgAdjustUtil.imgAdjust(src, 200, 200, function (h, w) {
            imageBox.setSrc(src);
            imageBox.setSize(w,h);
            imageBox.el.dom.style.marginLeft = (200-w) / 2 + "px";
            imageBox.el.dom.style.marginTop = (200-h) / 2 + "px";
        });
        houseForm.getForm().loadRecord(record);
    },

    requestUrl: {
        uploadHouse: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=house_type",
        add:  dev_base + 'data/house/edit?act=add&_dt=' + Math.random(),
        update:  dev_base + 'data/house/edit?act=update&_dt=' + Math.random(),
        detail: dev_base + 'data/house/info?_dt=' + Math.random(),
        updateState: dev_base + 'data/house/edit?act=del&_dt=' + Math.random(),
        list: dev_base + 'data/house/list',
        searchBuildingByArea: dev_base + 'data/building/list' + '?_dt=' + Math.random()
    }
});