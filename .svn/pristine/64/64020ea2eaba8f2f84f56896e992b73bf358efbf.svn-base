headerCtr.cur = 'material';

require(['UtilController'], function(AjaxFunc) {
    var goodID = AjaxFunc.getQueryStringByName('id');
    var prodId = AjaxFunc.getQueryStringByName('pid') || null;

    if(!goodID){
        return;
    }

//    var goodsDetailCtr = avalon.vmodels['GoodsDetailController'];
    goodsDetailCtr.getDetailHandler(goodID, prodId);
});