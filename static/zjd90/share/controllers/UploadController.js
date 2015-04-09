/**
 * Created by zyc on 2014/4/14.
*/
var upload_swf = {
    swf: null
};
var upload_params = {
    custom_settings: {
        progressTarget: "UploadProgress",
        cancelButtonId: "CancelBtn"
    },
    button_placeholder_id: "UploadBtn",
    upload_url: Global_URL['uploadEffectUrl'],

    upload_success_handler: successCallback,
    upload_start_handler: uploadStartHandler,

    file_queued_handler: fileQueuedHandler
};

var uploadCtr = avalon.define("UploadController", function(vm){
    vm.listVisible = true;
    vm.inited = false;

    vm.initHandler = function(){
        uploadCtr.clearHandler();
        if(!upload_swf.swf){
            require(["UploadBase"], function(SwfClass){
                var tmp = new SwfClass(upload_params);
                upload_swf.swf = tmp.init();
                uploadCtr.inited = true;
            });
        }
    };

    vm.list = [];

    vm.showList = [];
    vm.curPage = 1;
    vm.limit = 2000;
    vm.totalPages = 0;

    vm.clearHandler = function(){
        uploadCtr.list = [];
        uploadCtr.showList = [];
        uploadCtr.curPage = 1;
        uploadCtr.totalPages = 0;
        uploadCtr.listVisible = false;
    };

    vm.findItemByFile = function(file){
        for(var i = 0; i < uploadCtr.list.length; i++){
            if(uploadCtr.list[i].fid == file.id){
                return uploadCtr.list[i];
            }
        }
        return null;
    };
    vm.findIndex = function(el){
        var index = null;
        for(var i = 0; i < uploadCtr.list.length; i++){
            if(uploadCtr.list[i].fid == el.fid){
                index = i;
                break;
            }
        }
        return index;
    };

    vm.selectIndex = 0;
    vm.selectHandler = function(event, $index){
        uploadCtr.selectIndex = $index;
    };

    vm.cancelUploadHandler = function(e, el){
        if(el.state == 'inprogress' || el.state == 'wait'){
            upload_swf.swf.cancelUpload(el.fid);
        }
        var index = uploadCtr.findIndex(el);
        if(index >= 0){
            uploadCtr.list.splice(index, 1);
            uploadCtr.totalPages = Math.ceil(uploadCtr.list.length / uploadCtr.limit);
            uploadCtr.curPage = Math.min(uploadCtr.curPage, uploadCtr.totalPages) || 1;
            uploadCtr.showList = uploadCtr.list.slice((uploadCtr.curPage - 1) * uploadCtr.limit, uploadCtr.curPage * uploadCtr.limit);
        }
    };

    vm.showCancelHandler = function(el, type){
        if(el.state == 'inprogress' || el.state == 'wait'){
            return;
        }
        var dom = document.getElementById("del_pic_" + el.fid);
        if(!dom){
            return;
        }
        dom.style.display = (type=='hidden'?"none":"block");
    };

    vm.confirmBtnHandler = function(){
        var ptns = [], infos = [];
        var tmp = [];
        var serials = [];
        uploadCtr.list.forEach(function(it){
            if(it.value && !it.error){
                var item = it.value;
                item.thumbUrl = it.thumbUrl;
                item.selected = true;
                ptns.push(item);
                serials.push(item.serial);
            }else{
                if(it.state == 'inprogress' || it.state == 'wait'){
                    tmp.push(it);
                }
            }
        });

        if(tmp.length){
            if(confirm("您有图片未上传完成，确认取消图片上传吗？")){
                tmp.forEach(function(it){
                    upload_swf.swf.cancelUpload(it.fid);
                });
            }else{
                return;
            }
        }

        if(window.patternListCtr && serials.length){
            serviceUtil.confirmUpload(serials).then(function(){
                patternListCtr.init();
                uploadCtr.showHandler(false);
            });
        }else{
            uploadCtr.showHandler(false);
        }
    };

    vm.removeBtnHandler = function(){
        var serials = [];
        uploadCtr.list.forEach(function(it){
            if(it.serial){
                serials.push(it.serial);
            }
        });
        if(!serials.length){
            uploadCtr.showHandler(false);
            return;
        }
        uploadCtr.showHandler(false);
    };

    vm.selectRoomHandler = function(el, room){
        if(!el){
            el.selectRoom['room_id'] = '';
            el.selectRoom['room_area'] = '';
        }
        el.selectRoom['room_id'] = room['room_id'];
        el.selectRoom['room_area'] = room['room_area'];
    }
});
var rooms_model = [
    {room_name: '主卧', room_area:'', room_id: ''},
    {room_name: '主卧', room_area:'', room_id: ''},
    {room_name: '主卧', room_area:'', room_id: ''},
    {room_name: '主卧', room_area:'', room_id: ''},
    {room_name: '主卧', room_area:'', room_id: ''},
    {room_name: '主卧', room_area:'', room_id: ''}
];
function fileQueuedHandler(file){
    var item = {
        fid: file.id,
        thumbUrl:'',
        serial: null,
        fname: file.name,
        error: null,
        state: 'wait',
        name: file.name,
        rooms: avalon.mix([], true, rooms_model),
        selectRoom: {
            room_name: '',
            room_id: '',
            room_area: ''
        }
    };
    if(file.size > 1024 * 1024 * 1024){ // 1G
        item.error = 'sizeError';
        item.state = 'stop';
    }
    uploadCtr.list.push(item);
//    uploadCtr.totalPages = Math.ceil(uploadCtr.list.length / uploadCtr.limit);
//    uploadCtr.showList = uploadCtr.list.slice((uploadCtr.curPage - 1) * uploadCtr.limit, uploadCtr.curPage * uploadCtr.limit);
    uploadCtr.listVisible = true;
}

//上传前判断
function uploadStartHandler(file) {
    var item = uploadCtr.findItemByFile(file);
    if(!item){
        return false;
    }
    item.state = 'inprogress';
//    var index = uploadCtr.findIndex(item);
//    uploadCtr.curPage = Math.floor(index / uploadCtr.limit) + 1;
//    uploadCtr.showList = uploadCtr.list.slice((uploadCtr.curPage - 1) * uploadCtr.limit, uploadCtr.curPage * uploadCtr.limit);
}

//上传成功回调
function successCallback(file, data) {
    var item = uploadCtr.findItemByFile(file);

    data = JSON.parse(data);
    if (data.errorCode != 22000) {
        item.error = 'uploadError';
        item.state = 'stop';
        return;
    }

    item.state = 'finish';

    uploadCtr.list.forEach(function(it, idx){
        if(it.fid == file.id){
            item.thumbUrl = image_base + data.data.link;
            item.serial = data.data.link;
            uploadCtr.showCancelHandler(it, 'hidden');
        }
    });
}
