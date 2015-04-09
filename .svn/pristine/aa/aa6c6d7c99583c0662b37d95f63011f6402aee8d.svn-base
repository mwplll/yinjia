/**
 * Created by zyc on 2014/11/18.
 */
var signIn  = avalon.define("SignInController",function(vm){
     vm.userName = '';
     vm.password = '';
     vm.pageLevel = base;

     vm.keydown = function(e){
         if(e.keyCode == 13){
             loginHandler();
         }
     };

     vm.login = loginHandler;
     vm.agreeCheck = false;
     vm.agreeHandler = function(bool){
         signIn.agreeCheck = bool;
     };
     vm.isError = false;

    vm.passwordType = "password";
    vm.passwordToggle = function() {
        if(vm.passwordType == 'password'){
            vm.passwordType = 'text';
        }
        else
            vm.passwordType = 'password';
    };
});
function loginHandler(){
    var user = {
        user: signIn.userName,
        pwd: signIn.password
    };
    if(!user.user){
        Tip.alert("请输入用户名");
        return;
    }
    if(!user.pwd){
        Tip.alert("请输入密码");
        return;
    }
    if(!user.user || !user.pwd){
        signIn.isError = true;

        return;
    }

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['signIn'],
            data: user,
            callback: function(result){
                if(result.errorCode!=22000){
                    alert("登录失败");
                    return;
                }
                // 登录成功
               location.reload();
            }
        });
    });
}
