Ext.define('PMS.apps.GoodsApp.model.CategoryModel',{
    extend: 'Ext.data.Model',
    fields: [
        "text",
        "name",
        "parentId",
        "categoryId",
        "enable",
        "children",
        "childCategories"
    ]
});