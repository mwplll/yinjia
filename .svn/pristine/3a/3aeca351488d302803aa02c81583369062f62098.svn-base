/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午5:00
 * To change this template use File | Settings | File Templates.
 */

//
if(!window.console){
    window.console = {};
    console.log = function(str){};
}

// 声明静态全局变量
var globalVariable = Ext.create("Ext.util.MixedCollection");

var coreApp = null;

// HOST
var HOST_URL = "http://"+window.location.host+"/" ;

// 绝对路径
var base = HOST_URL + 'admin/';
var dev_base = 'http://121.40.212.161:8000/';
var base_link = HOST_URL + 'zjd90/';
var goods_default_image= "/goods/goods/267de7110749c5e0a08db2682174b89a.png";

// 图片地址
var image_base = 'http://zjd90.b0.upaiyun.com/';
var linkBase = 'http://yinjia.b0.upaiyun.com/';

// 跨域 JSONP
var Global_DataType = 'jsonp';          // default: 'ajax'  -> jsonp: 'jsonp'
var Global_DataType_Jquery = 'jsonp';   // default: 'json'  -> jsonp: 'jsonp'
var Global_CrossDomain = true;          // default:  false  -> jsonp: true

// 缩率图参数
var THUMB_SIZE = {
    grid: '!100x100',
    thumb: '!350x350'
};

// 线上环境
if(HOST_URL.indexOf("housedoing") >= 0){
    Global_DataType = 'ajax';
    Global_DataType_Jquery = 'json';
    Global_CrossDomain = false;
    dev_base = HOST_URL;
    base_link = HOST_URL;
}

// 本地调试地址
//var base = HOST_URL + 'static/admin/';
//var dev_base = HOST_URL;
//var Global_DataType_Jquery = 'json';
//var Global_DataType = 'ajax';
