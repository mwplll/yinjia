var houseListCtr;
var city_province_data;
var city_cn_data;
require(["PagerPlugin"], function() {
    houseListCtr = avalon.define("HouseListController", function(vm) {
        vm.pageLevel = base;
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

        vm.bigThumbUrl = '';
        vm.openThumbnailDialog = function(el) {
            vm.bigThumbUrl = el.pic;
            require([
                'ArtDialogPlugin',
                "text!../../design/views/thumbnail.html"
            ], function(_, html){
                var d = dialog({
                    fixed: true,
                    width: 700,
                    height: 565,
                    content: html
                });
                d.showModal();
                avalon.scan();
            });
        };

        vm.items = [
            '凯旋门',
            '春江彼岸',
            '柏林印象',
            '德信晓宸',
            '官河锦亭',
            '春和钱塘',
            '西溪华府',
            '西溪融庄',
            '之江九里'
        ];
        vm.select = {
            city: '杭州',
            city_id: '330100',
            county: '',
            county_id: '',
            building: '',
            building_id: ''
        };
        vm.countys = [];
        vm.countys_raw = [];
        vm.buildings = [];
        vm.buildings_raw = [];
        vm.changeAreaHandler = function(el){
            if(!el){
                houseListCtr.buildings = [];
                return;
            }
            houseListCtr.select.county = el[1];
            houseListCtr.select.county_id = el[0];
            getBuildings(el[0]);
            listHandler(1);
        };
        vm.changeBuildingHandler = function(el){
            houseListCtr.select.building = el.name;
            houseListCtr.select.building_id = el.id;

            listHandler(1);
        };
        vm.moreVisible1 = false;
        vm.moreVisible2 = false;
        vm.moreHandler = function(type){
            if(type == 'county'){
                houseListCtr.moreVisible1 = !houseListCtr.moreVisible1;
                if(!houseListCtr.moreVisible1){
                    var row1 = houseListCtr.countys_raw.$model.slice(0, 8);
                    houseListCtr.countys = avalon.mix(true,[], row1);
                }else{
                    houseListCtr.countys = avalon.mix(true,[], houseListCtr.countys_raw.$model);
                }
            }else{
                houseListCtr.moreVisible2 = !houseListCtr.moreVisible2;
                if(!houseListCtr.moreVisible2){
                    var row = houseListCtr.buildings_raw.$model.slice(0, 6);
                    houseListCtr.buildings = avalon.mix(true,[], row);
                }else{
                    houseListCtr.buildings = avalon.mix(true,[], houseListCtr.buildings_raw.$model);
                }
            }
        };

        vm.morePageHandler = function(){
            listHandler(houseListCtr.pager.currentPage + 1);
        }
    });
    avalon.scan();
    initAddress();
    getBuildings();
    listHandler(1);
});

function listHandler(curIndex){
    var pd = {
        page: curIndex,
        num: houseListCtr.pager.perPages
    };
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getHouseList'],
            data: pd,
            callback: function(result){
                result.data.list = result.data.list || [];
                result.data.pagination =  result.data.pagination || { };
                avalon.each(result.data.list, function(i,item){
                    item.thumbUrl = image_base + item.pic + THUMB_SIZE['schema'];
                });
                if ( curIndex === 1 )
                    houseListCtr.list.clear();
                var list = avalon.mix(true, [], houseListCtr.list.$model);
                houseListCtr.list = list.concat(result.data.list);

                houseListCtr.pager.currentPage = curIndex;
                houseListCtr.pager.totalItems = result.data.pagination.count || result.data.list.length;
                houseListCtr.pager.totalPages = Math.ceil(houseListCtr.pager.totalItems / houseListCtr.pager.perPages);

            }
        });
    })
}

function getBuildings(areaId){
    var pd = {cityId: houseListCtr.select.city_id, num: 1000, page: 1};
    if(areaId !== undefined){
        pd['areaId'] = areaId;
    }
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getBuildingByCounty'],
            data: pd,
            callback: function(result){
                houseListCtr.buildings_raw = avalon.mix(true, [], result.data.buildingList);
                houseListCtr.moreVisible2 = false;
                var row = houseListCtr.buildings_raw.$model.slice(0, 6);
                houseListCtr.buildings = avalon.mix(true,[], row);
            }
        });
    });
}

function initAddress(){
    require(['AddressData'], function(data){
        city_province_data = avalon.mix([], true, data.city_province_data);
        city_cn_data = avalon.mix([], true,data.city_cn_data);
//        publishCtr.provinces =  [["330000", "\u6d59\u6c5f", "1"]];
        var cities = filterDataByParent(city_cn_data, "330000");
        var countys = filterDataByParent(city_cn_data, cities[0][0]);
        houseListCtr.countys_raw = avalon.mix(true, [], countys);
        var row1 = countys.slice(0, 8);
        houseListCtr.moreVisible1 = false;
        houseListCtr.countys = avalon.mix(true,[], row1);
    });

}

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