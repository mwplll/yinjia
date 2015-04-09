/**
 * Created by zyc on 2014/11/17.
 */

/**
 *  Header控制器
 */
var headerCtr;
headerCtr = avalon.define("HeaderController",function(vm){
    // 快捷导航栏的当前位置 ['index', 'design', 'material', 'service', 'house']
    vm.cur = '';

    vm.pageLevel = base;
    vm.hasLogin = false;

    vm.headImageUrl = base + 'images/designer-02.png';

    vm.setCurHandler = function(nav){
        headerCtr.cur = nav;
    };

    // 登录
    vm.toLogin = function(){
        require([
            'ArtDialogPlugin',
            'SignInController',
            "text!../../sign/views/signIn-dialog.html"
        ], function(_, __, html){
            var d = dialog({
                fixed: true,
                width: 360,
                height: 440,
                content: html
            });
            avalon.scan();
            d.showModal();
        });
    };

    // 注册
    vm.toSignUp = function(){
        location.href = base + 'sign/signUp.html';
    };

    // 登出
    vm.logoutHandler = function(){
        require("UtilController", function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['logout'],
                callback: function(result){
                    if(result.errorCode!=22000){
                        alert("退出失败");
                        return;
                    }
                    location.href = base + 'index.html';
                }
            });
        });
    };

    vm.city = '';
    vm.cityId = '';
    vm.cityChange = function(el, index){
        if(headerCtr.city == el[1]){
            return;
        }
        headerCtr.city = el[1];
        headerCtr.cityId = el[0];

        require(["UtilController"], function(AjaxFunc){
            AjaxFunc.setCookie("city2", el[1], 3600 * 24 * 7, '/');
            AjaxFunc.setCookie("cityId2", el[0], 3600 * 24 * 7, '/');

            headerCtr.toggleCity = false;
            location.reload();
        });
    };

    vm.toggleCity = false;
    vm.toggleCityHandler = function(){
        headerCtr.toggleCity = !headerCtr.toggleCity;
    };

    vm.userName = '';
    vm.is_designer = false;
    vm.is_designer = 0;

    // 检查登录
    vm.checkLogin = function(){
        require(['UtilController'], function(AjaxFunc){
            var city = AjaxFunc.getCookie('city2');
            var cityId = AjaxFunc.getCookie('cityId2');
            cityId = Number(cityId);
            if(!cityId){
                headerCtr.city = CITY[0][1];
                headerCtr.cityId = CITY[0][0];
            }else{
                headerCtr.city = city;
                headerCtr.cityId = AjaxFunc.getCookie('cityId2');
            }

            AjaxFunc.getAction({
                url: Global_URL['whoAmI'],
                callback: function(result){
                    if(result.errorCode != 22000){
                        return;
                    }
                    if(!result.data.id){
                        return;
                    }
                    if(result.data){
                        headerCtr.userName = result.data.userName;

                        if(result.data.avatar){
                            headerCtr.headImageUrl = image_base + result.data.avatar;
                        }else{
                            headerCtr.headImageUrl = base + 'images/designer-02.png';
                        }

                        headerCtr.hasLogin = true;

                        headerCtr.is_special = Number(result.data.isSpecial);
                        headerCtr.is_checked = Number(result.data.state);

                        if(headerCtr.is_special == 1 && headerCtr.is_checked == 1){ // 设计师用户
                            headerCtr.is_designer = true;
                        }else if(headerCtr.is_special >= 10){
                            headerCtr.is_designer = true;
                        }

                    }else{
                        headerCtr.hasLogin = false;
                    }
                }
            })
        });
    };

    vm.publishHandler = function(type){
        if(!headerCtr.is_designer){
            location.href =  base + 'account/authorized.html'
        }else{
            if(type == 'center'){
                location.href = base + 'design-center/designer.html';
            }else if(type == 'order'){
                location.href = base + 'design-center/order-management.html'
            }else{
                location.href = base + 'design-center/publish-step1.html'
            }
        }
    };

    vm.search_visible = true;

    vm.cities = [];
});

var CITY = [
    ["330100","杭州","330000"],
    [ "330500", "湖州", "330000"],
    ["330400", "嘉兴", "330000"],
    ["330700", "金华", "330000"],
    [ "331100", "丽水", "330000"],
    ["330200", "宁波", "330000"],
    ["330800", "衢州", "330000"],
    ["330600", "绍兴", "330000"],
    ["331000", "台州", "330000"],
    ["330300", "温州", "330000"],
    ["330900", "舟山", "330000"]
];

headerCtr.cities = CITY;

headerCtr.checkLogin();

/********************************** ngProgress *********************************************/
NProgress.start();
var interval = setInterval(function() { NProgress.inc(); }, 200);

setTimeout(function(){
    clearInterval(interval);
    NProgress.done();
}, 1000);
/********************************** ngProgress *********************************************/
