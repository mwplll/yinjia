/**
 * 用户注册 
 */

var findPwdCtr = avalon.define("FindPwdController", function(vm){
    vm.vType = {
        password: true,
        phoneNumber: true,
        verify:true,

        passwordError: '',
        phoneNumberError: '',
        verifyError: '',

        passwordBlur: false,
        phoneNumberBlur: false,
        verifyBlur: false,

        old: true,
        newPwd: true,

        oldError: '',
        newPwdError: '',

        oldBlur: false,
        newPwdBlur: false
    };
    vm.old = '';
    vm.newPwd = '';
    vm.password = '';
    vm.repassword = '';
    vm.phoneNumber = '';
    vm.verify = '';

    vm.codeText = "获取验证码";

    vm.focus = null;

    vm.step = 0;

    vm.focusHandler = function(target){
        findPwdCtr.focus = target;
        if(target == 'password'){
            findPwdCtr.vType.passwordBlur = false;
        }else if(target == 'userName'){
            findPwdCtr.vType.userNameBlur = false;
        }else if(target == 'phoneNumber'){
            findPwdCtr.vType.phoneNumberBlur = false;
        } else if(target == 'verify'){
            findPwdCtr.vType.verifyBlur = false;
        } else if(target == 'old'){
            findPwdCtr.vType.oldBlur = false;
        }else if(target == 'newPwd'){
            findPwdCtr.vType.newPwdBlur = false;
        }

    };

    vm.blurHandler = function(target){
        findPwdCtr.focus = '';
        if(target == 'password'){
            findPwdCtr.vType.passwordBlur = true;
            findPwdCtr.password.replace(/\s+/g, "");
            if(findPwdCtr.password.length >= 6 && findPwdCtr.password.length <= 20){
                findPwdCtr.vType.password = true;
                findPwdCtr.vType.passwordError = '';
            }else{
                findPwdCtr.vType.password = false;
                findPwdCtr.vType.passwordError = '6-20位字母或数字';
            }
        }
        else if(target == 'verify'){
            findPwdCtr.vType.verifyBlur = true;
            if(findPwdCtr.verify.length > 0){
                findPwdCtr.vType.verify = true;
                findPwdCtr.vType.verifyError = '';
            }else{
                findPwdCtr.vType.verify = false;
                findPwdCtr.vType.verifyError = '请输入验证码';
            }
        }
        else if(target == 'phoneNumber'){
            findPwdCtr.vType.phoneNumberBlur = true;
            findPwdCtr.phoneNumber.replace(/\s+/g, "");
            var phoneNumberR = /^(1[3|5|7|8|][0-9]{9})$/;
            if(phoneNumberR.test(findPwdCtr.phoneNumber)){
                findPwdCtr.vType.phoneNumber = true;
                findPwdCtr.vType.phoneNumberError = '';
            }else{
                findPwdCtr.vType.phoneNumber = false;
                findPwdCtr.vType.phoneNumberError = '请填写正确的手机号码';
            }
        } else if(target == 'newPwd'){
            findPwdCtr.vType.newPwdBlur = true;
            findPwdCtr.newPwd.replace(/\s+/g, "");
            if(findPwdCtr.newPwd.length >= 6 && findPwdCtr.newPwd.length <= 20){
                findPwdCtr.vType.newPwd = true;
                findPwdCtr.vType.newPwdError = '';
            }else{
                findPwdCtr.vType.newPwd = false;
                findPwdCtr.vType.newPwdError = '6-20位字母或数字';
            }
        }else if(target == 'old'){
            findPwdCtr.vType.oldBlur = true;
            findPwdCtr.old.replace(/\s+/g, "");
            if(findPwdCtr.old.length >= 6 && findPwdCtr.old.length <= 20){
                findPwdCtr.vType.old = true;
                findPwdCtr.vType.oldError = '';
            }else{
                findPwdCtr.vType.old = false;
                findPwdCtr.vType.oldError = '6-20位字母或数字';
            }
        }
    };

    vm.passwordType = "password";
    vm.passwordToggle = function() {
        if(vm.passwordType == 'password'){
            vm.passwordType = 'text';
        }
        else
            vm.passwordType = 'password';
    };

    vm.stepHandler = function(){
        if(findPwdCtr.step == 0){
            testHanlder();
        }else{
            findHandler();
        }
    }

    vm.sendCode = regSendCode;

});

var timer;

function regSendCode(){
    findPwdCtr.blurHandler('phoneNumber');
    if(!findPwdCtr.vType.phoneNumber){
        return;
    }
    var phone = {
        tel: findPwdCtr.phoneNumber
    };
    findPwdCtr.codeText = 59;
    var timer = setInterval(function(){
        if(findPwdCtr.codeText <= 1){
            findPwdCtr.codeText = '获取验证码';
            clearInterval(timer);
        }else{
            findPwdCtr.codeText--;
        }
    }, 1000);

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['verify'],
            data: phone,
            callback: function(result){
                Tip.alert('验证码已发送！');
            }
        })
    });
}

function findHandler(){
    if(!findPwdCtr.vType.newPwd){
        Tip.alert("请输入新密码");
        return;
    }
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['resetPwd'],
            data:{
                tel: findPwdCtr.phoneNumber,
                code: findPwdCtr.verify,
                pwd: findPwdCtr.newPwd
            },
            callback: function(){
                Tip.alert("密码修改成功", function(){
                    var headerCtr  = avalon.vmodels['HeaderController'];
                    headerCtr.toLogin();
                });
            }
        });
    });
}

function testHanlder(){
    findPwdCtr.blurHandler('phoneNumber');
    findPwdCtr.blurHandler('verify');
    if(!findPwdCtr.vType.phoneNumber){
        Tip.alert("请输入正确的手机号");
        return;
    }
    if(!findPwdCtr.vType.verify){
        Tip.alert("请输入验证码");
        return;
    }
    require(["UtilController"], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['testTelCode'],
            data: {
                tel: findPwdCtr.phoneNumber,
                code: findPwdCtr.verify
            },
            callback: function(res){
                if(res.data){
                    findPwdCtr.step++;
                }
            }
        })
    });
}