Ext.define("PMS.apps.BuildingApp.view.BuildingWin", {
    extend: 'Ext.window.Window',
    alias: 'widget.buildingWin',
    modal: true,
    border: false,
    autoShow: true,
    title: '新增楼盘',

    width: 400,
    maxHeight: 600,
    autoScroll: true,
    buttonAlign:'center',

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'panel',
                border: false,
                layout: 'fit',
                items:[
                    {
                        xtype: 'buildingBaseForm',
                        border: false,
                        itemId: 'buildingBaseForm'
                    }
                ]
            }
        ];
        me.buttons =  [
            {
                text: '确认保存',
                itemId: 'SaveButton',
                action: 'SaveAction'
            },
            {
                text: '返回',
                handler: this.close,
                scope: this
            }
        ];
        me.callParent()
    }
});

Ext.define("PMS.apps.BuildingApp.view.BuildingBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.buildingBaseForm',
    padding: '10 20 10 20',
    layout: 'column',
    defaults: {
        labelAlign: 'right',
        margin: '10 0 0 0'
    },
    items:[
        {
            xtype: "textfield",
            hidden: true,
            allowBlank: true,
            name: 'buildingId'
        },
        {
            xtype: 'combo',
            fieldLabel: '省份' + '<font color = red>*</font>',
            name: 'province',
            store: Ext.create("Ext.data.Store", {
                fields: ['value', 'name'],
                data: [
                    {value: "330000", name: "浙江省"}
                ]
            }),
            valueField: "value",
            displayField: "name",
            queryMode: 'local',
            allowBlank: false,
            editable: false,
            value: "330000"
        },
        {
            fieldLabel: "城市" + '<font color = red>*</font>',
            xtype: "combo",
            itemId: "cityCombo",
            name: 'cityId',
            valueField: 'id',
            displayField: 'name',
            allowBlank: false,
            queryMode: 'local',
            editable: false
        },
        {
            fieldLabel: "区域" + '<font color = red>*</font>',
            xtype: "combo",
            itemId: "areaCombo",
            name: 'areaId',
            allowBlank: false,
            valueField: 'id',
            queryMode: 'local',
            displayField: 'name',
            editable: false
        },
        {
            xtype: "textfield",
            hidden: true,
            allowBlank: true,
            name: 'companyId'
        },
        {
            xtype: "textfield",
            fieldLabel: "房产公司:" + '<font color = red>*</font>',
            allowBlank: false,
            name: 'company'
        },
        {
            xtype: "textfield",
            fieldLabel: "楼盘名称:" + '<font color = red>*</font>',
            allowBlank: false,
            name: 'name'
        }
    ]

});