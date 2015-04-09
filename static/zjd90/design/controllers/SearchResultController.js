var houseListCtr;
require(["PagerPlugin","DropdownPlugin"], function() {
    houseListCtr = avalon.define("SearchResultController", function(vm) {
        vm.pageLevel = base;

        vm.results = [];

        vm.pginfo = {};
        vm.currentBuilding = '';
        vm.hasSearch = true;
        vm.areas = [
            {name:"不限",maxarea:1000,minarea:0},
            {name:"50㎡以下",maxarea:50,minarea:0},
            {name:"50-80㎡",maxarea:80,minarea:50},
            {name:"80-110㎡",maxarea:110,minarea:80},
            {name:"110㎡以上",maxarea:1000,minarea:110}
        ];
        vm.currentArea = 0;
        vm.areaClick = function(index) {
            vm.currentArea = index;
            listHouse(1,vm.searchText,vm.areas[vm.currentArea].minarea,vm.areas[vm.currentArea].maxarea);
        };


        vm.pager = {
            currentPage: 1,
            perPages: 6,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listHouse(data.currentPage);
            }
        }
//        vm.$skipArray = ["pager"]

        vm.$dropdownOpt = {
            height:105,
        	width:100,
            listWidth:105
        }

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

        vm.currentCity = '杭州';
        vm.currentCityValue = "330100";
        vm.searchText = '';
        vm.searchItems = {
            visible : false,
            curIndex: 0
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
        vm.setCurBuilding = function(index, e) {
            if(e){
                e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
            }
            vm.searchItems.curIndex = index;
            vm.searchText = vm.items[index];
            vm.searchItems.visible = false;
            vm.hasSearch = false;
            listHouse(1,vm.searchText);
        };

        vm.bodyClick = function(e){
            if(e){
                e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
            }
            vm.searchItems.visible = false;
        };
        vm.searchFocus = function(e) {
            if(e){
                e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
            }
            vm.searchItems.visible = true;
        }
        vm.searchBtnClick = function() {
            vm.hasSearch = false;
            listHouse(1,vm.searchText);
        }


        //search table citys control
        vm.addrtable_visible = false

        vm.provinces = [
             "浙江",
//             "山东"
        ]

        vm.province = ""


        vm.citys = [
            [
                {name: '全部', value: ''},
                {name: '杭州', value: '330100'},
                {name: '宁波', value: '330200'},
                {name: '温州', value: '330300'},
                {name: '嘉兴', value: '330400'},
                {name: '湖州', value: '330500'},
                {name: '绍兴', value: '330600'},
                {name: '舟山', value: '330900'},
                {name: '衢州', value: '330800'},
                {name: '金华', value: '330700'},
                {name: '台州', value: '331000'},
                {name: '丽水', value: '331100'}
            ],
//            [
//                {name: '全部', value: ''},
//                {name: '济南', value: ''},
//                {name: '青岛', value: ''},
//                {name: '淄博', value: ''},
//                {name: '枣庄', value: ''},
//                {name: '东营', value: ''},
//                {name: '烟台', value: ''},
//                {name: '潍坊', value: ''},
//                {name: '济宁', value: ''},
//                {name: '泰安', value: ''},
//                {name: '威海', value: ''},
//                {name: '日照', value: ''},
//                {name: '莱芜', value: ''},
//                {name: '日照', value: ''},
//                {name: '临沂', value: ''},
//                {name: '德州', value: ''},
//                {name: '德州', value: ''},
//                {name: '聊城', value: ''},
//                {name: '滨州', value: ''},
//                {name: '菏泽', value: ''}
//            ]
//             ["全部","杭州","宁波","温州","嘉兴","湖州","绍兴","舟山","衢州","金华","台州","丽水"],
//             ["全部","济南","青岛","淄博","枣庄","东营","烟台","潍坊","济宁","泰安","威海","日照","莱芜","临沂","德州","聊城","滨州","菏泽"]
        ]


        vm.display = false

        vm.showAddrtable = function(){
             vm.addrtable_visible = true;
        }

        vm.closeAddrtable = function(){
             vm.addrtable_visible = false;
        }

        vm.show = function(province) {
             vm.province = province;
             vm.display = true;
        }

        vm.chooseCurrentCity = function(index1, el) {
             vm.currentCity = el.name;
             vm.currentCityValue = el.value;
             vm.addrtable_visible = false;

            listHouse(1);
        }
        
    })
    avalon.scan();
    display();
});

function display() {
    require(['UtilController'], function(AjaxFunc){
        var building = AjaxFunc.getQueryStringByName('building');
        if (building) {
            houseListCtr.hasSearch = false;
            houseListCtr.searchText = decodeURIComponent(building);
        }
        listHouse(1,building);
    })
}



function listHouse(curIndex, keywords, minarea, maxarea){
    name = name || '';
    minarea = minarea || 0;
    maxarea = maxarea || 1000;
    keywords = keywords || '';
    var pd = {
        maxarea: maxarea,
        minarea: minarea,
        keywords: keywords,
        page: curIndex,
        num: houseListCtr.pager.perPages
    };
    if(houseListCtr.currentCityValue){
        pd['city'] = houseListCtr.currentCityValue;
    }

    require(['UtilController'], function(AjaxFunc){
        // var building = AjaxFunc.getQueryStringByName('building');
        // if (building)
        //     pd.keywords = building;

        AjaxFunc.getAction({
            url: Global_URL['getHouseList'],
            data: pd,
            dataType: Global_DataType,
            callback: function(result){
                //console.log(result.data);
                result.data.list = result.data.list || [];
                result.data.pagination =  result.data.pagination || { };
                avalon.each(result.data.list, function(i,item){
                    item.pic = image_base + item.pic;
                });
                if ( curIndex === 1 ) 
                    houseListCtr.results.clear();
                houseListCtr.results = result.data.list;
                houseListCtr.pginfo = result.data.pagination;

                if(result.data.list.length !== 0) 
                    houseListCtr.currentBuilding = result.data.list[0].building_name;
                else
                    houseListCtr.currentBuilding = houseListCtr.searchText;
                houseListCtr.pager.currentPage = curIndex;
                houseListCtr.pager.totalItems = result.data.pagination.count || result.data.list.length;
                houseListCtr.pager.totalPages = Math.ceil(houseListCtr.pager.totalItems / houseListCtr.pager.perPages);
                avalon.vmodels['HouseListPager'].totalItems = houseListCtr.pager.totalItems;
                avalon.vmodels['HouseListPager'].totalPages = houseListCtr.pager.totalPages;
                avalon.vmodels['HouseListPager'].currentPage = houseListCtr.pager.currentPage;

            }
        });
    })
}