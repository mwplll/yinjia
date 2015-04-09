/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */
var schemeModel = {
    navIndex: 0,
    marginLeft: 0,
    images: []
};
var collectListCtr;   // 列表 控制器
require(["PagerPlugin"], function() {
    collectListCtr = avalon.define({
        $id: "CollectListController",
        pager:{
            currentPage: 1,
            perPages: 20,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listScheme(data.currentPage);
            }
        },
        $skipArray: ['pager'],

        // 默认数据格式，定义一条空的数据 是为了VM绑定
        list: [
            schemeModel
        ],

        curIndex: 0,
        setCurIndex: function(idx, name){
            collectListCtr.curIndex = idx;
            listScheme(1, name);
        },
        navHandler: function(pos, item){
            if(pos == 'left'){
                if(item.navIndex <= 0){
                    return;
                }
                collectListCtr.setNavIndex(item.navIndex - 1, item);
            }else{
                if(item.navIndex >= item.images.length - 1){
                    return;
                }
                collectListCtr.setNavIndex(item.navIndex + 1, item);
            }
        },
        setNavIndex: function(idx, item){
            if(item.navIndex == idx){
                return;
            }
            item.navIndex = idx;

            item.marginLeft = -idx * 995;
        }

    });
    avalon.scan();
    listScheme(1);
});

function listScheme(curIndex, name){
    name = name || '';
    var pd = {
        style: name,
        start: (curIndex - 1) * collectListCtr.pager.perPages,
        limit: collectListCtr.pager.perPages
    };

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getMyDesignList'],
            data: pd,
            callback: function(result){
                result.data = result.data || [];
                // 补充数据模型
                avalon.each(result.data, function(i, item){
                    item['navIndex'] = 0;
                    item['marginLeft'] = 0;
                    item['images'] = [{t:1},{t:1},{t:1},{t:1}];
                });
                collectListCtr.list = result.data;

                collectListCtr.pager.currentPage = curIndex;
                collectListCtr.pager.totalItems = result.total || result.data.length;
                collectListCtr.pager.totalPages = Math.ceil(collectListCtr.pager.totalItems / collectListCtr.pager.perPages);
                avalon.vmodels['CollectListPager'].totalItems = collectListCtr.pager.totalItems;
                avalon.vmodels['CollectListPager'].totalPages = collectListCtr.pager.totalPages;
                avalon.vmodels['CollectListPager'].currentPage = collectListCtr.pager.currentPage;
            }
        });
    })
}