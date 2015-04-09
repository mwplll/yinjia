/**
 * Created by zyc on 2015/2/7.
 */
// 户型信息
var publishAuditCtr = avalon.define({
    $id: 'PublishAuditController',

    house_id: null,
    design_id: null
});
var design_id = null;
require(['UtilController'], function(AjaxFunc){
    var house_id = AjaxFunc.getQueryStringByName('house_id');
    design_id = AjaxFunc.getQueryStringByName('design_id');
    publishAuditCtr.house_id = house_id;
    publishAuditCtr.design_id = design_id;
});