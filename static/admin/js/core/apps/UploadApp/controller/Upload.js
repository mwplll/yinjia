/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 12-12-18
 * Time: 上午11:34
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.UploadApp.controller.Upload", {
    extend: 'Ext.app.Controller',

    views: [
        'PMS.apps.UploadApp.view.UploadWin'
    ],

    refs: [
        {
            selector: "uploadWin",
            ref: 'uploadWin'
        }
    ],

    targetCtr: null,

    data: {},

    uploaded: false,
    uploadUrl: '',

    init: function () {
        var me = this;
        console.log("Upload Controller initialized!");

        this.control({
            'uploadWin': {
                afterrender: function () {
                }
            },
            'uploadWin button[action=ReturnBtn]': {
                click: function () {
                    var me = this;
                    me.getUploadWin().close();
                }
            },
            'uploadWin button[action=ConfirmBtn]': {
                click: function () {
                    var me = this;
                    if (!me.uploaded) {
                        Ext.Msg.alert("提示", "请先上传图片！");
                        return;
                    }

                    me.getUploadWin().close();

                    me.targetCtr.fireEvent("AfterImageUpload", {
                        serial: me.data.link
                    });
                }
            }
        });
    },

    doInitial: function () {
        var me = this;
        Ext.widget("uploadWin", {
            title: "上传图片"
        });

        Ext.require(
            [
                'lib.swfupload.swfupload',
                'lib.swfupload.swfupload_queue',
                'lib.swfupload.fileprogress',
                'lib.swfupload.handlers'
            ],
            function(){
                me.initSetForUpload();
            }
        );
    },

    initSetForUpload: function () {
        var me = this;
        var swf,url = me.uploadUrl;

        swf = new SWFUpload({
            flash_url: "lib/swfupload/swfupload.swf",
            upload_url: url,
            custom_settings: {
                progressTarget: "uploadProgress",
                cancelButtonId: "cancelButton"
            },
            file_size_limit: "102400",
            file_types: "*.png;*.jpg;*.jpeg;*.gif;",
            button_width: "80",
            button_height: "29",
            button_placeholder_id: "uploadButton",
            button_text: '<span class="theFont">选择图片</span>',
            button_text_style: ".theFont {font-size:14px;font-weight:bold;}",

            file_queue_error_handler: fileQueueError,
            file_dialog_complete_handler: fileDialogComplete,
            upload_start_handler: uploadStart,
            upload_progress_handler: uploadProgress,
            upload_error_handler: uploadError,
            upload_success_handler: successCallback,
            upload_complete_handler: uploadComplete
        });

        function successCallback(file, ac) {
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setComplete();
            progress.toggleCancel(false);

            var action = Ext.JSON.decode(ac);
            if (action.errorCode != 22000) {
                Ext.Msg.alert("提示", action.msg);
                progress.setStatus("已取消.");
                return;
            }
            progress.setStatus("已完成.");

            var serial =  action.data.link;
            var src = image_base + serial + THUMB_SIZE['thumb'];
            me.data = action.data;

            me.uploaded = true;

            Ext.ImgAdjustUtil.imgAdjust(src, 200, 160, function (h, w) {
                Ext.get("thumbnailImg").dom.src = src;
                Ext.get("thumbnailImg").setSize(w, h, {
                    duration: 500
                });
            });
            Ext.getCmp("fileText").setValue(file.name);
        }
    }
});