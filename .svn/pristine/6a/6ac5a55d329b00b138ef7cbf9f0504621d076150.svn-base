/**
 * Created by Personal on 2014/4/15.
 */

var _dialogs_ =  {'address': null};
var addressListCtr = avalon.define("AddressListController", function(vm){
    vm.list = [];
    vm.selectedIndex = null;

    // 新增或编辑
    vm.showHandler = function(el){
        require([
            'ArtDialogPlugin',
            'AddressFormController',
            "text!../../user/views/address-dialog.html"
        ], function(_, __, html){
            var d = dialog({
                fixed: true,
                width: 565,
                height: 500,
                content: html
            });
            avalon.scan();
            d.showModal();
            _dialogs_['address'] = d;
            addressForm.initForUpdate(el);
        })
    };

    vm.isShowAll = false;
    vm.showAllAddress = function(bool){
        addressListCtr.isShowAll = bool;
    };

    // 删除
    vm.removeHandler = function(el, index){
        require("ArtDialogPlugin", function(){
            var d = dialog({
                fixed: true,
                width: 360,
                height: 60,
                content: "<div style='text-align: center; font-size: 20px;padding: 30px;'>确认删除？</div>",
                okValue: '确认',
                cancelValue: '取消',
                ok: function(){
                    require("UtilController", function(AjaxFunc){
                        AjaxFunc.getAction({
                            url: Global_URL['deleteAddress'],
                            dataType: Global_DataType,
                            data: {id: el.id},
                            callback: function(){
                                addressListCtr.list.splice(index, 1);
                            }
                        })
                    });
                },
                cancel: function(){}
            });
            avalon.scan();
            d.showModal();
        });
    };
    // 设为默认
    vm.setDefaultHandler = function(el){
        require("UtilController", function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['setDefaultAddress'],
                dataType: Global_DataType,
                data: {id: el.id},
                callback: function(){
                    avalon.each(addressListCtr.list, function(i, item){
                        if(item.id == el.id){
                            item.isDefault = true;
                        }else{
                            item.isDefault = false;
                        }
                    });
                }
            })
        });
    };

    // 选中
    vm.selectHandler = function(index){
        addressListCtr.selectedIndex = index;
    };
});

listAddress();

function listAddress(){
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getAddressList'],
            callback: function(result){
                var list = result.data || [];
                avalon.each(list, function(i, it){
                    it.isDefault = Boolean(Number(it.isDefault));
                    if(it.isDefault){
                        addressListCtr.selectedIndex = i;
                    }
                });
                addressListCtr.list = list;
            }
        });
    });
}

