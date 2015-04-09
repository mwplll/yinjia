/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */
var schemeModel = {
    thumbUrl: '',
    design_name: '',
    estimate_price: '',
    design_price: '',
    matl_price: '',
    cons_price: '',
    design_deposit: ''
};
var schemeListCtr = avalon.define({
    $id: "SchemeListController",

    // 默认数据格式，定义一条空的数据 是为了VM绑定
    list: [
        schemeModel
    ],
    pageLevel: base,

    // 购买
    toBuy: function(el, type){
        location.href = '../orders/buyNow.html?type=design&design_id=' + el.design_schema_id + "&design_type=" + type;
        return;
        require([
            'ArtDialogPlugin',
            "text!../../user/views/buy-dialog.html"
        ], function(_, html){
            var d = dialog({
                fixed: true,
                width: 512,
                height: 315,
                content: html
            });
            avalon.scan();
            d.showModal();
        });
    }
});

require(['UtilController'], function(AjaxFunc){
    AjaxFunc.getAction({
        url: Global_URL['getMyDesignList'],
        dataType: Global_DataType,
        callback: function(result){
            result.data = result.data || [];
            // 补充数据模型
            avalon.each(result.data, function(i, item){
                item['thumbUrl'] = image_base + item.main_pic;
            });
            schemeListCtr.list = result.data;
        }
    });
})