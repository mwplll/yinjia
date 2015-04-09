/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */
var articleDetailCtr = avalon.define({
    $id: "ArticleDetailController",

    row: {}
});

avalon.scan();

var articleId;

require(['UtilController'], function(AjaxFunc){
    articleId = AjaxFunc.getQueryStringByName('id');
    AjaxFunc.getAction({
        url: Global_URL['getArticleInfo'],
        data: {id: articleId},
        callback: function(result){
            result.data = result.data || {};
            articleDetailCtr.row = result.data;
        }
    });
});
