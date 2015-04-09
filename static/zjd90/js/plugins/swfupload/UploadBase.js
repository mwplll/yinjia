/**
 * Created by zyc on 2014/4/28.
 */

define('UploadBase', ['Upload_SwfUpload','Upload_Handler'], function(SWFUpload){
    var upload = function(params){
        var defaults = {
            upload_url: HOST_URL,
            custom_settings: {
                progressTarget: "",
                cancelButtonId: ""
            },
            // File Upload Settings
            file_size_limit: "1024*1024*2 MB",        // 限制上传文件大小 2MB
            file_upload_limit : 200,
            file_types: "*.jpg;*.jpeg;*.png;",
            file_types_description: "请选择图片格式或压缩文件格式上传",

            file_queued_handler: fileQueued,
            file_queue_error_handler: fileQueueError,
            file_dialog_complete_handler: fileDialogComplete,
            upload_start_handler: uploadStart,
            upload_progress_handler: uploadProgress,
            upload_error_handler: uploadError,
            upload_success_handler: uploadSuccess,
            upload_complete_handler: uploadComplete,

            // Button Settings
            button_image_url: "",
            button_text: "选择证件照上传",
            button_width: "129",
            button_height: "25",
            button_placeholder_id: "",

            // Flash Settings
            flash_url: "../js/plugins/swfupload/vendor/swfupload.swf"
        };
        defaults = mixin(defaults, params);
        this.options = defaults;
    };

    upload.prototype = {
        init: function(){
            var me = this;
            return new SWFUpload(me.options);
        }
    };

    return upload;
});

function mixin(dest, sour){
    for (var property in sour) {
        dest[property] = sour[property];
    }
    return dest;
}
