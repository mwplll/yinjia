/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/19
 * description:
 */
var calendarCtr = avalon.define({
    $id: 'CalendarController',

    cur: 'index',

    setCurHandler : function(cur){
        calendarCtr.cur = cur;

        if(cur == 'index'){
            require(['UtilController'], function(AjaxFunc){
                AjaxFunc.getAction({
                    url: Global_URL['getMyHouse'],
                    dataType: Global_DataType,
                    callback: function(result){
                        if(result.data){
                            step1Ctr.house.thumbUrl = image_base + result.data.pic;
                            step1Ctr.house.name = result.data.house_typename;
                            step1Ctr.house.size = result.data.usable_area;
                            step1Ctr.house.position = result.data.prov_name + " " + result.data.city_name;
                        }
                    }
                });
            });
        }
    },

    // 装前准备
    zqStep: 'step1',
    zqStepHandler: function(step){
        calendarCtr.zqStep = step;
    },

    // 进场准备
    jcStep: 'step1',
    jcStepHandler: function(step){
        calendarCtr.jcStep = step;
    }
});

calendarCtr.setCurHandler('index');

var step1Ctr = avalon.define({
    $id: "Step1Controller",

    house: {
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