/**
 * file:
 * ver:
 * auth: zyc
 * update: 2015/1/23
 * description:
 */
Ext.define('PMS.BaseComp.Ueditor',{
    //继承FieldContainer
    extend:'Ext.form.FieldContainer',
    //继承Field的方法
    mixins: {
        field: Ext.form.field.Field
    },

    requires: [
        'lib.ueditor1_4_3-utf8-php.ueditor_config',
        'lib.ueditor1_4_3-utf8-php.ueditor_all_min'
    ],

    //定义widget的ueditor组件可使用xtype为ueditor
    alias: 'widget.ueditor',
    //编辑器可使用别名
    alternateClassName: 'Ext.form.UEditor',
    //定义编辑器的实例
    ueditorInstance: null,
    //标识是否初始化组件
    initialized: false,
    initComponent: function () {
        var me = this;
        //添加事件
        me.addEvents('initialize', 'change');
        //定义编辑器id
        var id = me.id + '-ueditor';
        //me.html为在组件渲染后自动加入的html代码
        me.html = '<script id="' + id + '" type="text/plain" name="' + me.name + '"></script>';
        //调用当前方法的父类方法详见Ext.Base
        me.callParent(arguments);
        //在mixins中的组件使用前需要调用此方法
        me.initField();
        //在组件渲染后触发该方法
        me.on('render', function () {
//            var width = me.width - 105;
//            var height = me.height - 109;
            var width = Ext.ToolUtil.getWindowWidth() - 210;
            var height = Ext.ToolUtil.getWindowHeight() - 150 - 109;

            //进入了编辑器配置
            var config = {
                initialFrameWidth: width, initialFrameHeight: height
            };
            //得到编辑器实例
            me.ueditorInstance = UE.getEditor(id, config);
            me.ueditorInstance.ready(function () {
                me.initialized = true;
                //触发编辑器事件
                me.fireEvent('initialize', me);
                //添加编辑器内容改变监听事件
                me.ueditorInstance.addListener('contentChange', function () {
                    me.fireEvent('change', me);
                });
            });

//            // 自定义请求地址
//            UE.Editor.prototype._bkGetActionUrl = UE.Editor.prototype.getActionUrl;
//            UE.Editor.prototype.getActionUrl = function(action) {
//                if (action == 'uploadimage') {
//                    return dev_base + 'data/image/upload?type=goods&_dt=' + Math.random()
//                }
//            }
        });
    },
    //自定义方法获取编辑器值，后面方法不做详细介绍了，可以根据需要自定义方法
    setValue: function (value) {
        var me = this;
        if (value === null || value === undefined) {
            value = '';
        }
        if (me.initialized) {
            me.ueditorInstance.setContent(value);
        }
        return me;
    },
    getHtmlValue: function () {
        var me = this,
            value = '';
        if (me.initialized) {
            value = me.ueditorInstance.getContent();
        }
        me.value = value;
        return value;
    },
    getPlainTxt: function () {
        var me = this,
            value = '';
        if (me.initialized) {
            value = me.ueditorInstance.getPlainTxt();
        }
        me.value = value;
        return value;
    },
    onDestroy: function () {
        var me = this;
        if(me.initialized){
            me.ueditorInstance.destroy();
        }
    }
});