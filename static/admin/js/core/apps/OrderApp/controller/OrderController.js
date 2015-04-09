/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-3-27
 * Time: 下午9:11
 * To change this template use File | Settings | File Templates.
 */

Ext.define("PMS.apps.OrderApp.controller.OrderController",{
    extend: 'Ext.app.Controller',
    models: [
        'PMS.apps.OrderApp.model.OrderModel'
    ],
    stores: [
        'PMS.apps.OrderApp.store.OrderStore'
    ],
    views: [
        'PMS.apps.OrderApp.view.OrderGrid'
    ],
    refs: [
        {
            selector: 'orderGrid',
            ref: 'orderGrid'
        }
    ],


    init: function(){
        console.log("OrderController init");

        this.control({
            "orderGrid": {
                afterrender: function () {
                    var me = this,
                        grid = me.getOrderGrid();
                    grid.getStore().loadPage(1);
                }
            }
        });
    }
});