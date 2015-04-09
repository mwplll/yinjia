# 后台管理系统-订单管理 API

##1 订单列表
[GET]http://121.40.212.161:8000/data/order/list

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"orderList":[{
				"id":String,   //订单id
				"user":String,  //用户名
				"sn":String,  //订单sn码
				"amount":String, //订单金额
				"type":String  //订单类型，0为未知，1为定金，2为余款，3为材料订单，4为项目订单
				"status":String  //订单状态，0为未知，1为等待买家付款，2为买家已付款、等待卖家发货，3为卖家已发货、等待买家确认收货，4为买家已确认收货，10为已关闭的订单，11为完成的订单
				"createTime":String  //订单创建时间
				}],
			"pagination":{
				"count":Number,  //总个数
				"page":Number    //页数
				}
			}
	} 


