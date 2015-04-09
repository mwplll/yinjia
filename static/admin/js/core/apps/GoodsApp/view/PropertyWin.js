Ext.define("PMS.apps.GoodsApp.view.PropertyWin", {
    extend: 'Ext.window.Window',
    alias: 'widget.propertyWin',

    width:600,
    minHeight: 500,

    title: '新增规格',
    modal: true,
    border: false,
    autoShow: true,
    draggable: true,

    buttonAlign:'center',

    initComponent: function(){
        var me = this;
        me.items = [
            {
                xtype: 'panel',
                border: false,
                items:[
                    {
                        xtype: 'propertyBaseForm',
                        border: false,
                        itemId: 'propertyBaseForm'
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
Ext.define("PMS.apps.GoodsApp.view.SkuBaseForm",{
    extend: 'Ext.form.Panel',
    alias: 'widget.propertyBaseForm',
    defaults: {
        labelWidth: 100,
        labelAlign: 'right',
        padding:"5 0 5 0",
        blankText:"不能为空",
        border: false
    },
    items:[
        {
            xtype: "numberfield",
            hidden: true,
            allowBlank: true,
            name: 'id'
        },
        {
            xtype: "textfield",
            fieldLabel: "属性名称:",
            allowBlank: false,
            name: 'name'
        },
//        {
//            xtype: 'combo',
//            fieldLabel: '显示类型',
//            itemId: "typeCombo",
//            name: 'type',
//            store: Ext.create("Ext.data.Store", {
//                fields: ['value', 'name'],
//                data: [
//                    {value: "0", name: "文字"},
//                    {value: "1", name: "图片"}
//                ]
//            }),
//            valueField: "value",
//            displayField: "name",
//            queryMode: 'local',
//            editable: false,
//            value: "0"
//        },
        {
            xtype: 'propertyItem',
            margin: '0 0 0 100',
            itemId: 'propertyItem'
        }
    ],

    afterRender: function () {
        var me = this;

        me.callParent();
        me.bindEvents();
    },

    bindEvents: function () {
        var me = this;
        var combo = me.queryById("typeCombo"),
            grid = me.queryById("propertyItem").queryById("propertyItemGrid");

        combo.on("change", function () {
            var v = Number(combo.getValue());
            if(v == 1){
                grid.columns[0].show();
            }else{
                grid.columns[0].hide();
            }
        });
        var rowEditing;
        grid.queryById("addSkuItemButton").on("click", function () {
            rowEditing = grid.getPlugin('rowEditingPlugin');
            rowEditing.cancelEdit();

            // Create a model instance
            var r = Ext.create('PMS.apps.GoodsApp.model.SkuItemModel', {
                'value': '',
                'serial': '',
                'thumbUrl': ''
            });

            grid.getStore().add(r);


            var v = Number(combo.getValue());
            if(v == 1){
                rowEditing.startEdit(grid.getStore().getCount() - 1, 1);
                coreApp.fireEvent("UploadImage", {
                    targetCtr: me,
                    uploadUrl: dev_base + 'data/image/upload?type=spec&_dt=' + Math.random()
                });
            }else{
                rowEditing.startEdit(grid.getStore().getCount() - 1, 0);
            }
        });

        // 自定义事件 监听图片上传完成
        me.on({
            AfterImageUpload: function (data) {

                var store = grid.getStore(),
                    count = store.getCount(),
                    record = store.getAt(count - 1);
                record.set("serial", data.serial);

                var url = image_base + data.serial,
                    img = "<img src='"+ url+ "' height='40px'>";
                record.set("thumbUrl", img);

            }
        });
    },

    getFormValues: function(){
        var me = this,
            grid = me.queryById("propertyItem").queryById("propertyItemGrid"),
            store = grid.getStore(),
            values = me.getForm().getValues();
        var pd = {
            name: values.name,
            id: values.id || null,
            type: Number(values.type)
        };
        if(pd.type == 1){
            // 图片类型
            var pic = [], picName = [], fg = false;
            store.each(function(re){
                if(re.get('serial')){
                    pic.push(re.get("serial"));
                    picName.push(re.get("value"));
                }else{
                    fg = true;
                }
            });
            if(fg || !pic.length){
                return {
                    error: '请上传规格图片',
                    success: false
                }
            }
            pd['pic'] = pic;
            pd['picName'] = picName;
        }else{
            var tp = [];
            store.each(function(re){
                if(re.get('value')){
                    tp.push(re.get("value"));
                }
            });

            if(!tp.length){
                return {
                    error: '请填写规格值',
                    success: false
                }
            }
            pd['value'] = tp.toString();
        }
        console.log("property data:");
        console.log(pd);
        return pd;
    },

    setFormValues: function(record){
        var me = this,
            grid = me.queryById("propertyItem").queryById("propertyItemGrid");
        if(!record){
            grid.bindStore(Ext.create("Ext.data.Store", {
                model: 'PMS.apps.GoodsApp.model.SkuItemModel',
                data: []
            }));
            return;
        }
        me.getForm().loadRecord(record);
        var tp = [], i = 0;
        if(Number(record.get('type')) == 1){
            var pic = record.get("pic"), picName = record.get('picName');
            for(i = 0;i<pic.length;i++){
                tp.push({
                    value: picName[i],
                    serial: pic[i]
                })
            }
        }else{
            grid.columns[0].hide();
//            var tp2 = Ext.decode(record.get("value"));
            var tp2 = record.get("value").split(",");
            for(i = 0;i< tp2.length;i++){
                tp.push({
                    value: tp2[i]
                })
            }
        }
        var st = Ext.create("Ext.data.Store", {
            model: 'PMS.apps.GoodsApp.model.SkuItemModel',
            data: tp
        });
        grid.bindStore(st);
    }

});

Ext.define("PMS.apps.GoodsApp.view.SkuItem",{
    extend: 'Ext.form.FieldSet',
    alias: 'widget.propertyItem',

    items:[
        {
            xtype: 'grid',
            columnWidth: 1,
            itemId: 'propertyItemGrid',
            margin: "0 0 20 0",
            maxWidth: 450,
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
                    header: '规格图片',
                    dataIndex: 'thumbUrl',
                    sortable: false,
                    hidden: true,
                    align: "center",
                    flex: 1
                },
                {
                    header: '规格值',
                    dataIndex: 'value',
                    sortable: false,
                    align: "center",
                    flex: 1,
                    field: {
                        xtype: 'textfield',
                        allowBlank: true
                    }
                } ,
                {
                    menuDisabled: true,
                    sortable: false,
                    align:"center",
                    header: '操作',
                    xtype: 'actioncolumn',
                    width: 150,
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
                            itemId: "addSkuItemButton"
                        }
                    ]
                }
            ]
        }
    ]
});