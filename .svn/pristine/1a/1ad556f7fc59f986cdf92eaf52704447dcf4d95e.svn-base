/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */
var articleListCtr;
require(['PagerPlugin'], function () {
    articleListCtr = avalon.define({
        $id: "ArticleListController",

        // 默认数据格式，定义一条空的数据 是为了VM绑定
        list: [],
        pager: {
            currentPage: 1,
            perPages: 7,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listArticle(data.currentPage);
            }
        },
        name: '',
        total: 0,
        $skipArray: ['pager']

    });

    avalon.scan();
});

var categoryCtr = avalon.define({
    $id: 'CategoryController',

    list: [],

    activeIndex: -1,

    activeHandler: function(el,index){
        if(categoryCtr.activeIndex == index){
            return;
        }
        categoryCtr.activeIndex = index;
        articleListCtr.name = categoryCtr.list[index].name;
        listArticle(1);
    }
});


require(['UtilController'], function(AjaxFunc){
    AjaxFunc.getAction({
        url: Global_URL['getCategoryByArticle'],
        callback: function(result){
            result.data = result.data || [];
            var tp = [];
            avalon.each(result.data, function(i, item){
                if(Number(item.fatherId) == 0){
                    tp.push(item);
                }
            });
            categoryCtr.list = tp;

            if(tp.length){
                categoryCtr.activeHandler(categoryCtr.list[0],0);
            }
        }
    });
});


function listArticle(curIndex){
    var pd = {
        page: curIndex,
        num: articleListCtr.pager.perPages,
        catId: categoryCtr.list[categoryCtr.activeIndex].id
    };

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['articleList'],
            data: pd,
            callback: function(result){
                var list = result.data.articleList || [];

                // 补充数据模型
                avalon.each(list, function(i, item){
                    item['thumbUrl'] = image_base + item.pic + THUMB_SIZE['detail'];
                });
                articleListCtr.list = list;
                articleListCtr.total = result.data.pagination.count;

                articleListCtr.pager.currentPage = curIndex;
                articleListCtr.pager.totalItems = result.data.pagination.count || list.length;
                articleListCtr.pager.totalPages = Math.ceil(articleListCtr.pager.totalItems / articleListCtr.pager.perPages);
                avalon.vmodels['ArticleListPager'].totalItems = articleListCtr.pager.totalItems;
                avalon.vmodels['ArticleListPager'].totalPages = articleListCtr.pager.totalPages;
                avalon.vmodels['ArticleListPager'].currentPage = articleListCtr.pager.currentPage;
            }
        });
    })
}