/**
 * Created by zyc on 2015/2/7.
 */
// 发布设计方案 上传效果图
var publishCadCtr = avalon.define({
    $id: 'PublishCadController',

    curStep: 3,
    row: {
        id: null,
        rooms: []
    },
    preHandler: function(){
        var url = 'publish-effect.html?house_id='+  houseCtr.houseId;
        if(design_id){
            url += '&design_id=' + design_id;
        }
        location.href = url;
    },
    nextHandler : function(){
        var pd = {
            id: design_id,
            name: [],
            picId: [],
            pic: [],
            file: ''
        };
        var er = getRoomsData(pd);
        if(!er.success){
            Tip.alert(er.message);
            return;
        }
        var re = getFileData(pd);
        if(!re.success){
            Tip.alert(re.message);
            return;
        }
        // 没有上传直接跳过
        if(!pd.name.length && !pd.file){
            location.href = 'publish-material.html?house_id='
                              + houseCtr.houseId
                              + '&design_id=' + design_id
                              + '&city_id=' + houseCtr.cityId;
        }else{
            require(['UtilController'], function(AjaxFunc){
                AjaxFunc.saveAction({
                    url: Global_URL['publishDesignCAD'],
                    data: pd,
                    crossDomain: Global_CrossDomain,
                    method: 'POST',
                    callback: function(result){
                        location.href = 'publish-material.html?house_id='
                            + houseCtr.houseId
                            + '&design_id=' + design_id
                            + '&city_id=' + houseCtr.cityId;
                    }
                });
            })
        }
    }
});

uploadCtr.initHandler();
cadUploadCtr.initHandler();

var design_id = null;
require(['UtilController'], function(AjaxFunc){
    design_id = AjaxFunc.getQueryStringByName('design_id');
    if(!design_id){
        return;
    }
    AjaxFunc.getAction({
        url: Global_URL['getDesignCAD'],
        data: {id: design_id},
        callback: function(result){
            var rooms = result.data['picList'] || [];
            if(result.data['file']){
                initFile(result.data['file']);
            }
            if(rooms.length){
                initRooms(rooms);
            }
        }
    });
});


function getRoomsData(pd){
    var fg = true, msg = '';
    if(!uploadCtr.list.length){
        return {
            success: true
        }
    }
    // 判断图片上传完成
    for(var i = 0, len = uploadCtr.list.length; i < len; i ++){
        var it = uploadCtr.list[i];
        if(it.serial && !it.error){
            if(!it.selectRoom.name){
                fg = false;
                msg = '请选择施工图名称';
                break;
            }
            pd.name.push(it.selectRoom.name);
            pd.pic.push(it.serial);
            pd.picId.push(it.picId);
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
    return {
        success: true
    }
}
function getFileData(pd){
    var fg = true, msg = '';
    if(!cadUploadCtr.list.length){
        return {
            success: true
        }
    }
    // 判断图片上传完成
    for(var i = 0, len = cadUploadCtr.list.length; i < len; i ++){
        var it = cadUploadCtr.list[i];
        if(it.serial && !it.error){
            pd.file = it.serial;
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
    return {
        success: true
    }
}

function initRooms(rooms){
    var temp = [];
    require(['jquery',"Bootstrap"], function(){
        avalon.each(rooms, function(i, it){
            temp.push({
                fid: 'fid' + i,
//                thumbUrl: image_base + it.pic,
                thumbUrl: base + "images/dwg-03.jpg",
                link: download_base + it.pic,
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
function initFile(file){
    var temp = [{
        fid: 'cad_fid' + 0,
        cad_fid: 'cad_' + 0,
        thumbUrl:base + "images/dwg-03.jpg",
        link: download_base + file,
        serial: file,
        fname: '',
        error: null,
        state: 'finish'
    }];
    cadUploadCtr.list = temp;
    cadUploadCtr.listVisible = true;
}

