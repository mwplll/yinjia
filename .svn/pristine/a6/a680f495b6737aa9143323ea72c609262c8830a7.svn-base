Ext.define('PMS.apps.ArticleApp.store.ArticleStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.ArticleApp.model.ArticleModel',
    autoLoad: false,
    pageSize: 10,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/article/list'
        },
        reader:{
            root:'data.articleList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});