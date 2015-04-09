/**
 * Created by zyc on 2014/10/16.
 */


var city_province_data;
var city_kot_data;
var city_cn_data;

require(['AddressData'], function(data){
    city_province_data = data.city_province_data;
    city_kot_data = data.city_kot_data;
    city_cn_data = data.city_cn_data;

    multiDropdownCtr.init(city_province_data, levels);
    kotMultiDropdownCtr.init();
});

/**
 * 收货人地址新增 控制器
 */
var addressModel = {
    "ID"                 :"" ,/*序号                ,  int(11)          */
    "ReceiptID"          :"" ,/*收货人编号          ,  int(11)          */
    "ReceiptName"        :"" ,/*收货人姓名          ,  varchar(100)     */
    "CountryID"          :"" ,/*所在国家编号        ,  int(11)          */
    "CountryName"        :"" ,/*所在国家名称        ,  varchar(50)      */
    "ReceiptCityID"      :"" ,/*所在地区(城市)编号  ,  int(11)          */
    "CityName"           :"" ,/*所在城市            ,  varchar(50)      */
    "CountyID"           :"" ,/*所在区/县编号       ,  int(11)          */
    "CountyName"         :"" ,/*所在区/县名称       ,  varchar(50)      */
    "StreetID"           :"" ,/*所在街道编号        ,  int(11)          */
    "StreetName"         :"" ,/*所在街道名称        ,  varchar(50)      */
    "StateOrProvinceID"  :"" ,/*所在省/市编号       ,  int(11)          */
    "StateOrProvinceName":"" , /*所在省/市名称       ,  varchar(50)      */

    "ZipCode"            :"" ,/*邮编                ,  varchar(20)      */
    "ReceiptAddressShort":"" ,/*收货人短地址        ,  varchar(200)     */
    "ReceiptAddress"     :"" ,/*收货人地址          ,  varchar(200)     */
    "ReceiptMobile"      :"" ,/*收货人手机          ,  varchar(20)      */
    "ReceiptPhone"       :"" ,/*收货人电话          ,  varchar(20)      */
    "ReceiptCardID"      :"" ,/*收货人证件号        ,  varchar(30)      */
    "ReceiptEmail"       :"" ,/*收货人email         ,  varchar(50)      */
    "ReceiptQQ"          :"" ,/*收货人QQ            ,  varchar(30)      */
    "IsDefaultAddress"   :false /*是否默认地址        ,  tinyint(4)       */
};
var addressForm = avalon.define({
    $id: "AddressFormController",

    row: avalon.mix(true, {}, addressModel),

    //电话号码
    phone1: '',
    phone2: '',
    phone3: '',

    // 字段验证
    vType: {
        MsgDivision: false,
        MsgStreet: false,
        MsgMobile: false,
        MsgName: false,
        MsgPostCode: false,
        MsgCardID: false
    },

    // 省市区街道地址
    shortAddress: '请选择',

    // 国家选择
    areaAddress: '请选择',

    // 清空记录
    clearHandler: function(){

    },

    // 得到表单数据
    getFormValues: function(){
        var result = {};
        avalon.each(addressModel, function(item){
            result[item] = addressForm.row[item];
        });

        // 地址数据 转换
        result['CountryID'] = '1';
        result['CountryName'] = '中国';
        if(addressForm.cnOrKot == 'cn'){
            result['StateOrProvinceID'] = multiDropdownCtr.levels[0]['selectItem'][0] || null;
            result['StateOrProvinceName'] = multiDropdownCtr.levels[0]['selectItem'][1] || null;
            result['ReceiptCityID'] =  multiDropdownCtr.levels[1]['selectItem'][0] || null;
            result['CityName'] =  multiDropdownCtr.levels[1]['selectItem'][1] || null;
            result['CountyID'] =  multiDropdownCtr.levels[2]['selectItem'][0] || null;
            result['CountyName'] =  multiDropdownCtr.levels[2]['selectItem'][1] || null;
//            result['StreetID'] =  multiDropdownCtr.levels[3]['selectItem'][0] || null;
//            result['StreetName'] =  multiDropdownCtr.levels[3]['selectItem'][1] || null;

            result['ReceiptAddress'] =
                result['StateOrProvinceName'] +
                result['CityName'] +
                result['CountyName'] +
                result['StreetName'] +
                result['ReceiptAddressShort'];
        }else {
            result['StateOrProvinceID'] = multiDropdownCtr.levels[0]['selectItem'][0] || null;
            result['StateOrProvinceName'] = multiDropdownCtr.levels[0]['selectItem'][1] || null;
            result['ReceiptCityID'] =  multiDropdownCtr.levels[1]['selectItem'][0] || null;
            result['CityName'] =  multiDropdownCtr.levels[1]['selectItem'][1] || null;
            result['CountyID'] =  multiDropdownCtr.levels[2]['selectItem'][0] || null;
            result['CountyName'] =  multiDropdownCtr.levels[2]['selectItem'][1] || null;

            result['ReceiptAddress'] =
                result['StateOrProvinceName'] +
                result['CityName'] +
                result['CountyName'] +
                result['ReceiptAddressShort'];
        }

//        result['ReceiptPhone'] = addressForm.phone1 +'-' +
//            addressForm.phone2 +'-' +
//            addressForm.phone3;
//        result['ReceiptPhone'] = addressForm.phone2;

        return result;
    },

    // 多级下拉框 下拉控制
    dropHandler: function(name, e){
        // 阻止冒泡
        if(e){
            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }
        if(name == 'multi'){
            if(addressForm.cnOrKot == 'cn'){
                multiDropdownCtr.dropdown = true;
                kotMultiDropdownCtr.dropdown = false;
            }else{
                kotMultiDropdownCtr.dropdown = true;
                multiDropdownCtr.dropdown = false;
            }
            dropdownCtr.dropdown = false;
        }else{
            multiDropdownCtr.dropdown = false;
            kotMultiDropdownCtr.dropdown = false;

            dropdownCtr.dropdown = true;
        }
    },

    // 设置默认地址
    setDefaultHandler: function(bool){
        addressForm.row.IsDefaultAddress = bool;
    },

    // 保存地址
    saveHandler: function(){
        var values = addressForm.getFormValues();
        if(!addressForm.validate(values)){
            return;
        }
        var pd = {
            id: addressForm.row['ID'] || null,
            area: values.CountyName,
            province: values.StateOrProvinceName,
            city: values.CityName,
            name: values.ReceiptName,
            zip: values.ZipCode,
            telephone: values.ReceiptMobile,
            address: values.ReceiptAddressShort,
            mobile: values.ReceiptPhone,
            isDefault: values.IsDefaultAddress? 1: 0
        };
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.saveAction({
                url: Global_URL['saveAddress'],
                data: pd,
                crossDomain: Global_CrossDomain,
                callback: function(result){
                    if(addressListCtr){
                        listAddress();
                    }
                    _dialogs_['address'].close();
                }
            });
        });
    },

    // 所在地区、详细地址、邮编、收货人姓名、证件号、手机号码
    validate: function(values){
        var fg = true;

        addressForm.vType = {
            MsgDivision: false,
            MsgStreet: false,
            MsgMobile: false,
            MsgName: false,
            MsgPostCode: false,
            MsgTelephone: false,
            MsgCardID: false
        };

        // 乡镇街道地址
        if(addressForm.shortAddress == "请选择"
            || addressForm.shortAddress == '稍后再说'
            || !addressForm.showMore){
            addressForm.vType.MsgDivision = true;
            fg = false;
        }
        // 详细地址
        var reg = /^.{5,100}$/;
        if(!reg.test(values.ReceiptAddress)){
            addressForm.vType.MsgStreet = true;
            fg = false;
        }
        // 邮政编码
        reg = /^[\da-zA-Z\-]{3,10}$/;
        if(!reg.test(values.ZipCode)){
            addressForm.vType.MsgPostCode = true;
            fg = false;
        }
        // 收货人姓名
        reg = /^.{2,25}$/;
        if(!reg.test(values.ReceiptName)){
            addressForm.vType.MsgName = true;
            fg = false;
        }

        // 手机号码
        reg = /^\d{6,20}$/;
        if(!values.ReceiptMobile || !reg.test(values.ReceiptMobile)){
            addressForm.vType.MsgMobile = true;
            fg = false;
        }

        return fg;
    },

    showMore: false,

    cnOrKot: 'cn',

    // 编辑地址 初始化
    initForUpdate: function(pd){
        if(!pd){
            avalon.each(addressModel, function(item){
                addressForm.row[item] = addressModel[item];
                addressForm.shortAddress = '';
                addressForm.row['IsDefaultAddress'] = false;
                multiDropdownCtr.levels[2]['selectItem'][0] = null;
            });
            return;
        }
        var _name = pd['province'] + '/' + pd['city'] + '/' + pd['area'];
        var pd_ = {
            ID: pd['id'],
            CountyID: pd['area_id'],
            ZipCode: pd['zip'],
            ReceiptName: pd['name'],
            ReceiptMobile: pd['telephone'],
            ReceiptAddressShort: pd['address'],
            ReceiptPhone: pd['mobile'],
            shortAddress: _name,
            StateOrProvinceName: pd['province'],
            CityName: pd['city'],
            CountyName: pd['area'],
            IsDefaultAddress: Number(pd['isDefault'])
        };
        multiDropdownCtr.levels[0]['selectItem'][1] = pd['province'];
        multiDropdownCtr.levels[1]['selectItem'][1] = pd['city'];
        multiDropdownCtr.levels[2]['selectItem'][1] = pd['area'];
        avalon.each(addressModel, function(item){
            addressForm.row[item] = pd_[item];
            addressForm.shortAddress = pd_['shortAddress'];
            if(item == 'IsDefaultAddress'){
                if(pd_[item] == 0 || pd_[item] == '0'){
                    addressForm.row[item] = false;
                }else{
                    addressForm.row[item] = true;
                }
            }
        });
    },

    bodyClickHandler: function(e){
        // 阻止冒泡
        if(e){
            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }
        dropdownCtr.dropdown = false;
        multiDropdownCtr.dropdown = false;
        kotMultiDropdownCtr.dropdown = false;
    }
});

/**
 * 下拉框 控制器
 */
var dropdownCtr = avalon.define({
    $id: "SingleDropdownController",

    // 下拉数据
    rows: [
        {ID: 0, Name: '请选择'},
        {ID: 1, Name: '中国大陆'}
//        {ID: 2, Name: '港澳台'}
    ],

    /*下拉框的控制*/
    dropdown: false,

    selectIdx: -1,

    selectHandler: function(index, item, e){
        // 阻止冒泡
        if(e){
            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }
        if(dropdownCtr.selectIdx == index){
            return;
        }
        dropdownCtr.selectIdx = index;

        addressForm.areaAddress = item.Name;
        if(item.Name == '中国大陆'){
            addressForm.showMore = true;
            addressForm.cnOrKot = 'cn';

            addressForm.shortAddress = '请选择';
            multiDropdownCtr.defaultHandler();
        }else if(item.Name == '港澳台'){
            addressForm.showMore = true;
            addressForm.cnOrKot = 'kot';
            addressForm.shortAddress = '请选择';

            kotMultiDropdownCtr.defaultHandler();
        }else{
            addressForm.showMore = false;
        }

        dropdownCtr.dropdown = false;
    }
});

/**
 * 多级下拉框 控制器
 */
var multiDropdownCtr = avalon.define({
    $id: "MultiDropdownController",

    row: {
        "ID":"",
        "Name":"",
        "ParentID":""
    },

    // 下拉数据（所有的）
    rows: [],

    /*下拉框的控制 默认隐藏*/
    dropdown: false,

    // 层级控制 从第二级开始
    levels:  [
        { name: '省份', selectItem: []},
        { name: '城市', selectItem: []},
        { name: '县区', selectItem: []}
//        { name: '街道', selectItem: []}
    ],

    // 存放第一级的数据（对地址来说代表 省）
    first: {
        "key": []
    },

    // 当前在处在第几级位置，默认第一级
    curLevel: 0,

    curList: [],

    init: function(firstData){
        // 第一级 数据初始化
        multiDropdownCtr.first = firstData;
        multiDropdownCtr.curLevel = 0;
        multiDropdownCtr.curList = [];
    },

    defaultHandler: function(){
        multiDropdownCtr.curLevel = 0;
        multiDropdownCtr.curList = [];
        for(var i = 0; i < multiDropdownCtr.levels.length; i++){
            multiDropdownCtr.levels[i]['selectItem'] = [];
        }
    },

    // 选择地址项
    selectHandler: function(item, levelIndex, e){
        // 阻止冒泡
        if(e){
            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }
        var parentID;
        multiDropdownCtr.levels[levelIndex].selectItem = item;

        var it = multiDropdownCtr.levels[levelIndex]['selectItem'];
        parentID = it[0];

        // 后面的选项应该置空
        for(var i = levelIndex + 1; i < multiDropdownCtr.levels.length; i++){
            multiDropdownCtr.levels[i]['selectItem'] = [];
        }

        // 地区显示
        multiDropdownCtr.showSelectHandler();

        // 最后一组数据没有下一步
        if(levelIndex >= multiDropdownCtr.levels.length - 1){
            multiDropdownCtr.dropdown = false;
            return;
        }

        multiDropdownCtr.curLevel ++;
        multiDropdownCtr.showCurList(parentID, levelIndex + 1, true);

    },

    // 显示当前页的数据
    showCurList: function(parentID, curIndex, isAutoSelect){
        if(curIndex < multiDropdownCtr.levels.length){
            var nextList = filterDataByParent(city_cn_data, parentID);
            multiDropdownCtr.curList = nextList;

            if(isAutoSelect){
                //如果列表中只有一条数据 则自动选中
                if(nextList.length == 1){
                    multiDropdownCtr.selectHandler(nextList[0], multiDropdownCtr.curLevel);
                }else if(!nextList.length){
                    // 如果没有数据 则自动跳过选择
                    multiDropdownCtr.tabChangeHandler(multiDropdownCtr.curLevel + 1);
                }
            }

        }else if(curIndex == multiDropdownCtr.levels.length - 1){
//            // 动态获街道的数据
//            var data = {
//                l1: multiDropdownCtr.levels[0]['selectItem'][0] || null,
//                l2: multiDropdownCtr.levels[1]['selectItem'][0] || null,
//                l3: multiDropdownCtr.levels[2]['selectItem'][0] || null
//            };
//            avalon.log("选择地址数据:");
//            avalon.log(data);
//            require(['UtilController'], function(AjaxFunc){
//                AjaxFunc.getAction({
//                    url: Global_URL['getStreetList'],
//                    data: data,
//                    callback: function(result){
//                        result.data = result.data || [];
//                        nextList = result.data;
//                        multiDropdownCtr.curList = nextList;
//
//                        //如果列表中只有一条数据 则自动选中
//                        if(nextList.length == 1){
//                            multiDropdownCtr.selectHandler(nextList[0], multiDropdownCtr.curLevel);
//                        }
//                    }
//                })
//            });
        }
    },

    // 显示选择项
    showSelectHandler: function(){
        var info = '';
        for(var i = 0, len = multiDropdownCtr.levels.length; i < len; i++){
            var it = multiDropdownCtr.levels[i];
            if(it && it['selectItem'] && it['selectItem'][1]){
                info += it['selectItem'][1];
                if(i < len - 1){
                    info += '/';
                }
            }
        }
        addressForm.shortAddress =  info;
    },

    // tab切换
    tabChangeHandler: function(index, e){
        // 阻止冒泡
        if(e){
            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }
        // 不需要切换
        if(multiDropdownCtr.curLevel == index){
            return;
        }

        multiDropdownCtr.curLevel = index;

        var parentID;
        // 第一级的数据已经有了，不需要重新计算
        if(index > 0){
            parentID = multiDropdownCtr.levels[index - 1]['selectItem'][0];

            // 没有父ID
            if(!parentID){
                // TODO 方法不太好 待改进
                // 如果显示街道地址，需要判断区是空还是没选
                if(index == multiDropdownCtr.levels.length - 1){
                    // 判断是否选择了市
                    if(!multiDropdownCtr.levels[1]['selectItem'][0]){
                        // 没有就清空
                        multiDropdownCtr.curList = [];
                    }else{
                        // 区ID为空，话判断区是空还是没选
                        if(!multiDropdownCtr.levels[2]['selectItem'][0]){
                            var _pid = multiDropdownCtr.levels[1]['selectItem'][0];
                            var nextList = filterDataByParent(city_cn_data, _pid);
                            // 区是空的
                            if(!nextList.length){
                                multiDropdownCtr.showCurList(parentID, index, false);
                            }else{
                                multiDropdownCtr.curList = [];
                            }
                        }else{
                            multiDropdownCtr.showCurList(parentID, index, false);
                        }
                    }
                }else{
                    multiDropdownCtr.curList = [];
                }
            }else{
                multiDropdownCtr.showCurList(parentID, index, false);
            }
        }
    },

    //稍后再说
    lastChoiceHandler: function(){
        var len = multiDropdownCtr.levels.length;
        multiDropdownCtr.levels[len - 1]['selectItem'] = [-1, '稍后再说'];

        // 地区显示
        multiDropdownCtr.showSelectHandler();

        multiDropdownCtr.dropdown = false;
    }
});

/**
 * 港澳台 多级下拉框 控制器
 */
var kotMultiDropdownCtr = avalon.define({
    $id: "KOTMultiDropdownController",

    row: {
        "ID":"",
        "Name":"",
        "ParentID":""
    },

    // 下拉数据（所有的）
    rows: [],

    /*下拉框的控制 默认隐藏*/
    dropdown: false,

    // 层级控制 从第二级开始
    levels: [
        { name: '其他', selectItem: []},
        { name: '城市', selectItem: []},
        { name: '县区', selectItem: []}
    ],

    // 当前在处在第几级位置，默认第一级
    curLevel: 0,

    curList: [],

    init: function(){
        // 第一级 数据初始化
        kotMultiDropdownCtr.curLevel = 0;
        kotMultiDropdownCtr.curList = filterDataByParent(city_kot_data, 1);
    },

    defaultHandler: function(){
        kotMultiDropdownCtr.curLevel = 0;
        kotMultiDropdownCtr.curList = filterDataByParent(city_kot_data, 1);
        for(var i = 0; i < kotMultiDropdownCtr.levels.length; i++){
            kotMultiDropdownCtr.levels[i]['selectItem'] = [];
        }
    },

    // 选择地址项
    selectHandler: function(item, levelIndex, e){
        // 阻止冒泡
        if(e){
            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }
        var parentID;
        kotMultiDropdownCtr.levels[levelIndex].selectItem = item;

        var it = kotMultiDropdownCtr.levels[levelIndex]['selectItem'];
        parentID = it[0];

        // 后面的选项应该置空
        for(var i = levelIndex + 1; i < kotMultiDropdownCtr.levels.length; i++){
            kotMultiDropdownCtr.levels[i]['selectItem'] = [];
        }

        // 地区显示
        kotMultiDropdownCtr.showSelectHandler();

        // 最后一组数据没有下一步
        if(levelIndex >= kotMultiDropdownCtr.levels.length - 1){
            kotMultiDropdownCtr.dropdown = false;
            return;
        }

        kotMultiDropdownCtr.curLevel ++;
        kotMultiDropdownCtr.showCurList(parentID, levelIndex + 1, true);

    },

    // 显示当前页的数据
    showCurList: function(parentID, curIndex, isAutoSelect){
        var nextList = filterDataByParent(city_kot_data, parentID);
        kotMultiDropdownCtr.curList = nextList;

        if(isAutoSelect){
            //如果列表中只有一条数据 则自动选中
            if(nextList.length == 1){
                kotMultiDropdownCtr.selectHandler(nextList[0], kotMultiDropdownCtr.curLevel);
            }else if(!nextList.length){
                if(curIndex == kotMultiDropdownCtr.levels.length - 1){
                    // 最后一项没有内容
                    kotMultiDropdownCtr.dropdown = false;
                    kotMultiDropdownCtr.curLevel = kotMultiDropdownCtr.levels.length - 2;

                    // 恢复curList
                    var _pid = kotMultiDropdownCtr.levels[0]['selectItem'][0];
                    kotMultiDropdownCtr.curList = filterDataByParent(city_kot_data, _pid);
                }else{
                    // 如果没有数据 则自动跳过选择
                    kotMultiDropdownCtr.tabChangeHandler(kotMultiDropdownCtr.curLevel + 1);
                }

            }
        }

    },

    // 显示选择项
    showSelectHandler: function(){
        var info = '';
        for(var i = 0, len = kotMultiDropdownCtr.levels.length; i < len; i++){
            var it = kotMultiDropdownCtr.levels[i];
            if(it && it['selectItem'] && it['selectItem'][1]){
                info += it['selectItem'][1];
                if(i < len - 1){
                    info += '/';
                }
            }
        }
        addressForm.shortAddress =  info;
    },

    // tab切换
    tabChangeHandler: function(index, e){
        // 阻止冒泡
        if(e){
            e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
        }
        // 不需要切换
        if(kotMultiDropdownCtr.curLevel == index){
            return;
        }

        kotMultiDropdownCtr.curLevel = index;

        var parentID;
        // 第一级的数据已经有了，不需要重新计算
        if(index == 0){
            parentID = 1;
            kotMultiDropdownCtr.showCurList(parentID, index, false);
            return;
        }
        if(index > 0){
            parentID = kotMultiDropdownCtr.levels[index - 1]['selectItem'][0];

            // 没有父ID
            if(!parentID){
                kotMultiDropdownCtr.curList = [];
            }else{
                kotMultiDropdownCtr.showCurList(parentID, index, false);
            }
        }
    }
});

// 默认显示中国大陆
dropdownCtr.selectHandler(1, dropdownCtr.rows[1]);

var levels = [
    { name: '省份', selectItem: []},
    { name: '城市', selectItem: []},
    { name: '县区', selectItem: []},
    { name: '街道', selectItem: []}
];

/*****************************工具函数*********************************/
// 根据parentID过滤数据
function filterDataByParent(dataArray, parentID){
    var re = [];
    avalon.each(dataArray, function(i, item){
        if(item[2] == parentID){
            re.push(item);
        }
    });
    return re;
}
/*****************************工具函数*********************************/