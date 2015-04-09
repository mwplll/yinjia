/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-4-2
 * Time: 上午10:27
 * To change this template use File | Settings | File Templates.
 */
Ext.AjaxUtil = {
    getAction: function(opt){
        var option = {
            url: opt.url,
            data: opt.data|| null,
            type: 'GET',
            contentType: 'application/json',
            dataType: Global_DataType_Jquery,
            success: function (result) {
                if(!result) return;
                if(result.errorCode == 22000){
                    if(result.msg){
                        Ext.example.msg('提示', result.msg);
                    }
                }else{
                    if(result.errorCode != 22000){
                        if(result.msg){
                            Ext.example.msg('提示', result.msg);
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
        if(Global_DataType == 'jsonp'){
            option['jsonp'] = "callback";
        }

        $.ajax(option);
    },

    getActionAndReturn: function(opt){
        var option = {
            url: opt.url,
            data: opt.data|| null,
            type: 'GET',
            contentType: 'application/json',
            dataType: Global_DataType_Jquery,
            success: function (result) {
                if(!result) return;
                // 处理回调
                if(opt.callback){
                    opt.callback(result);
                }
            }
        };
        if(Global_DataType == 'jsonp'){
            option['jsonp'] = "callback";
        }

        $.ajax(option);
    },

    saveAction: function(opt){
        var option = {
            url: opt.url,
            type: opt.method || 'POST',
            data: opt.data,
            dataType: "json",
            success: function (result) {
                if(!result) return;
                if(result.errorCode == 22000){
                    if(result.msg){
                        Ext.example.msg('提示', result.msg);
                    }
                }else{
                    if(result.errorCode != 22000){
                        if(result.msg){
                            Ext.example.msg('提示', result.msg);
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
        $.ajax(option);
    },

    saveRequest: function (paramsObj, maskParent) {
        var success,successMsg,failMsg,url,data,method;
        var mask = null;

        success = paramsObj.success || null;
        successMsg = paramsObj.successMsg || null;
        url = paramsObj.url || null;
        data = paramsObj.data || null;
        method = paramsObj.method || "POST";

        if (maskParent) {
            mask = new Ext.LoadMask(maskParent, {
                msg: "请稍后...",
                removeMask: true
            });
            mask.show();
        }

        var options = {
            url: url,
            params: data,
            method: method,
            success: function (resp, opts) {
                var respText;
                if(resp.responseText){
                    respText = Ext.JSON.decode(resp.responseText)
                }else{
                    respText = resp;
                }
                if (mask) {
                    mask.hide();
                }
                if (respText.errorCode == 22000) {
                    if (successMsg) {
                        Ext.example.msg('提示', successMsg + "!");
                    }
                    if (success) {
                        success(respText);
                    }
                }else {
                    if(respText.msg){
                        Ext.example.msg('提示', respText.msg);
                    }
                }
            }
        };
        if(Global_DataType == 'jsonp' && method == 'GET'){
            options['callback'] = "callback";
            Ext.data.JsonP.request(options)
        }else{
            if(method == 'POST'){
                options['jsonData'] = Ext.JSON.encode(data);
                options['scriptTag'] = true;
                options['scriptTag'] = true;
            }
            Ext.Ajax.cors = true;
            Ext.Ajax.useDefaultHeader = false;
            Ext.Ajax.request(options);
        }
    }
};