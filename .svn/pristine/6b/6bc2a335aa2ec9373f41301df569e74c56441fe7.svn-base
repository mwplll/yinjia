/**
 * file:
 * ver:
 * auth: zyc
 * update: 2015/1/12
 * description:
 */
Ext.define("PMS.apps.UploadApp.view.UploadWin",{
    extend: 'Ext.window.Window',
    alias: 'widget.uploadWin',

    width: 500,
    height: 400,
    title: '上传图片',
    modal: true,
    autoShow: true,
    border: false,
    buttonAlign: 'center',
    closable:false,

    autoScroll: false,

    closeAction: 'destroy',

    initComponent:function(){
        var me = this;
        me.items = [
            {
                xtype: 'form',
                border: false,
                itemId: "uploadForm",
                autoScroll: false,
                items: [
                    {
                        layout: 'hbox',
                        border: false,
                        margin: '10 0 0 0',
                        items: [
                            {
                                xtype: 'textfield',
                                fieldLabel: '图片地址',
                                labelAlign: 'right',
                                id: 'fileText',
                                editable:false
                            },
                            {
                                xtype: 'component',
                                autoEl:{
                                    children:{
                                        tag: 'button',
                                        id: 'uploadButton'
                                    }
                                }
                            }
                        ]
                    },
                    {
                        xtype: 'component',
                        id: 'uploadProgress',
                        margin: '20 0 80 60',
                        autoEl: {
                            children: [
                                {
                                    html: '缩略图:'
                                },
                                {
                                    tag: 'img',
                                    id: 'thumbnailImg',
                                    height: 200,
                                    width: 200,
                                    style: 'margin-left: 45px;margin-top:-20px;'
                                }
                            ]
                        }
                    },
                    {
                        xtype: 'component',
                        hidden: true,
                        id: 'cancelButton'
                    }
                ]
            }
        ];
        me.buttons = [
            {
                text: '确认',
                action: 'ConfirmBtn'
            },
            {
                text: '返回',
                action: 'ReturnBtn'
            }
        ];
        me.callParent();
    }
});