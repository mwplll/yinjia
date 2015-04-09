/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */
var schemaModel = {
    thumbUrl: '',
    design_name: '',
    estimate_price: '',
    design_price: '',
    matl_price: '',
    cons_price: '',
    design_deposit: ''
};
var mySchemaCtr = avalon.define({
    $id: "MySchemaController",

    // 默认数据格式，定义一条空的数据 是为了VM绑定
    list: [
        schemaModel
    ],
    pageLevel: base,

    discount: 0.8,
    edit: false,

    buyHandler: function(el){
        alert('TODO');
    },

    editHandler: function(el){
        el.edit = !el.edit;
        if(el.edit){
            el.discount = 1;
        }else{
            el.discount = 0.8;
        }
    },

    removeHandler: function(el, index){
        require(['ArtDialogPlugin'], function () {
            var d = dialog({
                content: "确认删除？",
                cancel: function(){},
                cancelValue: '取消',
                ok: function(){
                   require(["UtilController"], function(AjaxFunc){
                       AjaxFunc.getAction({
                           url: Global_URL['cancelMySchema'],
                           data: {
                               "ids[]": el.id
                           },
                           callback: function(result){
                               mySchemaCtr.list.splice(index,1);
                           }
                       });
                   });
                },
                okValue: '确定',
                quickClose: false
            });
            d.showModal();
        });
    },

    // 购买
    toBuy: function(el, type){
        location.href = '../orders/buyNow.html?type=design&design_id=' + el.id + "&design_type=" + type;
    }
});

require(['UtilController'], function(AjaxFunc){
    AjaxFunc.getAction({
        url: Global_URL['getMyDesignList'],
        callback: function(result){
            result.data.schemaList = result.data.schemaList || [];
            // 补充数据模型
            avalon.each(result.data.schemaList, function(i, item){
                item['thumbUrl'] = image_base + item.mainPic;

                item.discount = 0.8;
                item.edit = false;
            });
            mySchemaCtr.list = result.data.schemaList;
        }
    });
});