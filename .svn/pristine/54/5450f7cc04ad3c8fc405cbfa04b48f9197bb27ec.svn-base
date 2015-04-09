/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */
var schemeModel = [];
var schemeListCtr;   // 列表 控制器

var house_type_id = '';
headerCtr.setCurHandler('design');

var houseCtr = avalon.define({
    $id: 'HouseController',
    setMyHouseHandler: function () {
        if(headerCtr.hasLogin){
            require([
                'UtilController',
                'ArtDialogPlugin'
            ], function(AjaxFunc){
                AjaxFunc.getAction({
                    url: Global_URL['setMyHouse'],
                    dataType: Global_DataType,
                    data: {house_type_id: house_type_id},
                    callback: function(result){
                        var d = dialog({
                            content: '恭喜! 您已成功找到户型',
                            quickClose: false
                        });
                        d.showModal();
                        setTimeout(function(){
                            d.close();
                            location.href = base + '/user/my_house.html'
                        },1000)
                    }
                });

            });
        }else{
            headerCtr.toLogin();
        }
    }
});

require(["PagerPlugin"], function() {
    schemeListCtr = avalon.define({
        $id: "SchemeListController",
        pager:{
            currentPage: 1,
            perPages: 3,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listPage(data.currentPage);
            }
        },
        $skipArray: ['pager'],

        // 默认数据格式，定义一条空的数据 是为了VM绑定
        list: [],
        building:'',
        curIndex: 0,
        setCurIndex: function(idx, name){
            schemeListCtr.curIndex = idx;
            load(1, name);
        },
        navHandler: function(pos, item){
            if(pos == 'left'){
                if(item.navIndex <= 0){
                    return;
                }
                schemeListCtr.setNavIndex(item.navIndex - 1, item);
            }else{
                if(item.navIndex >= item.design.length - 1){
                    return;
                }
                schemeListCtr.setNavIndex(item.navIndex + 1, item);
            }
        },
        setNavIndex: function(idx, item){
            if(item.navIndex == idx){
                return;
            }
            item.navIndex = idx;

            item.marginLeft = -idx * 995;
        },

        // 加入我的新家计划
        addToMyDesign: function(el) {
            require(['UtilController'], function (AjaxFunc) {
                AjaxFunc.getAction({
                    url: Global_URL['addToMyDesign'],
                    dataType: Global_DataType,
                    data: {design_id: el.design_schema_id},
                    callback: function (result) {
                        Tip.alert('恭喜! 您已成功找到设计方案', function(){
                            location.href = base + '/user/my_scheme.html'
                        });
                    }
                });
            });
        }
    });
    avalon.scan();
    load(1);
});

function StaticPaging(list, pageSize){
    this.cur = 0;
    this.pageSize = pageSize ||  3;

    this.list = avalon.mix(true, [], (list || []));
    this.totalPage = Math.ceil(this.list.length / this.pageSize);
}
StaticPaging.prototype = {

    nextPage: function(){
        if(this.cur >= this.totalPage){
            return [];
        }
        this.cur = Math.min(this.cur + 1, this.totalPage);
        return this._getListOfIndex(this.cur);
    },

    _getListOfIndex: function(index){
        index = Math.min(index, this.totalPage);

        return this.list.slice((index - 1) * this.pageSize, index * this.pageSize);
    }
};
var staticPageTool;
function listPage(index){

    if(staticPageTool.cur == index){
        return;
    }
    schemeListCtr.pager.currentPage = index;
    staticPageTool.cur = index;

    schemeListCtr.list =avalon.mix(true,[],staticPageTool._getListOfIndex(index));

    avalon.vmodels['SchemeListPager'].currentPage = schemeListCtr.pager.currentPage;

    setTimeout(function(){
        // onScrollEffectLayout
        new cbpScroller(document.getElementById( 'cbp-so-scroller'));
    }, 500);
}

function load(curIndex) {
   require(['UtilController'], function(AjaxFunc){
        house_type_id = AjaxFunc.getQueryStringByName('house_type_id');

        var pd = {
            house_type_id: house_type_id
        };

        AjaxFunc.getAction({
            url: Global_URL['getSchemeList'],
            data: pd,
            dataType: Global_DataType,
            callback: 
                function(result){  
                    result.data = result.data || [];
                    
                    result.data.housetype.pic = image_base + result.data.housetype.pic;

                    avalon.each(result.data.designinfo, function(i, item){
                        var design = [];
                        var list = {};
                        avalon.each(item.room, function(i,item) {
                            item.design_pic = image_base + item.design_pic;
                        });

                        list = item;

                        list['navIndex'] = 0;
                        list['marginLeft'] = 0;
                        list['design'] = item.room;           
                        schemeModel.push(list);
                    });
                    staticPageTool = new StaticPaging(schemeModel);

//                    schemeListCtr.list = schemeModel;
                    schemeListCtr.building = result.data.housetype;

//                    schemeListCtr.pager.currentPage = curIndex;
                    schemeListCtr.pager.totalItems = schemeModel.length;

                    schemeListCtr.pager.totalPages = Math.ceil(schemeListCtr.pager.totalItems / schemeListCtr.pager.perPages);
                    avalon.vmodels['SchemeListPager'].totalItems = schemeListCtr.pager.totalItems;
                    avalon.vmodels['SchemeListPager'].totalPages = schemeListCtr.pager.totalPages;
//                    avalon.vmodels['SchemeListPager'].currentPage = schemeListCtr.pager.currentPage;
//
//                    setTimeout(function(){
//                        // onScrollEffectLayout
//                        new cbpScroller(document.getElementById( 'cbp-so-scroller'));
//                    }, 500);

                    listPage(1);
                }
        })
    })
}