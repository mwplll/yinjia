/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.HouseApp.view.HouseWin", {
    extend: 'Ext.panel.Panel',
    alias: 'widget.houseWin',
    modal: true,
    border: false,

    autoScroll: true,
    buttonAlign:'center',

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'panel',
                border: false,
                items:[
                    {
                        xtype: 'houseBaseForm',
                        border: false,
                        itemId: 'houseBaseForm'
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
                itemId: 'ReturnButton',
                scope: this
            }
        ];
        me.callParent()
    }
});
Ext.define("PMS.apps.HouseApp.view.HouseBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.houseBaseForm',
    padding: '10 5 20 5',

    items:[
        {
            xtype: 'fieldset',
            collapsible: false,
            border: false,
            defaults:{
                labelWidth: 100,
                border: false,
//                width: 220,
                columnWidth: 0.25,
                margin: "0 0 10 0",
                allowBlank: false,
                labelAlign: 'right'
            },
            layout: 'column',
            items:[
                {
                    xtype: 'textfield',
                    name: 'name',
                    columnWidth:.8,
                    fieldLabel: '户型名称'+ '<font color = red>*</font>'
                },
                {
                    xtype: 'textfield',
                    name: 'houseId',
                    allowBlank: true,
                    hidden: true
                },
                {
                    xtype: 'numberfield',
                    name: 'grossArea',
                    vtype:'positive',
                    fieldLabel: '建筑面积(m²)'+ '<font color = red>*</font>'
                }, {
                    xtype: 'numberfield',
                    labelWidth: 120,
                    vtype:'positive',
                    allowBlank: false,
                    name: 'usableArea',
                    fieldLabel: '可使用面积(m²)'+ '<font color = red>*</font>'
                }
            ]
        },

        {
            xtype: 'fieldset',
            collapsible: false,
            defaults:{
                labelWidth: 60,
                margin: "0 0 10 0",
                labelAlign: 'right',
                allowBlank: false,
                border: false
            },
            layout: 'column',
            border: false,
            items:[
                {
                    xtype: 'combo',
                    fieldLabel: '省份'+ '<font color = red>*</font>',
                    width: 150,
                    name: 'provId',
                    store: Ext.create("Ext.data.Store", {
                        fields: ['value', 'name'],
                        data: [
                            {value: "330000", name: "浙江省"}
                        ]
                    }),
                    valueField: "value",
                    displayField: "name",
                    queryMode: 'local',
                    editable: false,
                    allowBlank: false,
                    value: "330000"
                }, {
                    xtype: 'combo',
                    fieldLabel: '城市'+ '<font color = red>*</font>',
                    width: 150,
                    itemId: "cityCombo",
                    name: 'cityId',
                    valueField: "id",
                    displayField: "name",
                    queryMode: 'local',
                    allowBlank: false,
                    editable: false
                },{
                    xtype: 'combo',
                    fieldLabel: '区域'+ '<font color = red>*</font>',
                    width: 150,
                    itemId: "areaCombo",
                    name: 'areaId',
                    valueField: "id",
                    displayField: "name",
                    queryMode: 'local',
                    allowBlank: false,
                    editable: false,
                    value: ""
                },
                {
                    xtype: 'combo',
                    width: 230,
                    name: 'buildingId',
                    itemId: 'buildingCombo',
                    fieldLabel: '楼盘名'+ '<font color = red>*</font>',
                    valueField:"id",
                    displayField: "name",
                    store: 'PMS.apps.HouseApp.store.BuildingStore',
                    queryMode: 'local',
                    allowBlank: false,
                    editable: false,
                    blankText: '楼盘不能为空'
                }
            ]
        },

        {
            xtype: 'fieldset',
            collapsible: true,
            title: '户型图',
            defaults:{
                labelWidth: 100,
                border: false,
                margin: "0 0 10 0",
                allowBlank: false,
                labelAlign: 'right'
            },
            layout: 'column',
            items:[
                {
                    width: 200,
                    height: 200,
                    border: true,
                    itemId: 'imageBoxWrap',
                    margin: "0 0 10 45",
                    items: [
                        {
                            xtype: 'image',
                            itemId: 'imageBox',
                            border: true,
                            width: 200,
                            height: 200,
                            region: 'center'
                        }
                    ]
                },
                {
                    xtype: 'button',
                    itemId: 'uploadHouseButton',
                    width: 40,
                    margin: '0 0 0 20',
                    text: '上传'
                },

                {
                    xtype: 'textfield',
                    name: 'pic',
                    itemId: "picTextField",
                    width: 350,
                    hidden: true,
                    fieldLabel: '户型图'
                }
            ]
        }
    ],

    getFormValues: function(){
        var me = this;
        var values = me.getForm().getValues();

        return values;
    }

});
Ext.define("PMS.apps.HouseApp.view.HouseRooms",{
    extend: 'Ext.form.FieldSet',
    alias: 'widget.houseRooms',

    items:[
        {
            xtype: 'grid',
            columnWidth: 1,
            itemId: 'houseRoomsGrid',
            margin: "0 0 20 0",
            maxWidth: 300,
            border: false,
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 1,
                    pluginId: 'rowEditingPlugin'
                })
            ],
            selType: 'cellmodel',
            columns: [
                {
                    header: '空间名称',
                    dataIndex: 'room_name',
                    sortable: false,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'textfield',
                        allowBlank: true
                    }
                } ,
                {
                    header: "空间大小(m²)",
                    dataIndex: 'room_area',
                    sortable: true,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'numberfield',
                        allowBlank: false,
                        minValue: 0,
                        vtype: 'positive'
                    }
                },
                {
                    menuDisabled: true,
                    sortable: false,
                    align:"center",
                    xtype: 'actioncolumn',
                    width: 50,
                    items: [
                        {
                            iconCls: 'delete-col',
                            tooltip: '删除',
                            handler: function(grid, rowIndex, colIndex) {
                                grid.getStore().removeAt(rowIndex);
                            }
                        }
                    ]
                }
            ],
            tbar: [
                {
                    xtype: "toolbar",
                    border: false,
                    items: [
                        {
                            xtype: "button",
                            text: "新增",
                            iconCls: "add",
                            itemId: "addRoomButton",
                            action: "addRoom"
                        }
                    ]
                }
            ]
        }
    ],

    afterRender: function () {
        var me = this;

        me.callParent();
        me.bindEvents();
    },

    bindEvents: function () {
        var me = this;
        var rowEditing;
        var grid = me.queryById("houseRoomsGrid");

        // 新增
        grid.queryById("addRoomButton").on("click", function () {
            rowEditing = grid.getPlugin('rowEditingPlugin');
            rowEditing.cancelEdit();

            // Create a model instance
            var r = Ext.create('PMS.apps.HouseApp.model.HouseRoomModel', {
                'room_id': '',
                'room_name': '',
                'room_area': ''
            });

            grid.getStore().insert(0, r);
            rowEditing.startEdit(0, 0);
        });
    }
});