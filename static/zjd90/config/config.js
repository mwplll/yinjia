/**
 * Created by zyc on 2014/11/17.
 */

// HOST
var HOST_URL = "http://" + window.location.host + "/";

// hack for ie: console
if(!window.console){
    window.console = {};
    console.log = function(str){
        avalon.ready(function() {
            var div = document.createElement("pre");
            div.className = "mass_sys_log";
            div.innerHTML = str + ""; //确保为字符串
            document.body.appendChild(div);
        });
    }
}

avalon.config({debug: false});

// 绝对路径
var base = HOST_URL + 'zjd90/';
var dev_base = 'http://121.40.212.161:8000/';
var image_base = 'http://zjd90.b0.upaiyun.com/';
var download_base = 'http://yinjia.b0.upaiyun.com/';

// 缩略图参数
var THUMB_SIZE = {
    goods: '!350x350',
    schema: '!350x350',
    detail: '!900'
};

// 跨域设置 测试环境
var Global_DataType = 'jsonp';   // default: 'json'  -> jsonp: 'jsonp'
var Global_CrossDomain = true;   // default:  false  -> jsonp: true

// 线上环境
if(HOST_URL.indexOf("housedoing") >= 0){
    Global_DataType = 'json';
    Global_CrossDomain = false;
    dev_base = HOST_URL;
    base = HOST_URL;
}

//Ajax URL 配置信息
var Global_URL = {
    // 是否登录
    whoAmI: dev_base + 'data/user/info?_dt=' + Math.random(),

    // 个人信息
    userInfo: dev_base + 'data/user/info?_dt=' + Math.random(),

    testTelCode: dev_base + 'data/user/tel/right?_dt=' + Math.random(),
    resetPwd: dev_base + 'data/user/pwd/reset?_dt=' + Math.random(),

    // 更新个人信息
    saveUserInfo: dev_base + 'data/user/update?_dt=' + Math.random(),
    updatePassword: dev_base + 'data/user/edit?part=pwd&_dt=' + Math.random(),
    updateTel: dev_base + 'data/user/edit?part=tel&_dt=' + Math.random(),
    updateEmail: dev_base + 'data/user/edit?part=email&_dt=' + Math.random(),

    // 设计方案列表
    getSchemaList: dev_base + 'data/design/schema/list?_dt=' + Math.random(),

    // 评论列表
    getCommentList: dev_base + 'data/design/comment/list?_dt=' + Math.random(),
    saveComment:    dev_base + 'data/design/comment/edit?act=save&_dt=' + Math.random(),

    getMaterialList: dev_base + 'data/goods/list?_dt=' + Math.random(),
    getMaterialDetail: dev_base + '/data/goods/details?_dt=' + Math.random(),

    // 户型列表
    getHouseList: dev_base + 'data/house/list?_dt=' + Math.random(),
    // 楼盘列表
    getBuildingList: dev_base + 'data/building/list?_dt=' + Math.random(),

    // 推荐楼盘
    getBuildingListByRecommend: dev_base + 'data/building/recommend?_dt=' + Math.random(),

    verify: dev_base + 'data/user/identifying/code?_dt=' + Math.random(),
    signUp: dev_base + 'data/user/register?_dt=' + Math.random(),
    signIn: dev_base + 'data/user/login?_dt=' + Math.random(),
    logout: dev_base + 'data/user/logout?_dt=' + Math.random(),
    getDesignList:dev_base + 'data/design/display?_dt=' + Math.random(),
    getDesignDetails:dev_base + 'data/design/base/info?_dt='+Math.random(),

    // 设为我的户型图
    setMyHouse: dev_base + 'data/add/myhouse?_dt=' + Math.random(),
    // 获取我的户型图
    getMyHouse: dev_base + 'data/my/housetype?_dt=' + Math.random(),

    // 我的地址列表
    getAddressList: dev_base + 'data/user/addr/list?_dt=' + Math.random(),
    // 设为默认地址
    setDefaultAddress: dev_base + 'data/user/addr/edit?act=default&_dt=' + Math.random(),
    // 新增/编辑地址
    saveAddress: dev_base + 'data/user/addr/edit?act=save&_dt=' + Math.random(),
    // 删除地址
    deleteAddress: dev_base + 'data/user/addr/edit?act=del&_dt=' + Math.random(),

    // 我的方案列表
    getMyDesignList: dev_base + 'data/my/design/collection?_dt=' + Math.random(),
    // 加入我的新家计划
    addToMyDesign: dev_base + 'data/design/collect?_dt=' + Math.random(),

    cancelMySchema: dev_base + 'data/design/collection/del?_dt=' + Math.random(),

    // 购买设计方案
    placeDesignOrder: dev_base + 'data/design/buy?_dt=' + Math.random(),

    // 设计方案订单
    getDesignOrder: dev_base + 'data/my/design/order?_dt=' + Math.random(),
    // 设计方案订单 详情
    getDesignOrderInfo: dev_base + 'data/design/order/info?_dt=' + Math.random(),
    // 取消订单
    dropDesignOrder: dev_base + 'data/design/order/status?act=cancel&_dt=' + Math.random(),
    // 确认收货
    acceptDesignOrder: dev_base + 'data/design/order/status?act=confirm&_dt=' + Math.random(),
    // 提交效果图
    uploadEffectOrder: dev_base + 'data/order/design/edit?act=update&_dt=' + Math.random(),
    // 提交施工图
    uploadCADOrder: dev_base + 'data/order/design/edit?act=update&_dt=' + Math.random(),
    // 提交建材清单
    saveMaterialList: dev_base + 'data/order/design/edit?act=update&_dt=' + Math.random(),

    // 设计师中心 订单列表
    getOrderListForDesigner: dev_base + 'data/designer/order/list?_dt=' + Math.random(),
    // 设计师中心  单个订单详情
    getOrderInfoForDesigner: dev_base + 'data/design/order/info?_dt=' + Math.random(),
    // 设计师中心  取消订单
    dropOrderForDesigner: dev_base + 'data/design/order/status?act=cancel&_dt=' + Math.random(),

    // 发布设计方案相关  step1
    getBuildingByCity: dev_base + 'data/search/building?_dt=' + Math.random(),
    getBuildingByCounty: dev_base + 'data/building/list?_dt=' + Math.random(),
    getHouseByBuilding: dev_base + 'data/house/list?_dt=' + Math.random(),
    getHouseInfoById: dev_base + 'data/house/info?_dt=' + Math.random(),

    // 新增户型图
    addHouse: dev_base + 'data/house/edit?act=add&_dt=' + Math.random(),

    // 点赞
    saveLike: dev_base + '/data/design/base/edit?act=like&_dt=' + Math.random(),
    // 浏览
    saveView: dev_base + 'data/design/base/edit?act=view&_dt=' + Math.random(),

    // 新增设计方案
    publishDesignBase: dev_base + 'data/design/base/edit?act=save&_dt=' + Math.random(),
    publishDesignEffect: dev_base + 'data/design/pic/edit?act=save&_dt=' + Math.random(),
    publishDesignCAD: dev_base + 'data/design/cad/edit?act=save&_dt=' + Math.random(),
    publishDesignMaterial: dev_base + 'data/design/material/edit?act=save&_dt=' + Math.random(),
    getDesignBase: dev_base + 'data/design/base/info?_dt=' + Math.random(),
    getDesignEffect: dev_base + 'data/design/pic/info?_dt=' + Math.random(),
    getDesignCAD: dev_base + 'data/design/cad/info?_dt=' + Math.random(),
    getDesignMaterial: dev_base + 'data/design/material/info?_dt=' + Math.random(),

    getDesignManuInfo: dev_base + 'data/design/manual/info?_dt=' + Math.random(),
    getDesignManuList: dev_base + 'data/design/manual/list?_dt=' + Math.random(),

    // 施工方案选择
    saveDesignStyle: dev_base + 'data/design/manual/edit?act=select&_dt=' + Math.random(),

    getDesignDetailList: dev_base + 'data/design/material/info2user?_dt=' + Math.random(),
    saveDetailList: dev_base + 'data/my/design/material/edit?act=save&_dt=' + Math.random(),

    //我的设计方案列表
    getMySchemaList: dev_base + 'data/designer/schema/list?_dt=' + Math.random(),
    actMySchema: dev_base + 'data/designer/schema/edit?_dt=' + Math.random(),


    //造价清单 用户
    getDesignDetailList2User: dev_base + 'data/my/design/material?_dt=' + Math.random(),

    // 实名认证
    saveCard: dev_base + 'data/user/verify?_dt=' + Math.random(),
    // 认证结果
    getCardAuditResult: dev_base + 'data/verify/result?_dt=' + Math.random(),
    // 认证信息
    getCardAuditInfo: dev_base + 'data/admin/designer/info?_dt=' + Math.random(),

    // 建材相关
    listGoods: dev_base + 'data/goods/list?_dt=' + Math.random(),
    getGoodDetail: dev_base + 'data/goods/info?_dt=' + Math.random(),
    getGoodsCategory: dev_base + 'data/category/list?_dt=' + Math.random(),

    // 文章列表
    articleList: dev_base + 'data/article/list?_dt=' + Math.random(),
    getCategoryByArticle: dev_base + "data/article/category/list?_dt=" + Math.random(),
    getArticleInfo: dev_base + "data/article/info?_dt=" + Math.random(),

    // 上传头像
    uploadAvatarUrl: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=avatar",
    // 上传效果图
    uploadEffectUrl: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=design_room",
    // 上传户型图
    uploadHouseUrl: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=house_type",
    // 上传证件图
    uploadCardUrl: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=cid_pic",
    // 上传施工图
    uploadCADUrl: dev_base + 'data/image/upload?_dt=' + Math.random() + "&type=design_cad",
    uploadCADPdf: dev_base + 'data/file/upload?_dt=' + Math.random() + "&type=design_pdf",
    // 上传施工文件
    uploadCADFileUrl: dev_base + 'data/file/upload?_dt=' + Math.random() + "&type=design_file"
};

// avalon的require 配置信息
require.config({
    paths:{
        ToolTipPlugin: base + 'js/plugins/tooltip/avalon.tooltip',
        DialogPlugin:  base + 'js/plugins/dialog/avalon.dialog',
        BrowserPlugin:  base + 'js/plugins/browser/avalon.browser',
        PagerPlugin:  base + 'js/plugins/pager/avalon.pager',
        DoubleListPlugin:  base + 'js/plugins/doublelist/avalon.doublelist',
        DatePickerPlugin:  base + 'js/plugins/datepicker/avalon.coupledatepicker',
        DraggablePlugin:  base + 'js/plugins/draggable/avalon.draggable',
        CarouselPlugin:  base + 'js/plugins/carousel/avalon.carousel',
        DropdownPlugin:  base + 'js/plugins/dropdown/avalon.dropdown',
        MenuPlugin:  base + 'js/plugins/menu/avalon.menu',

        ArtDialogPlugin:  base + 'js/artDialog/dist/dialog',
        ArtDialogPlugin2:  base + 'js/artDialog/dist/dialog',
        ModalEffectsPlugin:  base + 'js/modal/js/jquery.modalEffects',
        RevolutionSliderPlugin:  base + 'js/rs-plugin/js/rs.min',

        AddressData: base + 'base/address',

        jquery:  base + 'js/jquery/jquery-1.11.1.min',
        Jquery_Knob_Plugin: base + 'js/jQuery-Knob-master/dist/jquery.knob.min',
        Bootstrap:              base + 'js/bootstrap/3.2.0/js/bootstrap.min',

        UtilController:  base + 'share/controllers/UtilController',
        SignInController: base + 'sign/controllers/SignInController',
        AddressFormController: base + 'user/controllers/AddressFormController',

        // 上传相关
        UploadBase:  base + 'js/swfupload/UploadBase',
        Upload_SwfUpload:  base + 'js/swfupload/vendor/swfupload',
        Upload_Handler:  base + 'js/swfupload/vendor/handlers',
        Upload_FileProgress:  base + 'js/swfupload/vendor/fileprogress',

        UploadHouseController: base + 'design-center/controllers/UploadHouseController',
        UploadCardController: base + 'account/controllers/UploadController',

        OrderModel: base + 'user/models/OrderModel'
    },
    shim: {
        jquery: {
            exports: "jQuery"//这是原来jQuery库的命名空间，必须写上
        },

        "ArtDialogPlugin": { // artDialog 依赖 jquery
            deps: [
                "jquery",
                "css!../../js/artDialog/css/ui-dialog.css"
            ]
        },
        // 供上传头像使用
        "ArtDialogPlugin2": { // artDialog 依赖 jquery
            deps: [
                "jquery"
            ]
        },

        "ModalEffectsPlugin": {
            deps: ["jquery"]
        },

        "RevolutionSliderPlugin": {
            deps: ["jquery"]
        },

        "Jquery_Knob_Plugin": {
            deps: ["jquery"],
            exports: 'Jquery_Knob_Plugin'
        },

        "SignInController":{
            exports: 'SignInController'
        },

        "AddressFormController":{
            exports: 'AddressFormController'
        },
        "UploadHouseController":{
            exports: 'UploadHouseController'
        },
        "UploadCardController":{
            exports: 'UploadCardController'
        },
        "Bootstrap": {
            deps: [
                "jquery"
            ],
            exports: 'Bootstrap'
        }
    }
});

/**********************公共函数*******************************/
var Tip = {
    alert: function(msg, callback){
        require(['ArtDialogPlugin'], function(){
            var d = dialog({
                content: msg,
                quickClose: false
            });
            d.showModal();
            setTimeout(function(){
                d.close();
                if(callback){
                    callback();
                }
            },1500);
        });
    }
};

var KeyMap = {
    '300*300地砖楼地面': '瓷砖',
    '400*400地砖楼地面': '瓷砖',
    '600*600地砖楼地面': '瓷砖',
    '800*800地砖楼地面': '瓷砖',
    '地砖楼地面': '瓷砖',
    '(地砖走边)楼地面': '瓷砖',
    '石材开槽淋浴房底座': '石材',
    '(石材)楼地面湿铺': '石材',
    '(石材)楼地面嵌边': '石材',
    '零星装饰项目(石材)': '石材',
    '强化地板(含地板防潮膜/含配套踢脚)': '强化地板',
    '实木复合地板(含地板防潮膜/含配套踢脚)': '复合地板',
    '实木地板(木龙骨、实木地板、地板防潮膜)': '实木地板',
    '成品木饰面踢脚线': '踢脚线',
    '集成吊顶含灯具': '集成吊顶',
    '木线条': '木线条',
    '护墙板': '护墙板',
    '墙面': '墙面',
    '墙面马赛克': '马赛克',
    '(石材)墙面': '石材',
    '墙纸(布)一:(满刮腻子、墙纸专用基膜、墙纸裱糊)': '墙纸',
    '墙纸(布)二:(满刮腻子、墙纸专用基膜、墙纸裱糊)': '墙纸',
    '防雾镜安装': '镜子',
    '防雾镜(包安装)': '镜子',
    '成品装饰木门一(含安装)': '门',
    '成品装饰木门二(含安装)': '门',
    '执手门锁安装(单开)': '锁',
    '执手门锁安装(双开)': '锁',
    '木饰面门窗套': '木饰面',
    '木饰面窗套': '木饰面',
    '门套线木脚基座': '木饰面',
    '(石材)门窗套(六面防护、石材磨边)': '石材',
    '(石材)石材基脚': '石材',
    '(石材)窗台板(20CM宽以内)': '石材',
    '(木材)窗台板(20CM宽以内)': '木材',
    '厨房橱柜(上柜)': '橱柜',
    '厨房橱柜(下柜)': '橱柜',
    '厨房台面(石英石、人造石)': '台面',
    '鞋柜(*)': '鞋柜',
    '整体浴室柜': '浴室柜',
    '整体浴室柜(上柜)': '浴室柜',
    '整体浴室柜(下柜)': '浴室柜',
    '整体浴室柜(上下柜带镜子)': '浴室柜',
    '衣柜(*)': '衣柜',
    '走入式衣柜(*)': '衣柜',
    '储藏柜(*)': '储藏柜',
    '厨房水槽': '水槽',
    '厨盆龙头': '龙头',
    '坐便器': '坐便器',
    '台盆': '台盆',
    '台盆龙头': '龙头',
    '花洒': '花洒',
    '玻璃淋浴房': '淋浴房',
    '浴缸': '浴缸',
    '浴缸龙头': '龙头',
    '洗衣龙头': '龙头',
    '拖把池': '拖把池',
    '拖把池龙头': '龙头',
    '厕纸架': '厕纸架',
    '马桶刷': '马桶刷',
    '毛巾架': '毛巾架',
    '浴巾架': '浴巾架',
    '地漏': '地漏',
    '卫浴四件套': '卫浴',
    '开关插座面板': '开关',
    '筒灯': '筒灯',
    '射灯': '灯',
    '换气扇': '换气扇',
    '地热': '地热',
    '煤气灶': '煤气灶',
    '油烟机': '油烟机',
    '空调': '空调',
    'LED灯带(含灯带插头)': 'LED灯带',
    '吸顶灯': '吸顶灯'
};
//
//var KeyMap = {
//    '抛光砖': '抛光砖',
//    '大理石': '大理石',
//    '防古砖': '防古砖',
//    '大理石门槛板': '门槛板',
//    '大理石窗台板': '窗台板',
//    '踢脚线(砖类)': '踢脚线',
//    '踢脚线(石材类)': '踢脚线',
//    '实木地板': '地板',
//    '强化地板': '地板',
//    '实木复合地板': '地板',
//    '配套木踢脚线': '踢脚线',
//    '不锈钢踢脚线': '踢脚线',
//    '成品门、门套(平板)': '门',
//    '成品门、门套(造型)': '门',
//    '执手锁': '执手锁',
//    '成品垭口门套': '门套',
//    '成品窗套线': '窗套线',
//    '石膏线条': '石膏',
//    '木饰面造型': '面造型',
//    '木线条': '木线条',
//    '成品软包': '软包',
//    '成品硬包': '硬包',
//    '成品装饰柜': '装饰柜',
//    '成品衣柜': '衣柜',
//    '乳胶漆': '乳胶漆',
//    '墙纸': '墙纸',
//    '射灯(小)': '灯',
//    '射灯(中)': '灯',
//    '筒灯': '灯',
//    'LED灯带': '灯带',
//    '钛合金移门': '门',
//    '集成扣板': '扣板',
//    '橱柜上柜': '橱柜',
//    '橱柜下柜': '橱柜',
//    '台面板': '台面板',
//    '换气扇': '换气扇',
//    '厨房水槽': '水槽',
//    '三角阀': '三角阀',
//    '不锈钢波纹管': '波纹管',
//    '厨房水龙头': '水龙头',
//    '油烟机': '油烟机',
//    '消毒柜': '消毒柜',
//    '煤气灶': '煤气灶',
//    '铝板吊灯配套内嵌灯盘': '灯盘',
//    '浴霸(风暖)': '浴霸',
//    '浴霸(灯暖)': '浴霸',
//    '淋浴房': '淋浴房',
//    '卫浴五金件': '五金件',
//    '地漏': '地漏',
//    '座便器': '座便器',
//    '浴缸': '浴缸',
//    '拖把池': '拖把池',
//    '洗脸盆': '洗脸盆',
//    '装饰镜': '装饰镜',
//    '洗脸盆台面板': '台面板',
//    '洗衣台龙头': '龙头',
//    '户外地板': '地板',
//    '洗衣台': '洗衣台'
//};
/*****************************************************/