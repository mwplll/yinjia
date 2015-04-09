/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-4-2
 * Time: 上午10:47
 * To change this template use File | Settings | File Templates.
 */

/**
 * 自定义表单验证
 * 1.密码校验 判断两次输入的密码是否一致
 * 2.验证数字框输入为正数
 */
Ext.apply(Ext.form.VTypes, {
    password: function (val, field) {
        if (field.initialPassField) {
            var pwd = Ext.getCmp(field.initialPassField);
            return (val == pwd.getValue());
        }
        return true;
    },
    passwordText: '两次输入的密码不一致!',
    rPassword: function (val, field) {
        if (field.rPassword) {
            //通过targetCmpId的字段查找组件
            var cmp = Ext.getCmp(field.rPassword.targetCmpId);
            if (Ext.isEmpty(cmp)) {//如果组件（表单）不存在，提示错误
                Ext.MessageBox.show({
                    title: '错误',
                    msg: '发生异常错误，指定的组件未找到',
                    icon: Ext.Msg.ERROR,
                    buttons: Ext.Msg.OK
                });
                return false;
            }
            //取得目标组件（表单）的值，与宿主表单的值进行比较。
            return  (val == cmp.getValue());
        }
    },
    rPasswordText: '两次输入的密码不一致!',

    positive: function (val, field) {
        return (val >= 0 );
    },

    positiveText: '请输入正数!',

    nonNegative: function (val, field) {
        return (val >= 0 );
    },
    // color lab 格式验证
    labCheck: function (val, field) {
        var reg = /^(-?\d+)(\.\d+)?,(-?\d+)(\.\d+)?,(-?\d+)(\.\d+)?$/;
        return reg.test(val);
    },

    labCheckText: '实际颜色格式错误！',

    nonNegativeText: '请输入大于等于0的数!',

    //不允许为空时可以过滤空格代码
    validator: function (text, field) {
        if(field.allowBlank == false && Ext.util.Format.trim(text).length == 0)
            return false;
        else
            return true;
    },
    validatorText: "不能为空"
});