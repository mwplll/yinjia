/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.BuildingApp.controller.BuildingController",{
    extend: 'Ext.app.Controller',

    requires: [
        'Ext.base.AddressData'
    ],

    models: [
        'PMS.apps.BuildingApp.model.BuildingModel',
        'PMS.apps.BuildingApp.model.AddressModel'
    ],
    stores: [
        'PMS.apps.BuildingApp.store.BuildingStore'
    ],
    views: [
        'PMS.apps.BuildingApp.view.BuildingGrid',
        'PMS.apps.BuildingApp.view.BuildingWin'
    ],

    refs: [
        {
            selector: 'buildingGrid',
            ref: 'buildingGrid'
        },
        {
            selector: 'buildingWin',
            ref: 'buildingWin'           
        },
        {
            selector: 'buildingWin buildingBaseForm',
            ref: 'buildingBaseForm'            
        },
        {
            selector: 'buildingGrid combo[itemId=SearchCityCombo]',
            ref: 'searchCityCombo'
        },
        {
            selector: 'buildingGrid combo[itemId=SearchAreaCombo]',
            ref: 'searchAreaCombo'
        },
        {
            selector: 'buildingBaseForm combo[itemId=cityCombo]',
            ref: 'cityCombo'
        },
        {
            selector: 'buildingBaseForm combo[itemId=areaCombo]',
            ref: 'areaCombo'
        }
    ],
    address: null,

    init: function(){
        console.log("BuildingController init");

        // 初始化 address
        this.address = new Ext.base.AddressData();

        this.control({
            "buildingGrid": {
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
                },

                itemdblclick: function(grid, record){
                    var me = this;
                    Ext.widget("buildingWin",{
                        title: '编辑楼盘'
                    });

                    var buildingForm = me.getBuildingBaseForm();
                    buildingForm.getForm().loadRecord(record);

                }
            },
            "buildingGrid actioncolumn":{
                editHandler: function(grid, record){
                    var me = this;
                    Ext.widget("buildingWin",{
                        title: '编辑楼盘'
                    });

                    var buildingForm = me.getBuildingBaseForm();
                    Ext.AjaxUtil.getAction({
                        url : me.requestUrl['detail'],
                        data: {id: record.get("id")},
                        callback:function(data){
                            var re = Ext.create("PMS.apps.BuildingApp.model.BuildingModel", data.data);
                            me.initAddress(function(){
                                buildingForm.getForm().loadRecord(re);
                            });
                        }
                    });
                },

                delHandler: function(grid, record){
                    var me = this;
                    Ext.Msg.confirm('删除', "确认删除？", function(btn){
                        if(btn == 'yes'){
                            Ext.AjaxUtil.getAction({
                                url :  me.requestUrl['del'],
                                data: {id: record.get("id")},
                                callback:function(data){
                                    grid.getStore().reload();
                                    Ext.example.msg("", "操作成功!");
                                }
                            });
                        }
                    });
                },

                recommendHandler: function(grid, record, type){
                    var me = this;
                    var recommend = type == 'yes'? 1:0;
                    Ext.AjaxUtil.getAction({
                        url :  me.requestUrl['recommend'],
                        data: {id: record.get("id"),recommend:recommend},
                        callback:function(data){
                            grid.getStore().reload();
                            Ext.example.msg("", "操作成功!");
                        }
                    });
                }
            },

            "buildingGrid button[action=Add]": {
                click: function(){
                    var me = this;
                    Ext.widget("buildingWin",{
                        title: '新增楼盘'
                    });

                    me.initAddress();
                }
            },

            "buildingGrid combo[itemId=SearchCityCombo]":{
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

            // 条件 筛选
            "buildingGrid button[itemId=FilterButton]":{
                click: function(){
                    var me = this,
                        grid = me.getBuildingGrid(),
                        store = grid.getStore(),
                        city_id = me.getSearchCityCombo().getValue(),
                        area_id = me.getSearchAreaCombo().getValue();
                    var pd = {};
                    if(city_id !== ''&& city_id !== undefined&& city_id !== null){
                        pd['cityId'] = Number(city_id);
                    }
                    if(area_id !== ''&& area_id !== undefined && area_id !== null){
                        pd['areaId'] = Number(area_id);
                    }
                    console.log("condition:");
                    console.log(pd);
                    store.proxy.extraParams = pd;
                    store.loadPage(1);
                }
            },
            "buildingWin combo[itemId=cityCombo]":{
                change: function(combo){
                    var me = this;
                    var value = combo.getValue();
                    var areas = me.address.filterDataByParent(me.address.city_cn_data, value);
                    var store = Ext.create("Ext.data.Store",{
                        model: 'PMS.apps.BuildingApp.model.AddressModel',
                        data: areas
                    });
                    me.getAreaCombo().bindStore(store);
                    me.getAreaCombo().setValue('');
                }
            },

            "buildingWin button[itemId=SaveButton]":{
                click: function(){
                    var me = this,
                        buildingForm = me.getBuildingBaseForm();
                    if(!buildingForm.getForm().isValid()){
                        return;
                    }

                    var values = buildingForm.getValues();

                    var pd = {
                        cityId: values['cityId'],
                        areaId: values['areaId'],
                        name: values['name'],
                        company: values['company']
                    };

                    var url = me.requestUrl['add'];
                    if(values['id']){
                        url = me.requestUrl['update'];
                        pd['id'] = values['id'];
                        pd['companyId'] = values['companyId'];
                    }

                    Ext.AjaxUtil.getAction({
                        url : url,
                        data: pd,
                        callback: function(re){
                            me.getBuildingGrid().getStore().reload();
                            Ext.example.msg("", "操作成功!");
                            me.getBuildingWin().close();
                        }
                    });
                }
            },
            "buildingGrid combo[itemId=search]": {
                select: function(records, eOpts) {
                    var me = this;

                    var buildingGirdStore = me.getBuildingGrid().getStore();
                    //console.log(records.value);
                    buildingGirdStore.proxy.extraParams['cityId'] = records.value;
                    buildingGirdStore.reload();

                }
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

    requestUrl: {
        add:  dev_base + 'data/building/edit?act=add&_dt=' + Math.random(),
        update:  dev_base + 'data/building/edit?act=update&_dt=' + Math.random(),
        del: dev_base + 'data/building/edit?act=del&_dt=' + Math.random(),
        detail: dev_base + 'data/building/info?_dt=' + Math.random(),
        recommend: dev_base + 'data/building/edit?act=recommend&_dt=' + Math.random()
    }
});