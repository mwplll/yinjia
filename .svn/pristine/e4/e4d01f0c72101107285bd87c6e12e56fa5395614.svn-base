/**
 * file:
 * ver:
 * auth: zyc
 * update: 2015/2/11
 * description:
 */
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
    upload_url: Global_URL['uploadHouseUrl'],

    upload_success_handler: successCallback,
    upload_start_handler: uploadStartHandler,

    file_queued_handler: fileQueuedHandler
};

var uploadCtr = avalon.define("UploadController", function(vm){
    vm.listVisible = true;

    vm.initHandler = function(){
        uploadCtr.clearHandler();
//        if(!upload_swf.swf){
        require(["UploadBase"], function(SwfClass){
            var tmp = new SwfClass(upload_params);
            upload_swf.swf = tmp.init();
        });
//        }
    };

    vm.list = [];

    vm.clearHandler = function(){
        uploadCtr.list = [];
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

    vm.cancelUploadHandler = function(e, el){
        if(el.state == 'inprogress' || el.state == 'wait'){
            upload_swf.swf.cancelUpload(el.fid);
        }
        var index = uploadCtr.findIndex(el);
        if(index >= 0){
            uploadCtr.list.splice(index, 1);
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
});

function fileQueuedHandler(file){
    var item = {
        fid: file.id,
        thumbUrl:'',
        serial: null,
        fname: file.name,
        error: null,
        state: 'wait',
        name: file.name
    };
    if(file.size > 1024 * 1024){ // 1G
        item.error = 'sizeError';
        item.state = 'stop';
    }
    if(!uploadCtr.list.length){
        uploadCtr.list.push(item);
    }else{
        uploadCtr.list.splice(0, 1, item);
    }
    uploadCtr.listVisible = true;
}

//上传前判断
function uploadStartHandler(file) {
    var item = uploadCtr.findItemByFile(file);
    if(!item){
        return false;
    }
    item.state = 'inprogress';
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
            if(uploadCtr.uploadType == 'CAD'){
                item.thumbUrl = base + "images/dwg-03.jpg";
            }else{
                item.thumbUrl = image_base + data.data.link;
            }
            item.serial = data.data.link;
            uploadCtr.showCancelHandler(it, 'hidden');
        }
    });
}
