
/*******************
 * 发布设计方案 选择户型图
 ******************/
var city_province_data;
var city_cn_data;

// 缓存 artDialog 对象
var _dialogs_ = [{
    'add_house': null
}];

// 选择户型 Controller
var publishCtr = avalon.define({
    $id: 'PublishController',
    provinces: [],     // 省
    cities: [],        // 市
    countys: [],       // 区
    buildings: [],     // 楼盘
    houses: [],        // 户型

    clickAble: false,
    select: {
        province: '',
        city: '',
        cityId: '',
        county: '',
        countyId: '',
        building: '',
        buildingId: '',
        house: '',
        houseId: '',
        houseThumbUrl: ''
    },

    // 省份切换
    provinceChangeHandler: function(el){
        publishCtr.cityChangeHandler(null);
        if(!el){
            publishCtr.cities = [];
            return;
        }
        var cities = filterDataByParent(city_cn_data, el[0]);
        publishCtr.cities = cities;
    },

    // 城市切换
    cityChangeHandler: function(el,isInit){
        if(!isInit){
            publishCtr.countyChangeHandler(null);
        }
        if(!el){
            publishCtr.countys = [];
            return;
        }
        publishCtr.select.city = el[1];
        publishCtr.select.cityId = el[0];

        var countys = filterDataByParent(city_cn_data, el[0]);
        publishCtr.countys = countys;
    },

    // 区域切换
    countyChangeHandler: function(el,isInit){
        if(!isInit){
            publishCtr.buildingChangeHandler(null);
        }
        if(!el){
            publishCtr.buildings = [];
            return;
        }
        publishCtr.select.county = el[1];
        publishCtr.select.countyId = el[0];
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['getBuildingByCounty'],
                data: {areaId: el[0], cityId: publishCtr.select.cityId},
                callback: function(result){
                    publishCtr.buildings = result.data.buildingList;
                }
            })
        });
    },

    // 楼盘切换
    buildingChangeHandler: function(el){
        publishCtr.houseChangeHandler(null);
        if(!el){
            publishCtr.houses = [];
            return;
        }
        publishCtr.select.buildingId = el['id'];
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.saveAction({
                url: Global_URL['getHouseByBuilding'],
                data: {
                   cityId: publishCtr.select.cityId,
                   areaId: publishCtr.select.countyId,
                   buildingId: el['id'],
                   num: 1000,
                   page: 1,
                   "state[]": [0]
                },
                callback: function(result){
                    publishCtr.houses = result.data.houseList;
                }
            })
        });
    },

    // 户型切换
    houseChangeHandler: function(el){
        if(!el){
            publishCtr.select.houseId = '';
            publishCtr.select.house = '';
            publishCtr.select.houseThumbUrl = '';
            return;
        }
        publishCtr.select.houseId = el['id'];
        publishCtr.clickAble = true;
        publishCtr.select.houseThumbUrl = image_base + el['pic'];
    },

    toNextHandler: function(){
        if(!publishCtr.clickAble){
            Tip.alert("请先选择户型图");
            return;
        }
        location.href = base + 'schema/publish.html?house_id='
                         + publishCtr.select.houseId
    },

    // 新增户型
    addHouseHandler: function(){
        require([
            'ArtDialogPlugin',
            'UploadHouseController',
            "text!../../design-center/views/add-house-dialog.html"
        ], function(_,__, html){
            var d = dialog({
                fixed: true,
                width: 712,
                content: html
            });
            addHouseCtr.row['province'] = publishCtr.select['province'];
            addHouseCtr.row['city'] = publishCtr.select['city'];
            addHouseCtr.row['cityId'] = publishCtr.select['cityId'];
            addHouseCtr.row['area'] = publishCtr.select['county'];
            addHouseCtr.row['areaId'] = publishCtr.select['countyId'];
            addHouseCtr.row['building'] = publishCtr.select['building'];
            addHouseCtr.row['buildingId'] = publishCtr.select['buildingId'];

            addHouseCtr.row['houseName'] = '';
            addHouseCtr.row['grossArea'] = '';
            addHouseCtr.row['usableArea'] = '';
            avalon.scan();
            d.showModal();

            uploadCtr.initHandler();

            _dialogs_['add_house'] = d;
        });
    }
});
init_publish();
publishCtr.provinceChangeHandler(publishCtr.provinces[0]);
publishCtr.cityChangeHandler(publishCtr.cities[0], true);

// 新增户型 Controller
var addHouseCtr = avalon.define({
    $id: 'AddHouseController',
    row: {
        houseThumbUrl: '',
        province: '',
        city: '',
        building: '',
        buildingId: '',
        cityId: '',
        area: '',
        areaId: '',
        houseName: '',
        grossArea: '',
        usableArea: ''
    },
    addRoom:{
        room_name: '',
        room_size: ''
    },
    saveHandler: function(){
        var pd = {
            name: addHouseCtr.row.houseName,
            buildingId: addHouseCtr.row.buildingId,
            cityId: addHouseCtr.row.cityId,
            areaId: addHouseCtr.row.areaId,
            usableArea: addHouseCtr.row.usableArea,
            grossArea: addHouseCtr.row.grossArea
        };
        var re = validateHandler(pd);
        if(!re.success){
            require(['ArtDialogPlugin'], function(){
                var d = dialog({
                    content: re.message,
                    quickClose: false
                });
                d.showModal();
                setTimeout(function(){
                    d.close();
                },1500);
            });
            return;
        }
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.saveAction({
                url: Global_URL['addHouse'],
                data: pd,
                method: 'POST',
                callback: function(result){
                    _dialogs_['add_house'].close();
                    publishCtr.houses.push({
                        id: result.data,
                        name: pd.name,
                        pic: pd.pic
                    });
                }
            });
        });
    },
    sizeBlur: function(type){
        var item, size;
        if(type == 'grossArea'){
            size = Number(addHouseCtr.row['grossArea']) || 0;
            size = Math.max(0, size);
            size = Number(size.toFixed(2));
            addHouseCtr.row['grossArea'] = size;
        }
        if(type == 'usableArea'){
            size = Number(addHouseCtr.row['usableArea']) || 0;
            size = Math.max(0, size);
            size = Number(size.toFixed(2));
            addHouseCtr.row['usableArea'] = size;
        }
    }
});

// 初始化
function init_publish(){
    require(['AddressData'], function(data){
        city_province_data = avalon.mix([], true, data.city_province_data);
        city_cn_data = avalon.mix([], true,data.city_cn_data);

        publishCtr.provinces =  [["330000", "\u6d59\u6c5f", "1"]];

        var cities = filterDataByParent(city_cn_data, "330000");
        publishCtr.cities = cities;
        var countys = filterDataByParent(city_cn_data, cities[0][0]);
        publishCtr.countys = countys;

        publishCtr.select['province'] = publishCtr.provinces[0][1];
        publishCtr.select['city'] = publishCtr.cities[0][1];
        publishCtr.select['cityId'] = publishCtr.cities[0][0];
        publishCtr.select['county'] = publishCtr.countys[0][1];
        publishCtr.select['countyId'] = publishCtr.countys[0][0];

        publishCtr.countyChangeHandler(publishCtr.countys[0]);
    });

}
/*****************************工具函数*********************************/
// 根据parentID过滤数据
function filterDataByParent(dataArray, parentID){
    var re = [];
    avalon.each(dataArray, function(i, item){
        if(item[2] == parentID){
            re.push(item);
        }
    });
    return re;
}

function validateHandler(pd){
    var fg = true, msg = '';
    if(!uploadCtr.list.length || !uploadCtr.list[0].serial){
        fg = false;
        msg = '请上传户型图';
        return {
            success: fg,
            message: msg
        }
    }
    pd.pic = uploadCtr.list[0].serial;

    if(!pd.name){
        fg = false;
        msg = '请填写户型名称';
        return {
            success: fg,
            message: msg
        }
    }
    if(!pd.usableArea){
        fg = false;
        msg = '请填写可使用面积';
        return {
            success: fg,
            message: msg
        }
    }
    if(!pd.grossArea){
        fg = false;
        msg = '请填写建筑面积';
        return {
            success: fg,
            message: msg
        }
    }
    return{
        success: true
    }
}
/*****************************工具函数*********************************/
