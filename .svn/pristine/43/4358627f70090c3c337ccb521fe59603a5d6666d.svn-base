/**
 * Created by zyc on 2014/10/17.
 */

//封装ajax通用函数

define('UtilController', function(){
    var AjaxFunc = {
        // 读取数据
        getAction: function(opt){
            // 加载jquery
            if(opt.data){
                for( var key in opt.data){
                    opt.url += '&' + key + "=" + opt.data[key];
                }
            }
            require(['jquery'], function($) {
                var option = {
                    url: opt.url,
                    type: 'GET',
                    contentType: 'application/json',
                    dataType: Global_DataType,
                    success: function (result) {
                        if(!result) return;
                        if(result.errorCode == 22000){
                            if(result.msg){
                                require(['ArtDialogPlugin'], function(){
                                    var d = dialog({
                                        content: result.msg,
                                        quickClose: false
                                    });
                                    d.showModal();
                                    setTimeout(function(){
                                        d.close();
                                    },1500);
                                });
                            }
                        }else{
                            if(result.errorCode != 22000 && !opt.alert){
                                if(opt.url.indexOf('data/user/info') >= 0){
                                    return;
                                }
                                if(result.msg){
                                    require(['ArtDialogPlugin'], function(){
                                        var d = dialog({
                                            content: result.msg,
                                            quickClose: false
                                        });
                                        d.showModal();
                                        setTimeout(function(){
                                            d.close();
                                        },1500);
                                    });
                                }
                                return;
                            }
                        }
                        // 处理回调
                        if(opt.callback){
                            opt.callback(result);
                        }
                    }
                };
                if(opt.dataType == 'jsonp'){
                    option['jsonp'] = "callback";
                }

                $.ajax(option);
            });
        },

        // 提交数据
        saveAction: function(opt){
            // 加载jquery
            require('jquery', function($) {
                var option = {
                    url: opt.url,
                    type: opt.method || 'POST',
                    data: opt.data,
                    dataType: "json",
                    success: function (result) {
                        if(!result) return;
                        if(result.errorCode == 22000){
                            if(result.msg){
                                require(['ArtDialogPlugin'], function(){
                                    var d = dialog({
                                        content: result.msg,
                                        quickClose: false
                                    });
                                    d.showModal();
                                    setTimeout(function(){
                                        d.close();
                                    },1500);
                                });
                            }
                        }else{
                            if(result.errorCode != 22000){
                                if(result.msg){
                                    require(['ArtDialogPlugin'], function(){
                                        var d = dialog({
                                            content: result.msg,
                                            quickClose: false
                                        });
                                        d.showModal();
                                        setTimeout(function(){
                                            d.close();
                                        },1500);
                                    });
                                }
                                return;
                            }
                        }

                        // 处理回调
                        if(opt.callback){
                            opt.callback(result);
                        }
                    }
                };
                if(opt.crossDomain){
                    option['crossDomain'] = true;
                    option['xhrFields'] = {
                        withCredentials: true
                    };
                }
//                if(opt.contentType){
//                    option['contentType'] = opt.contentType;
//                }
                $.ajax(option);
            });
        },

        //获取QueryString的数组
        getQueryString: function(){
            var result = location.search.match(new RegExp("[\?\&][^\?\&]+=[^\?\&]+","g"));
            for(var i = 0; i < result.length; i++){
                result[i] = result[i].substring(1);
            }
            return result;
        },

        //根据QueryString参数名称获取值
        getQueryStringByName: function(name){
            var result = location.search.match(new RegExp("[\?\&]" + name+ "=([^\&]+)","i"));
            if(result == null || result.length < 1){
                return "";
            }
            return result[1];
        },
        /*
         *功能：设置Cookie
         *cookieName 必选项，cookie名称
         *cookieValue 必选项，cookie值
         *seconds 生存时间，可选项，单位：秒；默认时间是3600 * 24 * 7秒
         *path cookie存放路径，可选项
         *domain cookie域，可选项
         *secure 安全性，指定Cookie是否只能通过https协议访问，一般的Cookie使用HTTP协议既可访问，如果设置了Secure（没有值），则只有当使用https协议连接时cookie才可以被页面访问
         */
        setCookie: function (cookieName, cookieValue, seconds, path, domain, secure) {
            var expires = new Date();
            var seconds = arguments[2] ? arguments[2] : 3600 * 24 * 7;
            expires.setTime(expires.getTime() + seconds * 1000);
            document.cookie = escape(cookieName) + '=' + escape(cookieValue) + (expires ? ';expires=' + expires.toGMTString() : '') + (path ? ';path=' + path : '/') + (domain ? ';domain=' + domain : '') + (secure ? ';secure' : '');
        },
        /*
         *功能：获取Cookie
         *name 必选项，cookie名称
         */
        getCookie: function (name) {
            var cookie_start = document.cookie.indexOf(name);
            var cookie_end = document.cookie.indexOf(";", cookie_start);
            return cookie_start == -1 ? '' : unescape(document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
        },

        /*
         *功能：删除或清空Cookie
         *name 必选项，cookie名称
         */
        delCookie: function (name, value) {
            var value = arguments[1] ? arguments[1] : null;
            var exp = new Date();
            exp.setTime(exp.getTime() - 1);
            var val = this.getCookie(name);
            if (val != null) {
                document.cookie = name + '=' + value + ';expires=' + exp.toGMTString();
            }
        }

    };

    return AjaxFunc;
});
