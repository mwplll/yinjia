/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
Ext.define("LoginFunc", {

    /**
     * 检查是否已经登录过
     */
    onWhoami: function (callbacks) {
        this.success = callbacks.success || null;
        this.fail = callbacks.fail || null;

        var self = this;
        Ext.Ajax.request({
            url: HOST_URL + 'user/whoAmI',
            success: function (resp, opts) {
                var respText = Ext.JSON.decode(resp.responseText);
                if (respText.success && respText.value) {
                    // 已登录
                    self.success && self.success(respText.value);
                } else {
                    // 未登录
                    self.fail && self.fail();
                }
            }
        });
    },
    /**
     * 登录操作
     * @param paramsObj
     */
    onLogin: function (paramsObj) {
        this.success = paramsObj.callbacks.success || null;
        this.fail = paramsObj.callbacks.fail || null;

        var self = this;
        Ext.Ajax.request({
            url: HOST_URL + 'user/login',
            jsonData: Ext.JSON.encode(paramsObj.values),
            success: function (resp, opts) {
                var respText = Ext.JSON.decode(resp.responseText);
                if (respText.success) {
                    self.success && self.success(respText); // 登录成功回调
                } else {
                    self.fail && self.fail(); // 登录失败回调
                }
            },
            fail: function () {
                alert("登录失败！");
            }
        });
    },

    // 退出操作
    onLogout: function (callbacks) {
        this.success = callbacks.success || null;
        this.fail = callbacks.fail || null;

        var self = this;
        Ext.Msg.confirm('退出', "确认退出系统?", function (btn) {
            if (btn == 'yes') {
                Ext.Ajax.request({
                    url: HOST_URL + 'user/logout',
                    success: function (resp) {
                        var respText = Ext.JSON.decode(resp.responseText);
                        if (respText.success) {
                            self.success && self.success();
                        } else {
                            self.fail && self.fail();
                        }
                    }
                });
            }
        });
    }
});


Ext.define("utilFunc", {

    // 获取cookie值
    getCookie: function (Name) {
        var search = Name + "=";
        if (document.cookie.length > 0) {
            var offset = document.cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                var end = document.cookie.indexOf(";", offset);
                if (end == -1) end = document.cookie.length;
                return unescape(document.cookie.substring(offset, end))
            }
            else return ""
        }
        return "";
    },

    createNode: function (list) {
        var me = this;
        var treeNodes = [];
        Ext.each(list, function (obj) {
            var item = {
                text: obj.name,
                level: obj.level,
                createTime: obj.createTime,
                categoryId: obj.id
            };
            item.children = [];
            if (obj.childCategories && obj.childCategories.length) {
                item.children = me.createNode(obj.childCategories);
            }
            treeNodes.push(item);
        });
        return treeNodes;
    },

    // 计算游览器可视区域的大小
    getWindowHeight: function getWindowHeight() {
        var de = document.documentElement;
        return self.innerHeight || (de && de.clientHeight) || document.body.clientHeight;
    },

    getWindowWidth: function getWindowWidth() {
        var de = document.documentElement;
        return self.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
    }
});