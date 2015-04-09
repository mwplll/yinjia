/**
 * Created by zyc on 2014/4/14.
 */


// 订单状态 HASH
var ORDER_STATE_HASH = {
    "0" : "未知",
    "1" : "等待买家付款",
    "2" : "买家已付款，等待卖家发货",
    "3" : "卖家已发货、等待买家确认收货",
    "4" : "买家已确认收货",
    "10" : "已关闭的订单",
    "11" : "完成的订单"
};
var ORDER_TYPE = {
    0: '',
    1: '定金订单',
    2: '余款订单'
};
define("OrderModel",
    function () {
        var order = function (item) {
            this.order_id = item.order_id;
            this.order_sn = item.order_sn;
            this.order_status = ORDER_STATE_HASH[item.order_status];
            this.order_amount = item.order_amout;
            this.create_time = Number(item.create_time) || Number(new Date());
            this.paid_time = Number(item.paid_time);
            this.payAble = (Number(item.order_status) == 1);
            this.expressAble = (Number(item.order_status) == 3);
            this.acceptAble = (Number(item.order_status) == 3);
            this.order_type = ORDER_TYPE[item.order_type];
            if(item.design_schema){
                this.design = {
                    design_id:item.design_schema.design_schema_id,
                    design_name: item.design_schema.design_name,
                    design_deposit: item.design_schema.design_deposit,
                    design_price: item.design_schema.design_price,
                    estimate_price: item.design_schema.estimate_price,
                    main_pic: item.design_schema.main_pic,
                    thumbUrl: image_base + item.design_schema.main_pic + THUMB_SIZE['schema']
                };
            }
            if(item.house_type){
                this.house = {
                    house_id: item.house_type.house_type_id,
                    house_typename: item.house_type.house_typename,
                    usable_area: item.house_type.usable_area,
                    gross_area: item.house_type.gross_area,
                    position: item.house_type.prov_name + " " + item.house_type.city_name,
                    building_name: item.house_type.building_name,
                    thumbUrl: image_base + item.house_type.pic + THUMB_SIZE['schema']
                };
            }
            if(!item.cp_design_schema){
                item.cp_design_schema = avalon.mix(true,{}, item.design_schema);
            }
            if(item.cp_design_schema){
                this.cp_design = {
                    design_id:item.cp_design_schema.design_name_id,
                    design_name: item.cp_design_schema.design_name,
                    design_deposit: item.cp_design_schema.design_deposit,
                    design_price: item.cp_design_schema.design_price,
                    estimate_price: item.cp_design_schema.estimate_price,
                    main_pic: item.cp_design_schema.main_pic,
                    thumbUrl: image_base + item.cp_design_schema.main_pic + THUMB_SIZE['schema']
                };
            }
            this.rooms = [];
            if(item.cp_design_rooms){
                this.rooms = avalon.mix(true,[], item.cp_design_rooms);
            }
            if(item.user){
                this.user = {
                    user_name: item.user.user_name
                }
            }
            if(item.addr){
                this.address = {
                    accept_name: item.addr.accept_name,
                    address: item.addr.address,
                    telphone: item.addr.telphone,
                    mobile: item.addr.mobile,
                    city: item.addr.city,
                    province: item.addr.province,
                    area: item.addr.area
                };
            }
            this.raw = item;   // order 原始值
        };
        order.prototype = {
            init: function () {

                return this;
            }
        };

    return order;
});