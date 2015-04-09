var pageSize = 10;
var stockSchemeCtr;

require([
    "UtilController",
    "PagerPlugin",
    "DropdownPlugin"
], function(AjaxFunc) {
    var type = AjaxFunc.getQueryStringByName('type') || 0;
	stockSchemeCtr = avalon.define({
        $id: 'ShowSchemeController',

		items: [],
        state: type,
        key: '',

        pager:{
            currentPage: 1,
            perPages: pageSize,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listSchema(data.currentPage);
            }
        },
        $skipArray: ['pager'],

        actionHandler: function(el, type){
            var pd = {
                act: type,
                id: el.id
            };
            if(type == 'del'){
                require(['ArtDialogPlugin'], function () {
                    var d = dialog({
                        content: "确认删除？",
                        cancel: function(){},
                        cancelValue: '取消',
                        ok: function(){
                            action(pd);
                        },
                        okValue: '确定',
                        quickClose: false
                    });
                    d.showModal();
                });
            }else if(type == 'down'){
                require(['ArtDialogPlugin'], function () {
                    var d = dialog({
                        content: "确认下架？",
                        cancel: function(){},
                        cancelValue: '取消',
                        ok: function(){
                           action(pd);
                        },
                        okValue: '确定',
                        quickClose: false
                    });
                    d.showModal();
                });
            }else if(type == 'up'){
                action(pd);
            }
        },

        searchHandler: function(){
            listSchema(1);
        },

        curTabName: '展示中的设计方案',
        tabHandler: function(type){
//            stockSchemeCtr.key = '';
//            stockSchemeCtr.state = type;
            location.href = '../design-center/show-scheme.html?type=' + type;
//            listSchema(1);
        }

	});
	avalon.scan();

    listSchema(1);
});

function action(pd){
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.saveAction({
            url: Global_URL['actMySchema'],
            data: pd,
            crossDomain: Global_CrossDomain,
            method: 'POST',
            callback: function (result) {
                location.reload();
            }
        });
    });
}

function listSchema(page, key){
    var pd = {
        page: page,
        num: pageSize,
        "state[]": stockSchemeCtr.state,
        keywords: stockSchemeCtr.key
    };
    if(stockSchemeCtr.state == 0){
        stockSchemeCtr.curTabName = '展示中的设计方案';
    }else if(stockSchemeCtr.state == 2){
        stockSchemeCtr.curTabName = '审核中的设计方案';
    }else if(stockSchemeCtr.state == 3){
        stockSchemeCtr.curTabName = '仓库中的设计方案';
    }else if(stockSchemeCtr.state == 4){
        stockSchemeCtr.curTabName = '审核失败的方案';
    }
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getMySchemaList'],
            data: pd,
            callback: function(result){
                result.data.schemaList = result.data.schemaList || [];

                // 补充数据模型
                avalon.each(result.data.schemaList, function(i, item){
                    item.thumbUrl = image_base + item.mainPic + THUMB_SIZE['schema'];
                    item.stateText = convertState(item.state);
                    var house = item.houseType;
                    item.houseId = house['id'];

                    item.modifyTime = Number(item['modifyTime'] * 1000);

                    item.houseInfo = house.prov + ' ' + house.city + ' ' + house.area
                                     + ' ' + house.building + ' ' + house.name;
                });
                stockSchemeCtr.items = result.data.schemaList;

                stockSchemeCtr.pager.currentPage = page;
                stockSchemeCtr.pager.totalItems = result.data.pagination && result.data.pagination.count;
                stockSchemeCtr.pager.totalPages = Math.ceil(stockSchemeCtr.pager.totalItems / stockSchemeCtr.pager.perPages);
                avalon.vmodels['SchemaListPager'].totalItems = stockSchemeCtr.pager.totalItems;
                avalon.vmodels['SchemaListPager'].totalPages = stockSchemeCtr.pager.totalPages;
                avalon.vmodels['SchemaListPager'].currentPage = stockSchemeCtr.pager.currentPage;
            }
        });
    });
}

function convertState(s){
    if(s == 0){
        return '上架'
    }else if(s == 1){
        return '删除'
    }else if(s == 2){
        return '审核中'
    }else if(s == 3){
        return '下架'
    }else if(s == 4){
        return '审核失败'
    }
}
