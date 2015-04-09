/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/2
 * description:
 */

var _dialogs_ = {"upload": null};
var authorizedCtr = avalon.define("AuthorizedController", function(vm){
    vm.face = '';
    vm.back = '';
    vm.faceUrl = '';
    vm.backUrl = '';

    vm.name = '';
    vm.IDNumber = '';
    vm.designer_id = null;

    vm.pageLevel = base;
    vm.type = '';
    vm.qq = '';
    vm.alipay = '';

    vm.auditResult = {
        success: false,
        reason: ''
    };

    vm.step = "step1";
    vm.stepHandler = function(step){
        authorizedCtr.step = step;
    };

    vm.uploadHandler = function(type){
        authorizedCtr.type = type;
        require([
            'ArtDialogPlugin',
            'UploadCardController',
            "text!../../account/views/upload-dialog.html"
        ], function(_,__, html){
            var d = dialog({
                fixed: true,
                width: 700,
                height: 350,
                content: html
            });
            avalon.scan();
            d.showModal();
            _dialogs_['upload'] = d;
            uploadCtr.initHandler();
        });
    };

    vm.removePicHandler = function(type){
        if(type == 'face'){
            authorizedCtr.face = '';
            authorizedCtr.faceUrl = '';
        }else{
            authorizedCtr.back = '';
            authorizedCtr.backUrl = '';
        }
    };

    vm.saveHandler = function(){
        var pd = {
            id: authorizedCtr.designer_id || null,
            realName: authorizedCtr.name,
            cid: authorizedCtr.IDNumber,
            cidFrontPic: authorizedCtr.face,
            cidBackPic: authorizedCtr.back,
            qq: authorizedCtr.qq,
            alipay: authorizedCtr.alipay,
        };
        var re = validateHandler(pd);
        if(!re.success){
            require(['ArtDialogPlugin'], function(){
                var d = dialog({
                    content: re.message,
                    quickClose: false
                });
                d.showModal();
                setTimeout(function(){
                    d.close();
                },1500);
            });
            return;
        }
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.saveAction({
                url: Global_URL['saveCard'],
                data: pd,
                crossDomain: Global_CrossDomain,
                callback: function(result){
                    authorizedCtr.step = 'step3';
                    authorizedCtr.auditResult['success'] = 2;
                }
            });
        });
    };

    // 确认上传
    vm.confirmHandler = function(){
        if(!uploadCtr.list.length || !uploadCtr.list[0].serial){
            require(['ArtDialogPlugin'], function(){
                var d = dialog({
                    content: '请选择图片上传',
                    quickClose: false
                });
                d.showModal();
                setTimeout(function(){
                    d.close();
                },1500);
            });
            return;
        }
        var pic = uploadCtr.list[0].serial;
        if(authorizedCtr.type == 'face'){
            authorizedCtr.face = pic;
            authorizedCtr.faceUrl = image_base + pic;
        }else{
            authorizedCtr.back = pic;
            authorizedCtr.backUrl = image_base + pic;
        }

        _dialogs_['upload'].close();
    }
});

require('UtilController', function(AjaxFunc){
    AjaxFunc.getAction({
        url: Global_URL['whoAmI'],
        callback: function(result){
            if(result.errorCode != 22000){
                return;
            }
            var is_special = Number(result.data.isSpecial);

            if(is_special == 1){
                if(!result.data){
                    authorizedCtr.step = 'step1';
                    return;
                }
                var bool = Number(result.data.state);
                authorizedCtr.step = 'step3';
                authorizedCtr.auditResult['success'] = Number(result.data.state);

                if(bool == 0){
                    authorizedCtr.auditResult['reason'] = result.data.reason;
                }

                authorizedCtr.designer_id = result.data.id;
                authorizedCtr.name = result.data.realName;
                authorizedCtr.IDNumber = result.data.cid;
                authorizedCtr.face = result.data.cidFrontPic;
                authorizedCtr.faceUrl = image_base + result.data.cidFrontPic;
                authorizedCtr.back = result.data.cidBackPic;
                authorizedCtr.backUrl = image_base + result.data.cidBackPic;
            }else if(is_special >= 10){
                authorizedCtr.step = 'admin';
            }else{
                authorizedCtr.step = 'step1';
            }
        }
    });
});


function validateHandler(pd){
    var fg = true, msg = '';
    if(!pd.realName){
        fg = false;
        msg = '请填写真实姓名';
        return {
            success: fg,
            message: msg
        }
    }
    if(!pd.qq){
        fg = false;
        msg = '请填写QQ';
        return {
            success: fg,
            message: msg
        }
    }
    if(!pd.alipay){
        fg = false;
        msg = '请填写支付宝账号';
        return {
            success: fg,
            message: msg
        }
    }
    if(!pd.cid){
        fg = false;
        msg = '请填写身份证号';
        return {
            success: fg,
            message: msg
        }
    }
    if(!pd.cidFrontPic){
        fg = false;
        msg = '请上传身份证正面照';
        return {
            success: fg,
            message: msg
        }
    }
    if(!pd.cidBackPic){
        fg = false;
        msg = '请上传身份证背面照';
        return {
            success: fg,
            message: msg
        }
    }
    return{
        success: true
    }
}