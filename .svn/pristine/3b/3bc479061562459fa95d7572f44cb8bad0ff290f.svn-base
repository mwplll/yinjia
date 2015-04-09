/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 13-8-27
 * Time: 下午9:52
 * To change this template use File | Settings | File Templates.
 */

// 带全选按钮的 checkboxGroup
// 自动绑定全选/全不选 操作
// store 对应的数据model fields: ['label', 'value']

Ext.define("PMS.BaseComp.CheckBoxGroup", {
    extend:'Ext.form.CheckboxGroup',
    alias:'widget.multiSelectBoxes',

    name:'',
    showSelectAll:false,
    model:{
        label:'label',
        value:'value'
    },

    changeHandler: null,

    initComponent:function () {
        var me = this;
        me.callParent();
    },

    afterRender:function () {
        var me = this;
        me.callParent();
    },

    bindEvents:function () {
        var me = this,
            selectAll = me.queryById("selectAll");

        Ext.each(me.query("checkbox"), function (item) {
            item.on("change", ChangeHandler);
        });

        function ChangeHandler(checkbox, ischecked) {
            if (checkbox.getItemId() == 'selectAll') {
                me.changeAll(ischecked);
            } else if (!ischecked) {
                // hack 不再触发 change
                selectAll.checked = false;
                selectAll.value = false;
                selectAll.lastValue = false;// 根据lastValue触发change事件
                selectAll.getEl().dom.className =
                    "x-field x-form-item x-field-default x-checkboxgroup-form-item";
            }
        }

    },
    changeAll:function (ischecked) {
        var me = this;
        Ext.each(me.query("checkbox"), function (item) {
            item.setValue(ischecked);
        });
    },

    setFormValues:function(store, callback){
        this.setValues(store, callback);
    },
    setValues:function (store, callback) {
        var me = this;
        me.add({
            boxLabel:'全选',
            name:'selectAll',
            itemId:'selectAll',
            hidden:me.showSelectAll
        });
        if(!store){
            return;
        }
        store.each(function (r) {
            if (me.model.hasOwnProperty('num')) {
                me.add({
                    num:r.get(me.model.num),
                    boxLabel:r.get(me.model.label),
                    inputValue:r.get(me.model.value),
                    name:me.name
                })
            }
            else {
                me.add({
                    boxLabel:r.get(me.model.label),
                    inputValue:r.get(me.model.value),
                    name:me.name
                });
            }
        });

        me.bindEvents();
        if (callback) {
            callback();
        }
    },

    getFormValues:function () {
        var me = this;

        return me.getValue();
    }
});