/**
 * Created with IntelliJ IDEA.
 * User: admin
 * Date: 13-5-17
 * Time: 下午6:12
 * To change this template use File | Settings | File Templates.
 */
Ext.define("PMS.apps.DesignApp.view.DesignWin", {
    extend: 'Ext.window.Window',
    alias: 'widget.designWin',
    modal: true,
    border: false,
    autoShow: true,
    title: '方案详情',

    width: 1000,
    height: 550,
    y: 40,
    autoScroll: true,
    buttonAlign:'center',

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'tabpanel',
                itemId: 'tabPanel',
                border: false,
                items: [
                    {
                        xtype: 'designBaseForm',
                        itemId: 'designBaseForm',
                        title: '基本信息',
                        autoScroll: true,
                        border: false,
                        index: 0
                    },
                    {
                        xtype: 'designRooms',
                        itemId: 'designRoomForm',
                        autoScroll: true,
                        title: '房间信息',
                        border: false,
                        index: 1
                    },
                    {
                        xtype: 'cadRooms',
                        itemId: 'designCadForm',
                        autoScroll: true,
                        title: '施工图信息',
                        border: false,
                        index: 2
                    },
                    {
                        xtype: 'materialRooms',
                        itemId: 'designMaterialForm',
                        autoScroll: true,
                        maxHeight: 600,
                        title: '建材信息',
                        border: false,
                        index: 3
                    }
                ]
            }

        ];
        me.buttons =  [
            {
                text: '审核成功',
                itemId: 'SuccessButton'
            },
            {
                text: '审核失败',
                itemId: 'FailButton'
            },
            {
                text: '取消',
                handler: this.close,
                scope: this
            }
        ];
        me.callParent()
    }
});

Ext.define("PMS.apps.DesignApp.view.DesignBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.designBaseForm',
    padding: '10 5 20 5',

    items:[
        {
            xtype: 'fieldset',
            collapsible: true,
            title: '方案基本信息',
            defaults:{
                labelWidth: 100,
                border: false,
                margin: "10 0 10 0",
                allowBlank: false,
                labelAlign: 'right'
            },
//            layout: 'hbox',
            items: [
                {
                    xtype: 'form',
                    layout:'hbox',
                    itemId: 'detailBaseForm',
                    border: false,
                    items: [
                        {
                            xtype: 'label',
                            text: '方案主图：'
                        },
                        {
                            width: 200,
                            height: 200,
                            border: true,
                            itemId: 'designImageBoxWrap',
                            margin: "10 20 10 10",
                            items: [
                                {
                                    xtype: 'image',
                                    itemId: 'designImageBox',
                                    border: true,
                                    width: 200,
                                    height: 200,
                                    region: 'center'
                                }
                            ]
                        },
                        {
                            xtype: 'panel',
                            border: false,
                            defaults:{
                                labelWidth: 100,
                                border: false,
                                margin: "0 0 10 0",
                                labelAlign: 'right'
                            },
                            items: [
                                {
                                    xtype: 'textfield',
                                    name: 'name',
                                    width: 400,
                                    fieldLabel: '方案名称'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'designSn',
                                    fieldLabel: '方案编号'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'id',
                                    allowBlank: true,
                                    hidden: true
                                },
                                {
                                    border: false,
                                    layout: 'hbox',
                                    defaults:{
                                        labelWidth: 100,
                                        border: false,
                                        labelAlign: 'right'
                                    },
                                    items: [
                                        {
                                            xtype: 'numberfield',
                                            name: 'price',
                                            width: 180,
                                            vtype: 'positive',
                                            fieldLabel: '设计费(元)'
                                        },
                                        {
                                            xtype: 'numberfield',
                                            vtype: 'positive',
                                            name: 'manualPrice',
                                            width: 180,
                                            fieldLabel: '施工费(元)'
                                        },
                                        {
                                            xtype: 'numberfield',
                                            vtype: 'positive',
                                            name: 'materialPrice',
                                            width: 180,
                                            fieldLabel: '材料费(元)'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'numberfield',
                                    vtype:'positive',
                                    name: 'totalPrice',
                                    fieldLabel: '装修总价(元)'
                                },
                                {
                                    xtype: 'textarea',
                                    width: 400,
                                    name: 'content',
                                    fieldLabel: '设计说明'
                                }
                            ]
                        }
                    ]
                }

            ]
        },
        {
            xtype: 'fieldset',
            collapsible: true,
            title: '户型基本信息',
            defaults:{
                labelWidth: 100,
                border: false,
                margin: "10 0 10 0",
                allowBlank: false,
                labelAlign: 'right'
            },
            layout: 'hbox',
            items: [
                {
                    xtype: 'form',
                    border: false,
                    layout: 'hbox',
                    itemId:'houseBaseForm',
                    items: [
                        {
                            xtype: 'label',
                            text: '户型主图：'
                        },
                        {
                            width: 200,
                            margin: "10 0 10 10",
                            height: 200,
                            border: true,
                            itemId: 'houseImageBoxWrap',
                            items: [
                                {
                                    xtype: 'image',
                                    border: true,
                                    itemId: 'houseImageBox',
                                    width: 200,
                                    height: 200,
                                    region: 'center'
                                }
                            ]
                        },
                        {
                            xtype: 'panel',
                            border: false,
                            defaults:{
                                labelWidth: 100,
                                border: false,
                                columnWidth:.25,
                                margin: "0 0 10 0",
                                labelAlign: 'right'
                            },
                            items: [
                                {
                                    xtype: 'textfield',
                                    name: 'name',
                                    width: 400,
                                    fieldLabel: '户型名称'
                                },
                                {
                                    layout: 'hbox',
                                    border: false,
                                    defaults:{
                                        labelWidth: 100,
                                        border: false,
                                        width: 150,
                                        labelAlign: 'right'
                                    },
                                    items:[
                                        {
                                            xtype: 'numberfield',
                                            name: 'grossArea',
                                            width: 170,
                                            vtype:'positive',
                                            fieldLabel: '建筑面积'
                                        },
                                        {
                                            xtype: 'numberfield',
                                            vtype:'positive',
                                            name: 'usableArea',
                                            width: 200,
                                            fieldLabel: '使用面积'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'prov',
                                    fieldLabel: '省份'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'city',
                                    fieldLabel: '城市'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'area',
                                    fieldLabel: '地区'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'building',
                                    width: 400,
                                    fieldLabel: '楼盘'
                                }
                            ]
                        }
                    ]
                }

            ]
        }
    ]
});
Ext.define("PMS.apps.DesignApp.view.DesignRooms",{
    extend: 'Ext.grid.GridPanel',
    alias: 'widget.designRooms',

    margin: "10 0 20 0",
    border: false,
    store: null,
    columns: [
        {
            header: '房间名称',
            dataIndex: 'name',
            sortable: false,
            align: "center",
            flex: 1
        },
        {
            header: '图片',
            dataIndex: 'room_thumbUrl',
            sortable: false,
            align: "center",
            flex: 2
        }
    ]
});
Ext.define("PMS.apps.DesignApp.view.CadRooms",{
    extend: 'Ext.panel.Panel',
    alias: 'widget.cadRooms',
    border: false,
    margin: "10 0 20 0",
    items: [
        {
            xtype: 'grid',
            border: false,
            store: null,
            columns: [
                {
                    header: '施工图名称',
                    dataIndex: 'name',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: 'pdf文件',
                    dataIndex: 'room_link',
                    sortable: false,
                    align: "center",
                    flex: 2
                }
            ]
        },
        {
            layout: 'hbox',
            border: false,
            items: [
                {
                    xtype: 'textfield',
                    name: 'file',
                    itemId: 'cadFile',
                    margin: "10 0 20 0",
                    labelAlign: 'right',
                    width: 500,
                    labelWidth: 80,
                    fieldLabel: '施工文件'
                },
                {
                    xtype: 'button',
                    text: '下载文件',
                    margin: '10 0 0 10',
                    itemId: 'LinkButton'
                }
            ]
        }
    ]


});

Ext.define("PMS.apps.DesignApp.view.MaterialRooms",{
    extend: 'Ext.panel.Panel',
    alias: 'widget.materialRooms',
    border: false,
    margin: "10 0 20 0",
    items: [
        {
            xtype: 'fieldset',
            margin: "10 0 10 0",
            padding: '10 5 10 5',
            title: '人工加附料',
            collapsible: true,
            items: [
                {
                    xtype: 'grid',
                    border: false,
                    itemId: 'materialManuGrid',
                    columns: [
                        {
                            header: '项目名称',
                            dataIndex: 'name',
                            sortable: false,
                            align: "center",
                            flex: 2
                        },

                        {
                            header: '单位',
                            dataIndex: '',
                            sortable: false,
                            align: "center",
                            flex: 1,
                            renderer: function(){
                                return "m²";
                            }
                        },
                        {
                            header: '单价',
                            dataIndex: 'price',
                            sortable: false,
                            align: "center",
                            flex: 1
                        },
                        {
                            header: '用量',
                            dataIndex: 'manual_num',
                            sortable: false,
                            align: "center",
                            flex: 1
                        },
                        {
                            header: '总价',
                            dataIndex: 'manual_total',
                            sortable: false,
                            align: "center",
                            flex: 1
                        }
                    ]
                }
            ]
        }
    ]
});

Ext.define("PMS.apps.DesignApp.view.MaterialGrid",{
    extend: 'Ext.form.FieldSet',
    alias: 'widget.materialGrid',
    margin: "10 0 10 0",
    padding: '10 5 10 5',
    title: '',
    collapsible: true,
    items: [
        {
            layout: 'hbox',
            border: false,
            margin: "0 0 15 0",
            defaults:{
                labelWidth: 80,
                border: false,
                width: 250,
                labelAlign: 'right'
            },
            items: [
                {
                    xtype: 'numberfield',
                    vtype: 'positive',
                    itemId: 'roomArea',
                    fieldLabel: '房间面积'
                },
                {
                    xtype: 'numberfield',
                    vtype: 'positive',
                    itemId: 'unitPrice',
                    fieldLabel: '单方造价'
                },
                {
                    xtype: 'numberfield',
                    vtype: 'positive',
                    itemId: 'totalPrice',
                    fieldLabel: '总造价'
                }
            ]
        },
        {
            xtype: 'grid',
            itemId: 'materialList',
            border: false,
            store: null,
            columns: [
                {
                    header: '编号',
                    dataIndex: 'materialNo',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: '项目名称',
                    dataIndex: 'materialName',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: '建材名称',
                    dataIndex: 'goodsName',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: '单位',
                    dataIndex: 'unit',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: '单价',
                    dataIndex: 'sellPrice',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: '用量',
                    dataIndex: 'num',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: '总价',
                    dataIndex: 'totalPrice',
                    sortable: false,
                    align: "center",
                    flex: 1
                },
                {
                    header: '备注',
                    dataIndex: 'content',
                    sortable: false,
                    align: "center",
                    flex: 1
                }
            ]
        }
    ]
});