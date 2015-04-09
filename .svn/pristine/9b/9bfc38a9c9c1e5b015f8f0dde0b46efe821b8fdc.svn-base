var schemaListCtr;
var city_province_data;
var city_cn_data;

var searchCtr = avalon.define({
    $id: 'SearchController',
    areaList: [],
    buildingList: [],
    houseList: [],

    areaIndex: -1,
    buildingIndex: -1,
    houseIndex: -1,

    city: '330100', //默认杭州

    areaVisible: true,
    buildingVisible: false,
    houseVisible: false,

    areaSelectHandler: function(el, index){
        if(searchCtr.areaIndex == index){
            return;
        }
        searchCtr.areaIndex = index;
        searchCtr.buildingIndex = -1;
        searchCtr.houseIndex = -1;
        listBuilding();
        listHouse();
        searchCtr.initSelectList();
    },
    buildingSelectHandler: function(el, index){
        if(searchCtr.buildingIndex == index){
            return;
        }
        searchCtr.buildingIndex = index;
        searchCtr.houseIndex = -1;
        listHouse();
        searchCtr.initSelectList();
    },
    houseSelectHandler: function(el, index){
        if(searchCtr.houseIndex == index){
            return;
        }
        searchCtr.houseIndex = index;
        searchCtr.initSelectList();
    },

    selectList: [],

    initSelectList: function(){
        searchCtr.selectList.clear();
        if(searchCtr.areaIndex != -1){
            searchCtr.selectList.push({
                name: searchCtr.areaList[searchCtr.areaIndex][1],
                value: searchCtr.areaList[searchCtr.areaIndex][0],
                type: 'area'
            });
        }
        if(searchCtr.buildingIndex != -1){
            searchCtr.selectList.push({
                name: searchCtr.buildingList[searchCtr.buildingIndex].name,
                value: searchCtr.buildingList[searchCtr.buildingIndex].id,
                type: 'building'
            });
        }
        if(searchCtr.houseIndex != -1){
            var house = searchCtr.houseList[searchCtr.houseIndex];
            searchCtr.selectList.push({
//                name: house.grossArea + house.name,
                name: house.name,
                value: house.id,
                type: 'house'
            });
        }
        listHandler(1);
    },

    moreHandler: function(type){
        if(type == 'area'){
            searchCtr.areaVisible = !searchCtr.areaVisible;
        }else if(type == 'building'){
            searchCtr.buildingVisible = !searchCtr.buildingVisible;
        }else if(type == 'house'){
            searchCtr.houseVisible = !searchCtr.houseVisible;
        }
    },
    removeHandler: function(el){
        if(el.type == 'area'){
            searchCtr.areaIndex = -1;

            listBuilding();
        }else if(el.type == 'building'){
            searchCtr.buildingIndex = -1;

            listHouse();
        }else if(el.type == 'house'){
            searchCtr.houseIndex = -1;
        }

        listHandler(1);
    }
});
require(["PagerPlugin"], function(_) {
    schemaListCtr = avalon.define("SchemaListController", function(vm) {
        vm.list = [];
        vm.pager = {
            currentPage: 1,
            perPages: 12,
            totalPages: 1,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listHandler(data.currentPage);
            }
        };

        vm.likeHandler = function(el){
            require(['UtilController'], function(AjaxFunc){
                AjaxFunc.getAction({
                    url: Global_URL['saveLike'],
                    data: {id:el.id},
                    callback: function(result){
                        el.likeNum = Number(el.likeNum) + 1;
                    }
                });
            });
        }
    });

    avalon.scan();

});


var selectCookie;
require(['AddressData', 'UtilController'], function(data, AjaxFunc){
    city_province_data = avalon.mix([], true, data.city_province_data);
    city_cn_data = avalon.mix([], true,data.city_cn_data);

    var city = AjaxFunc.getCookie('cityId2') || '330100';

    searchCtr.city = city;

    var countys = filterDataByParent(city_cn_data, searchCtr.city);
    searchCtr.areaList = countys;

    selectCookie = AjaxFunc.getCookie("select");
    if(selectCookie){
        selectCookie = JSON.parse(selectCookie);
    }
    if(selectCookie){
        avalon.each(countys, function(i, it){
            if(Number(it[0]) == Number(selectCookie.areaId)){
                searchCtr.areaIndex = i;
            }
        });
        searchCtr.selectList.push({
            name: selectCookie.area,
            value: selectCookie.areaId,
            type: 'area'
        });
        searchCtr.selectList.push({
            name: selectCookie.building,
            value: selectCookie.buildId,
            type: 'building'
        });

        AjaxFunc.setCookie("select", null, 3600 * 24 * 7, '/');
    }

    listBuilding();

    listHandler(1);
});
function listBuilding(){
    var pd = {
        num: 100,
        page: 1,
        cityId: searchCtr.city
    };
    if(searchCtr.areaIndex > -1){
        pd['areaId'] = searchCtr.areaList[searchCtr.areaIndex][0]
    }
    searchCtr.buildingIndex = -1;
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getBuildingList'],
            data: pd,
            callback: function(result){
                searchCtr.buildingList = result.data.buildingList;

                if(selectCookie){
                    avalon.each(searchCtr.buildingList, function(i, it){
                        if(Number(it.id) == Number(selectCookie.buildId)){
                            searchCtr.buildingIndex = i;
                        }
                    });

                    selectCookie = null;
                }
            }
        });
    });
}

function listHouse(){
    var pd = {
        num: 100,
        page: 1,
        cityId: searchCtr.city
    };
    if(searchCtr.areaIndex > -1){
        pd['areaId'] = searchCtr.areaList[searchCtr.areaIndex][0]
    }
    if(searchCtr.buildingIndex > -1){
        pd['buildingId'] = searchCtr.buildingList[searchCtr.buildingIndex]['id']
    }
    searchCtr.houseIndex = -1;
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getHouseList'],
            data: pd,
            callback: function(result){
                searchCtr.houseList = result.data.houseList;
            }
        });
    });
}


function listHandler(curIndex){
    var pd = {
        "states[]": [0],
        cityId: searchCtr.city,
        page: curIndex,
        num: 8
    };

    avalon.each(searchCtr.selectList, function(i, it){
        if(it.type == 'area'){
            pd['areaId'] = it.value;
        }else if(it.type == 'building'){
            pd['buildingId'] = it.value;
        }else if(it.type == 'house'){
            pd['houseId'] = it.value;
        }
    });


    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getSchemaList'],
            data: pd,
            callback: function(result){
                result.data = result.data || {};
                avalon.each(result.data.schemaList, function(i, item){
                    item.thumbUrl = image_base + item.mainPic + THUMB_SIZE['schema'];
                    item.totalPrice = Number(Number(item.totalPrice).toFixed(2));

                    item.likeNum = Number(item.likeNum) || '';
                });
                schemaListCtr.list.clear();
                schemaListCtr.list = result.data.schemaList;

                schemaListCtr.pager.totalItems = Number(result.data.pagination.count);
                schemaListCtr.pager.totalPages = Number(result.data.pagination.page);
            }
        });
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