/**
 * Created by zyc on 2014/4/14.
*/
/*************************上传施工图片*******************************/
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
    upload_url: Global_URL['uploadCADPdf'],
    file_types: '*.pdf;',

    upload_success_handler: successCallback,
    upload_start_handler: uploadStartHandler,

    file_queued_handler: fileQueuedHandler
};

var uploadCtr = avalon.define("UploadController", function(vm){
    vm.listVisible = true;
    vm.inited = false;
    vm.uploadType = 'PDF';

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

//    vm.showList = [];
//    vm.curPage = 1;
//    vm.limit = 2000;
//    vm.totalPages = 0;

    vm.clearHandler = function(){
        uploadCtr.list = [];
//        uploadCtr.showList = [];
//        uploadCtr.curPage = 1;
//        uploadCtr.totalPages = 0;
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
//            uploadCtr.totalPages = Math.ceil(uploadCtr.list.length / uploadCtr.limit);
//            uploadCtr.curPage = Math.min(uploadCtr.curPage, uploadCtr.totalPages) || 1;
//            uploadCtr.showList = uploadCtr.list.slice((uploadCtr.curPage - 1) * uploadCtr.limit, uploadCtr.curPage * uploadCtr.limit);
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

    vm.selectRoomHandler = function(el,room, $index){
        if(!el){
            el.selectRoom['name'] = '';
        }
        el.selectRoom['name'] = room['name'];
        el.selectRoom['index'] = $index;
    }
});
var rooms_model = [
    {name: '立面图'},
    {name: '平面图'},
    {name: '节点图'},
    {name: '施工设计说明'}
];
function fileQueuedHandler(file){
    var item = {
        fid: file.id,
        picId: null,
        thumbUrl:'',
        link:'javascript:void(0);',
        serial: null,
        fname: file.name,
        error: null,
        state: 'wait',
        name: file.name,
        rooms: avalon.mix([], true, rooms_model),
        selectRoom: {
            index: -1,
            name: ''
        }
    };
    if(file.size > 1024 * 1024 * 1024){ // 1G
        item.error = 'sizeError';
        item.state = 'stop';
    }
    uploadCtr.list.push(item);
    uploadCtr.listVisible = true;

    require(['jquery',"Bootstrap"], function(){
         new customDropDown($("#dropdown" + item.fid));
    });
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
            if(uploadCtr.uploadType == 'PDF'){
                item.thumbUrl = base + "images/dwg-03.jpg";
                item.link = download_base + data.data.link;
            }else{
                item.thumbUrl = image_base + data.data.link + THUMB_SIZE['schema'];
            }
            item.serial = data.data.link;
            uploadCtr.showCancelHandler(it, 'hidden');
        }
    });
}
function customDropDown(ele){
    this.dropdown=ele;
    this.placeholder=this.dropdown.find(".placeholder");
    this.options=this.dropdown.find("ul.dropdown-menu > li");
    this.val='';
    this.index=-1;//默认为-1;
    this.initEvents();
}
customDropDown.prototype={
    initEvents:function(){
        var obj=this;
        //这个方法可以不写，因为点击事件被Bootstrap本身就捕获了，显示下面下拉列表
        obj.dropdown.on("click",function(event){
            $(this).toggleClass("active");
        });

        //点击下拉列表的选项
        obj.options.on("click",function(){
            var opt=$(this);
            obj.text=opt.find("a").text();
            obj.val=opt.attr("value");
            obj.index=opt.index();
            obj.placeholder.text(obj.text);
        });
    },
    getText:function(){
        return this.text;
    },
    getValue:function(){
        return this.val;
    },
    getIndex:function(){
        return this.index;
    }
};
/*************************上传施工图片*******************************/


/*************************上传文件*******************************/
var cad_upload_swf = {
    swf: null
};
var cad_upload_params = {
    custom_settings: {
        progressTarget: "UploadCADProgress",
        cancelButtonId: "CancelCADBtn"
    },
    button_placeholder_id: "UploadCADBtn",
    upload_url: Global_URL['uploadCADFileUrl'],
    button_image_url: base + "images/uploadBtn_05.png",
    upload_success_handler: cadSuccessCallback,
    upload_start_handler: cadUploadStartHandler,
    file_types: '*.*;',
    file_queued_handler: cadFileQueuedHandler
};

var cadUploadCtr = avalon.define("CADUploadController", function(vm){
    vm.listVisible = true;
    vm.inited = false;
    vm.uploadType = 'CAD';
    vm.limit = 1;
    vm.curPage = 1;
    vm.totalPages = 0;
    vm.showList = [];

    vm.initHandler = function(){
        cadUploadCtr.clearHandler();
//        if(!cad_upload_swf.swf){
            require(["UploadBase"], function(SwfClass){
                var tmp = new SwfClass(cad_upload_params);
                cad_upload_swf.swf = tmp.init();
                cadUploadCtr.inited = true;
            });
//        }
    };

    vm.list = [];

    vm.clearHandler = function(){
        cadUploadCtr.list = [];
        cadUploadCtr.listVisible = false;
    };

    vm.findItemByFile = function(file){
        for(var i = 0; i < cadUploadCtr.list.length; i++){
            if(cadUploadCtr.list[i].fid == file.id){
                return cadUploadCtr.list[i];
            }
        }
        return null;
    };
    vm.findIndex = function(el){
        var index = null;
        for(var i = 0; i < cadUploadCtr.list.length; i++){
            if(cadUploadCtr.list[i].fid == el.fid){
                index = i;
                break;
            }
        }
        return index;
    };

    vm.cancelUploadHandler = function(e, el){
        if(el.state == 'inprogress' || el.state == 'wait'){
            cad_upload_swf.swf.cancelUpload(el.fid);
        }
        var index = cadUploadCtr.findIndex(el);
        if(index >= 0){
            cadUploadCtr.list.splice(index, 1);
//            cadUploadCtr.totalPages = Math.ceil(cadUploadCtr.list.length / cadUploadCtr.limit);
//            cadUploadCtr.curPage = Math.min(cadUploadCtr.curPage, cadUploadCtr.totalPages) || 1;
//            cadUploadCtr.showList = cadUploadCtr.list.slice((cadUploadCtr.curPage - 1) * cadUploadCtr.limit, cadUploadCtr.curPage * cadUploadCtr.limit);
        }
    };

    vm.showCancelHandler = function(el, type){
        if(el.state == 'inprogress' || el.state == 'wait'){
            return;
        }
        var dom = document.getElementById("cad_del_pic_" + el.fid);
        if(!dom){
            return;
        }
        dom.style.display = (type=='hidden'?"none":"block");
    };

    vm.removeBtnHandler = function(){
        var serials = [];
        cadUploadCtr.list.forEach(function(it){
            if(it.serial){
                serials.push(it.serial);
            }
        });
        if(!serials.length){
            cadUploadCtr.showHandler(false);
            return;
        }
        cadUploadCtr.showHandler(false);
    };
});

function cadFileQueuedHandler(file){
    var item = {
        fid: file.id,
        cad_fid: 'cad_' + file.id,
        thumbUrl: '',
        link: 'javascript:;',
        serial: null,
        fname: file.name,
        error: null,
        state: 'wait',
        name: file.name
    };
    if(file.size > 1024 * 1024 * 1024){ // 1G
        item.error = 'sizeError';
        item.state = 'stop';
    }
//    cadUploadCtr.list.push(item);
    cadUploadCtr.list.splice(0, 1, item);
    cadUploadCtr.listVisible = true;
}

//上传前判断
function cadUploadStartHandler(file) {
    var item = cadUploadCtr.findItemByFile(file);
    if(!item){
        return false;
    }
    item.state = 'inprogress';
}

//上传成功回调
function cadSuccessCallback(file, data) {
    var item = cadUploadCtr.findItemByFile(file);

    data = JSON.parse(data);
    if (data.errorCode != 22000) {
        item.error = 'uploadError';
        item.state = 'stop';
        return;
    }

    item.state = 'finish';

    cadUploadCtr.list.forEach(function(it, idx){
        if(it.fid == file.id){
            if(cadUploadCtr.uploadType == 'CAD'){
                item.thumbUrl = base + "images/dwg-03.jpg";
                item.link = download_base + data.data.link;
            }else if(cadUploadCtr.uploadType == 'PDF'){
                item.thumbUrl = base + "images/dwg-03.jpg";
                item.link = download_base + data.data.link;
            }else{
                item.thumbUrl = image_base + data.data.link;
            }
            item.serial = data.data.link;
            cadUploadCtr.showCancelHandler(it, 'hidden');
        }
    });
}

/*************************上传文件*******************************/
