/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午5:34
 * To change this template use File | Settings | File Templates.
 */
// ExtJs的store使用proxy方式传递数据 默认使用get方法传参数；
// 设置proxy中的 read 方式 为“post”时, 使用form data的形式传参；
// hack 现在重写proxy.Ajax方法， 使设置read为“post”时，支持以json的方式传参
Ext.override(Ext.data.proxy.Ajax, {
    doRequest: function (operation, callback, scope) {
        var writer = this.getWriter(),
            request = this.buildRequest(operation, callback, scope);

        if (operation.allowWrite()) {
            request = writer.write(request);
        }

        Ext.apply(request, {
            headers: this.headers,
            timeout: this.timeout,
            scope: this,
            callback: this.createRequestCallback(request, operation, callback, scope),
            method: this.getMethod(request),
            disableCaching: false, // explicitly set it to false, ServerProxy handles caching

            failure: function (resp) {
                if (resp.status == 401) {
                    alert('未登录......');
                    // 刷新页面
                    window.location.reload();
                }
                if (resp.status == 500) {
                    console.log('login 500');
                }
            }
        });

        // 修改的地方——proxy中加入一个属性jsonData(boolean)判断 POST 中是否以json方式提交数据
        if (this.jsonData) {
            request.jsonData = Ext.encode(request.params);
            delete request.params;
        }

        Ext.Ajax.request(request);


        return request;
    }

});