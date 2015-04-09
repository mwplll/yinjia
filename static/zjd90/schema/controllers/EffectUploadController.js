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
    {name: '主卧', picId:''},
    {name: '次卧', picId:''},
    {name: '厨房', picId:''},
    {name: '客厅', picId:''},
    {name: '餐厅', picId:''},
    {name: '客餐厅', picId:''},
    {name: '卫生间', picId:''},
    {name: '书房', picId:''},
    {name: '儿童房', picId:''},
    {name: '阳台', picId:''}
];
function fileQueuedHandler(file){
    var item = {
        fid: file.id,
        picId: null,
        thumbUrl:'',
        serial: null,
        fname: file.name,
        error: null,
        state: 'wait',
        name: file.name,
        rooms: avalon.mix([], true, rooms_model),
        selectRoom: {
            index: -1,
            name: '',
            picId: ''
        }
    };
    if(file.size > 1024 * 1024 * 1024){ // 1G
        item.error = 'sizeError';
        item.state = 'stop';
    }
    uploadCtr.list.push(item);
    uploadCtr.listVisible = true;

    require(['jquery',"Bootstrap"], function(){
        var mydropdown1 = new customDropDown($("#dropdown" + item.fid));
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
            item.thumbUrl = image_base + data.data.link + THUMB_SIZE['schema'];
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