/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/2
 * description:
 */

var passwordCtr = avalon.define("PasswordController", function(vm){
    vm.toggle = false;
    vm.toggleHandler = function(bool){
        passwordCtr.toggle = bool;
    };
    vm.vType = {
        old: true,
        newPwd: true,

        oldError: '',
        newPwdError: '',

        oldBlur: false,
        newPwdBlur: false
    };
    vm.old = '';
    vm.newPwd = '';
    vm.focus = null;
    vm.focusHandler = function(target){
        passwordCtr.focus = target;
        if(target == 'old'){
            passwordCtr.vType.oldBlur = false;
        }else if(target == 'newPwd'){
            passwordCtr.vType.newPwdBlur = false;
        }
    };
    vm.blurHandler = function(target){
        passwordCtr.focus = '';
        if(target == 'newPwd'){
            passwordCtr.vType.newPwdBlur = true;
            passwordCtr.newPwd.replace(/\s+/g, "");
            if(passwordCtr.newPwd.length >= 6 && passwordCtr.newPwd.length <= 20){
                passwordCtr.vType.newPwd = true;
                passwordCtr.vType.newPwdError = '';
            }else{
                passwordCtr.vType.newPwd = false;
                passwordCtr.vType.newPwdError = '6-20位字母或数字';
            }
        }else if(target == 'old'){
            passwordCtr.vType.oldBlur = true;
            passwordCtr.old.replace(/\s+/g, "");
            if(passwordCtr.old.length >= 6 && passwordCtr.old.length <= 20){
                passwordCtr.vType.old = true;
                passwordCtr.vType.oldError = '';
            }else{
                passwordCtr.vType.old = false;
                passwordCtr.vType.oldError = '6-20位字母或数字';
            }
        }
    };
    vm.saveHandler = function(){
        if(!passwordCtr.old){
            Tip.alert("请输入旧密码");
            return;
        }
        if(!passwordCtr.vType.newPwd){
            Tip.alert("请输入新密码");
            return;
        }
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['updatePassword'],
                data:{
                    oldPwd: passwordCtr.old,
                    newPwd: passwordCtr.newPwd
                },
                callback: function(){
                    Tip.alert("密码修改成功");
                    passwordCtr.toggle = false;
                    passwordCtr.old = '';
                    passwordCtr.newPwd = '';
                }
            })
        });
    }
});
var emailCtr = avalon.define("EmailController", function(vm){
    vm.toggle = false;
    vm.toggleHandler = function(bool){
        emailCtr.toggle = bool;
    };
    vm.email1 = '';
    vm.email = '';

    vm.vType = {
        email: true,
        emailError: '',
        emailBlur: false
    };

    vm.focus = null;

    vm.focusHandler = function(target){
        emailCtr.focus = target;
        if(target == 'email'){
            emailCtr.vType.emailBlur = false;
        }
    };
    vm.blurHandler = function(target){
        emailCtr.focus = '';
        if(target == 'email'){
            emailCtr.vType.emailBlur = true;
            emailCtr.email.replace(/\s+/g, "");
            var emailR =/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;
            if(emailR.test(emailCtr.email)){
                emailCtr.vType.email = true;
                emailCtr.vType.emailError = '';
            }else{
                emailCtr.vType.email = false;
                emailCtr.vType.emailError = '请填写正确的邮箱地址';
            }
        }
    };
    vm.saveHandler = function(){
        if(!emailCtr.email || !emailCtr.vType.email){
            Tip.alert("请输入正确邮箱");
            return;
        }
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['updateEmail'],
                data:{
                    email: emailCtr.email
                },
                callback: function(){
                    Tip.alert("邮箱修改成功");
                    emailCtr.toggle = false;
                    emailCtr.email1 = emailCtr.email;

                    calScore();
                }
            })
        });
    }
});
var mobileCtr = avalon.define("MobileController", function(vm){
    vm.toggle = false;
    vm.toggleHandler = function(bool){
        mobileCtr.toggle = bool;
    };
    vm.mobile = '';
    vm.phoneNumber = '';
    vm.verify = '';
    vm.codeText = "获取验证码";
    vm.vType = {
        phoneNumber: true,
        verify:true,
        phoneNumberError: '',
        verifyError: '',
        phoneNumberBlur: false,
        verifyBlur: false
    };
    vm.focus = null;

    vm.focusHandler = function(target){
        mobileCtr.focus = target;
        if(target == 'password'){
            mobileCtr.vType.passwordBlur = false;
        }else if(target == 'phoneNumber'){
            mobileCtr.vType.phoneNumberBlur = false;
        } else if(target == 'verify'){
            mobileCtr.vType.verifyBlur = false;
        }

    };
    vm.blurHandler = function(target){
        mobileCtr.focus = '';
       if(target == 'verify'){
            mobileCtr.vType.verifyBlur = true;
            if(mobileCtr.verify.length > 0){
                mobileCtr.vType.verify = true;
                mobileCtr.vType.verifyError = '';
            }else{
                mobileCtr.vType.verify = false;
                mobileCtr.vType.verifyError = '请输入验证码';
            }
        }
        else if(target == 'phoneNumber'){
            mobileCtr.vType.phoneNumberBlur = true;
            mobileCtr.phoneNumber.replace(/\s+/g, "");
            var phoneNumberR = /^(1[3|5|7|8|][0-9]{9})$/;
            if(phoneNumberR.test(mobileCtr.phoneNumber)){
                mobileCtr.vType.phoneNumber = true;
                mobileCtr.vType.phoneNumberError = '';
            }else{
                mobileCtr.vType.phoneNumber = false;
                mobileCtr.vType.phoneNumberError = '请填写正确的手机号码';
            }
        }
    };
    vm.saveHandler = function(){
        if(!mobileCtr.phoneNumber || !mobileCtr.vType.phoneNumber){
            Tip.alert("请输入手机号");
            return;
        }
        if(!mobileCtr.verify || !mobileCtr.vType.verify){
            Tip.alert("请输入验证码");
            return;
        }
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['updateTel'],
                data:{
                    tel: mobileCtr.phoneNumber,
                    code: mobileCtr.verify
                },
                callback: function(){
                    Tip.alert("手机号修改成功");
                    mobileCtr.mobile = mobileCtr.phoneNumber;

                    mobileCtr.toggle = false;
                    mobileCtr.verify = '';

                    calScore();
                }
            })
        });
    };
    vm.sendCode = function(){
        mobileCtr.blurHandler('phoneNumber');

        if(!mobileCtr.vType.phoneNumber){
            return;
        }

        var phone = {
            tel: mobileCtr.phoneNumber
        };
        mobileCtr.codeText = 59;
        var timer = setInterval(function(){
            if(mobileCtr.codeText <= 1){
                mobileCtr.codeText = '获取验证码';
                clearInterval(timer);
            }else{
                mobileCtr.codeText--;
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
});

require(['UtilController'], function(AjaxFunc){
    AjaxFunc.getAction({
        url: Global_URL['userInfo'],
        callback: function(result){
            if(result.errorCode != 22000){
                return;
            }
            mobileCtr.mobile = result.data.tel || '';
            mobileCtr.phoneNumber = result.data.tel || '';
            emailCtr.email1 = result.data.email || '';
            emailCtr.email = result.data.email || '';

            calScore();
        }
    })
});


function calScore(){

    var total = 100;
    if(!mobileCtr.mobile){
        total -= 60;
    }
    if(!emailCtr.email1){
        total -= 40;
    }

    require("jquery", function(){
        $(".knob").val(total).trigger('change');
        if(total == 100){
            $('.knob').trigger(
                'configure',
                {
                    "fgColor":"#2ABB69"
                }
            );
        }
    });
}