/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/19
 * description:
 */
var myHouseCtr = avalon.define({
    $id: 'MyHouseController',

    house: {
        id: '',
        thumbUrl: '../images/user/calendar-bg-06.png',
        name: '',
        size: '',
        position: ''
    },

    design: {
        thumbUrl: '../images/user/calendar-bg-06.png',
        name: '暂时还没有购买设计方案，快去购买方案吧',
        size: '',
        position: ''
    }
});
require(['UtilController'], function(AjaxFunc){
    AjaxFunc.getAction({
        url: Global_URL['getMyHouse'],
        dataType: Global_DataType,
        callback: function(result){
            if(result.data){
                myHouseCtr.house.id = result.data.house_type_id;
                myHouseCtr.house.thumbUrl = image_base + result.data.pic;
                myHouseCtr.house.name = result.data.house_typename;
                myHouseCtr.house.size = result.data.usable_area;
                myHouseCtr.house.position = result.data.prov_name + " " + result.data.city_name;
            }
        }
    });
});
