Ext.define('PMS.apps.DesignApp.store.CommentStore', {
    extend:'Ext.data.Store',
    model:'PMS.apps.DesignApp.model.CommentModel',
    autoLoad: false,
    pageSize: 20,
    proxy:{
        pageParam: 'page',
        limitParam: 'num',
        type: Global_DataType,
        callbackKey: 'callback',
        api:{
            read: dev_base + 'data/design/comment/list'
        },
        reader:{
            root:'data.commentList',
            type: 'json',
            successProperty:'success',
            totalProperty: 'data.pagination.count'
        },
        extraParams:{

        }
    }
});