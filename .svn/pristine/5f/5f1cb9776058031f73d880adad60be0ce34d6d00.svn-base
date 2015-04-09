headerCtr.cur = 'material';
var perPages = 18;
var materialListCtr;
var categoryListCtr;
require(['PagerPlugin'], function(){
    materialListCtr = avalon.define({
        $id: "MaterialListController",
        goods: [],

        icons: [
            {style:'cbp-so-side-topleft',icon:'icon1',name:'全部建材',id: null},
            {style:'cbp-so-side-topleft',icon:'icon2',name:'墙地面材料',id:'1'},
            {style:'cbp-so-side-top',icon:'icon3',name:'装饰材料',id:'2'},
            {style:'cbp-so-side-top',icon:'icon4',name:'家装五金',id:'3'},
            {style:'cbp-so-side-topright',icon:'icon5',name:'灯饰照明',id:'4'},
            {style:'cbp-so-side-topright',icon:'icon6',name:'厨房卫浴',id:'5'},
            {style:'cbp-so-side-topright',icon:'icon8',name:'家用电器',id:'57'}
        ],
        iconsSelected : 0,
        pager:{
            currentPage: 1,
            perPages: perPages,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listGoods({
                    page: data.currentPage
                });
            }
        },

        $skipArray: ['pager'],

        sortField: {
            hot: 'desc',
            comment: 'desc',
            price: 'desc'
        },
        sortWords: {
            hot: {desc: 1, asc: 0, value: 1},
            comment: {desc: 1, asc: 0, value: 2},
            price: {desc: 1, asc: 0, value: 0}
        },

        sortHandler: function(field){
            if(!field){
                listGoods();
                return;
            }
            for(var k in materialListCtr.sortField){
                if(k != field){
                    materialListCtr.sortField[k] = 'desc';
                }
            }

            var tp = materialListCtr.sortField[field];
            if(tp == 'desc'){
                materialListCtr.sortField[field] = 'asc';
            }else{
                materialListCtr.sortField[field] = 'desc';
            }
            var pd  = {
                sortWords: materialListCtr.sortWords[field]['value'],
                turn: materialListCtr.sortWords[field][materialListCtr.sortField[field]]
            };
            listGoods(pd)
        },

        keywords: '',
        searchHandler: function(){
            materialListCtr.sortField['hot'] = 'desc';
            materialListCtr.sortField['comment'] = 'desc';
            materialListCtr.sortField['price'] = 'desc';
            listGoods({keywords: materialListCtr.keywords});
        },

        catHandler: function(el, index){
            materialListCtr.iconsSelected = index;
            materialListCtr.sortField['hot'] = 'desc';
            materialListCtr.sortField['comment'] = 'desc';
            materialListCtr.sortField['price'] = 'desc';
            materialListCtr.keywords = '';
            listGoods();

            var fg = false;
            for(var i = 0; i < categoryListCtr.list.length; i++){
                var ct = categoryListCtr.list[i];
                if(ct.name == el.name && ct.children.length){
                    categoryListCtr.curList = avalon.mix(true, [], ct.children.$model);
                    categoryListCtr.curName = el.name;
                    fg = true;
                    break;
                }
            }
            if(!fg){
                categoryListCtr.curList = [];
                categoryListCtr.curName = '';
            }
        }
    });

    categoryListCtr = avalon.define({
        $id: "CategoryListController",

        list: [],

        curList: [],

        curName: ''

    });

    avalon.scan();

    listGoods();

    initCategory();
});

function initCategory(){
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getGoodsCategory'],
            callback: function(result){
                categoryListCtr.list = createGoodsTreeModel(result.data);
            }
        });
    })
}

function createGoodsTreeModel(nodes){
    function getTree(list) {
        var gc = function(parentid) {
            var cn = [];
            for (var i = 0; i < list.length; i++) {
                var n = list[i];
                if(n.father_id == parentid){
                    n.id = Number(n.id);
                    n.categoryId = n.id;
                    n.text = n.name;
                    n.enable = Number(n.del);
                    n.parentId = n.father_id;
                    n.children = gc(n.id);
                    if(!n.children.length){
                        n.leaf = true;
                    }
                    cn.push(n);
                }
            }
            return cn;
        };
        return gc(0);
    }
    return getTree(nodes);
}

function listGoods(condition){
    condition = condition || {};
    var pd = {
        state: 0,
        keywords: '',
        num: perPages,
        page: condition.page || 1
    };
    if(materialListCtr.icons[materialListCtr.iconsSelected].id){
        pd["catId"] = materialListCtr.icons[materialListCtr.iconsSelected].id;
    }
    pd = avalon.mix(true, pd, condition);

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getMaterialList'],
            data: pd,
            callback: function(result){
                var goodsList = result.data.goodsList || [];
                avalon.each(goodsList, function(i, good){
                    good['thumbUrl'] = image_base + good['pic'] + THUMB_SIZE['goods'];
                });
                materialListCtr.goods = goodsList;


                materialListCtr.pager.currentPage = pd['page'];
                materialListCtr.pager.totalItems = Number(result.data.pagination.count) || goodsList.length;
                materialListCtr.pager.totalPages = Math.ceil(materialListCtr.pager.totalItems / materialListCtr.pager.perPages);
                avalon.vmodels['GoodsListPager'].totalItems = materialListCtr.pager.totalItems;
                avalon.vmodels['GoodsListPager'].totalPages = materialListCtr.pager.totalPages;
                avalon.vmodels['GoodsListPager'].currentPage = materialListCtr.pager.currentPage;
            }
        });
    })
}


require("RevolutionSliderPlugin", function () {
    setTimeout(function () {
        $(".cbp-so-init").addClass('cbp-so-animate');
    },500)
});




