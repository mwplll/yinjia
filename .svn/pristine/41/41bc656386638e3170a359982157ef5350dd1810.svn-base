/**
 * 用户注册 
 */

var signUpCtr = avalon.define("SignUpController", function(vm){
    vm.vType = {
        userName: true,
        password: true,
        phoneNumber: true,
        verify:true,

        userNameError: '',
        passwordError: '',
        phoneNumberError: '',
        verifyError: '',

        userNameBlur: false,
        passwordBlur: false,
        phoneNumberBlur: false,
        verifyBlur: false
    };

    vm.userName = '';
    vm.password = '';
    vm.repassword = '';
    vm.phoneNumber = '';
    vm.verify = '';

    vm.agreeCheck = true;
    vm.agreeHandler = function(bool){
        signUpCtr.agreeCheck = bool;
    };


    vm.codeText = "获取验证码";

    vm.focus = null;

    vm.focusHandler = function(target){
        signUpCtr.focus = target;
        if(target == 'password'){
            signUpCtr.vType.passwordBlur = false;
        }else if(target == 'userName'){
            signUpCtr.vType.userNameBlur = false;
        }else if(target == 'phoneNumber'){
            signUpCtr.vType.phoneNumberBlur = false;
        } else if(target == 'verify'){
            signUpCtr.vType.verifyBlur = false;
        } 

    };

    vm.blurHandler = function(target){
        signUpCtr.focus = '';
        if(target == 'userName'){
            signUpCtr.vType.userNameBlur = true;
            signUpCtr.userName.replace(/\s+/g, "");
            if(!signUpCtr.userName){
                signUpCtr.vType.userName = false;
                signUpCtr.vType.userNameError = '用户名错误';
            }else{
                signUpCtr.vType.userName = true;
                signUpCtr.vType.userNameError = '';
            }
        }else if(target == 'password'){
            signUpCtr.vType.passwordBlur = true;
            signUpCtr.password.replace(/\s+/g, "");
            if(signUpCtr.password.length >= 6 && signUpCtr.password.length <= 20){
                signUpCtr.vType.password = true;
                signUpCtr.vType.passwordError = '';
            }else{
                signUpCtr.vType.password = false;
                signUpCtr.vType.passwordError = '6-20位字母或数字';
            }
        }
        else if(target == 'verify'){
            signUpCtr.vType.verifyBlur = true;
            if(signUpCtr.verify.length > 0){
                signUpCtr.vType.verify = true;
                signUpCtr.vType.verifyError = '';
            }else{
                signUpCtr.vType.verify = false;
                signUpCtr.vType.verifyError = '请输入验证码';
            }
        }
        else if(target == 'phoneNumber'){
            signUpCtr.vType.phoneNumberBlur = true;
            signUpCtr.phoneNumber.replace(/\s+/g, "");
            var phoneNumberR = /^(1[3|5|7|8|][0-9]{9})$/;
            if(phoneNumberR.test(signUpCtr.phoneNumber)){
                signUpCtr.vType.phoneNumber = true;
                signUpCtr.vType.phoneNumberError = '';
            }else{
                signUpCtr.vType.phoneNumber = false;
                signUpCtr.vType.phoneNumberError = '请填写正确的手机号码';
            }
        }
    };

    vm.keydown = function(e){
        if(e.keyCode == 13){
            signUpCtr.register();
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

    vm.register = regHandler;

    vm.regSuccess = false;

    vm.sendCode = regSendCode;

});

var timer;

function regSendCode(){
    signUpCtr.blurHandler('phoneNumber');
    if(signUpCtr.codeText != '获取验证码'){
        return;
    }
    if(!signUpCtr.vType.phoneNumber){
        return;
    }

    var phone = {
        tel: signUpCtr.phoneNumber
    };
    signUpCtr.codeText = 59;
    var timer = setInterval(function(){
        if(signUpCtr.codeText <= 1){
            signUpCtr.codeText = '获取验证码';
            clearInterval(timer);
        }else{
            signUpCtr.codeText--;
        }
    }, 1000);

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['verify'],
            data: phone,
            dataType:Global_DataType,
            callback: function(result){
                Tip.alert('验证码已发送！');
            }
        })
    });
}



function regHandler(){
    if(!signUpCtr.agreeCheck){
        return;
    }
    signUpCtr.blurHandler('userName');
    signUpCtr.blurHandler('phoneNumber');
    signUpCtr.blurHandler('password');
    signUpCtr.blurHandler('verify');

    if(!signUpCtr.vType.userName ||
        !signUpCtr.vType.password ||
        !signUpCtr.vType.phoneNumber ||
        !signUpCtr.vType.verify
        ){
        return;
    }
    var user = {
        userName: signUpCtr.userName,
        pwd: signUpCtr.password,
        tel: signUpCtr.phoneNumber,
        code: signUpCtr.verify
    };

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['signUp'],
            data: user,
            callback: function(result){
                if(result.errorCode!=22000){
                    result.msg = result.msg || '注册失败';
                    alert(result.msg);
                    return;
                }
                // 注册成功
                location.href = '../index.html'
            }
        })
    });
}