/**
 * file:
 * ver:
 * auth: zyc
 * update: 2015/2/10
 * description:
 */
var tabCtr = avalon.define({
    $id: 'ShowSchemeController',

    tabHandler: function(type){
        location.href = '../design-center/show-scheme.html?type=' + type;
    }

});
avalon.scan();