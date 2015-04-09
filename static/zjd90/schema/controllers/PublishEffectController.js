/**
 * Created by zyc on 2014/12/27.
 */

// 发布设计方案 上传效果图
var publishEffectCtr = avalon.define({
    $id: 'PublishEffectController',

    curStep: 2,
    row: {
        id: null,
        rooms: []   // 房间
    },
    preHandler: function(){
        var url = 'publish.html?house_id='+  houseCtr.houseId;
        if(design_id){
            url += '&design_id=' + design_id;
        }
        location.href = url;
    },
    saveHandler: function(){
        var pd = {
            id: design_id,
            name: [],
            picId: [],
            pic: [],
            mainPic: ''
        };
        var er = getRoomsData(pd);
        if(!er.success){
            Tip.alert(er.message);
            return;
        }
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.saveAction({
                url: Global_URL['publishDesignEffect'],
                data: pd,
                crossDomain: Global_CrossDomain,
                method: 'POST',
                callback: function(result){
                   location.href = 'publish-cad.html?house_id='+  houseCtr.houseId + '&design_id=' + design_id;
//                    location.href = 'publish-cad.html?house_id=' + houseCtr.house_id;
                }
            });
        })
    }
});

uploadCtr.initHandler();

var design_id = null;
require(['UtilController'], function(AjaxFunc){
    design_id = AjaxFunc.getQueryStringByName('design_id');
    if(!design_id){
        return;
    }
    AjaxFunc.getAction({
        url: Global_URL['getDesignEffect'],
        data: {id: design_id},
        callback: function(result){
            var rooms = result.data['picList'] || [];
            if(!rooms.length){
                return;
            }
            initRooms(rooms,result.data['mainPic']);
        }
    });
});

function getRoomsData(pd){
    var fg = true, msg = '';
    if(!uploadCtr.list.length){
        return {
            success: false,
            message: '请先上传效果图'
        }
    }
    // 判断图片上传完成
    var hasThumb = false;
    for(var i = 0, len = uploadCtr.list.length; i < len; i ++){
        var it = uploadCtr.list[i];
        if(it.serial && !it.error){
            if(!it.selectRoom.name){
                fg = false;
                msg = '请选择房间';
                break;
            }
            pd.name.push(it.selectRoom.name);
            pd.pic.push(it.serial);
            pd.picId.push(it.picId);
            if(uploadCtr.selectIndex == i){
                pd.mainPic = it.serial;
                hasThumb = true;
            }
        }else{
            if(it.state == 'inprogress' || it.state == 'wait'){
                fg = false;
                msg='您还有图片未上传完成，请等待图片上传成功后保存';
                break;
            }
        }
    }
    if(!fg){
        return {
            success: false,
            message: msg
        }
    }

    if(!fg){
        return {
            success: false,
            message: msg
        }
    }
    // 判断 封面图
    if(!hasThumb){
        return {
            success: false,
            message: '请选择封面图'
        }
    }
    return {
        success: true
    }
}

function initRooms(rooms, mainPic){
    var temp = [];
    require(['jquery',"Bootstrap"], function(){
        avalon.each(rooms, function(i, it){
            temp.push({
                fid: 'fid' + i,
                thumbUrl: image_base + it.pic,
                serial: it.pic,
                error: null,
                picId: it.picId,
                state: 'finish',
                rooms: avalon.mix([], true, rooms_model),
                selectRoom: {
                    name: it.name,
                    index: findRoomIndex(it.name, rooms_model)
                }
            });
            if(it.pic == mainPic){
                uploadCtr.selectIndex = i;
            }
        });
        uploadCtr.list = temp;
        uploadCtr.listVisible = true;

        avalon.each(temp, function(i, it){
            new customDropDown($("#dropdown" + it.fid));
        });
    });
}
function findRoomIndex(name, array){
    var index = -1;
    for(var i = 0, len = array.length; i < len; i++){
        if(name == array[i].name){
            index = i;
        }
    }
    return index;
}
