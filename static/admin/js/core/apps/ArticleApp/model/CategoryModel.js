Ext.define('PMS.apps.ArticleApp.model.CategoryModel',{
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