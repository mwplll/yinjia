# 设计师中心相关 API

##1 订单查询
###1.1 所有订单
[GET] http://121.40.212.161:8000/data/designer/order/list?state=all  

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.2 待支付定金订单
[GET] http://121.40.212.161:8000/data/designer/order/list?state=pay_first

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.3 待提交效果图订单
[GET] http://121.40.212.161:8000/data/designer/order/list?state=pic_first

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.4 待支付余款订单
[GET] http://121.40.212.161:8000/data/designer/order/list?state=pay_second

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.5 待提交施工图订单
[GET] http://121.40.212.161:8000/data/designer/order/list?state=pic_second

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.6 已发货订单
[GET] http://121.40.212.161:8000/data/designer/order/list?state=send

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.7 完成的订单
[GET] http://121.40.212.161:8000/data/designer/order/list?state=complete

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.8 取消的订单
[GET] http://121.40.212.161:8000/data/designer/order/list?state=cancel

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.9 单个订单详情
[GET]http://121.40.212.161:8000/data/design/order/info

>示例：http://121.40.212.161:8000/data/design/order/info?sn=2015010752971015

参数           | 说明
-------------  | -------------
sn             | 订单号 

##2 订单操作
###2.1 取消订单（关闭订单）
[GET]http://121.40.212.161:8000/data/design/order/status?act=cancel

参数           | 说明
-------------  | -------------
sn             | 订单号 

##3 订单效果图上传
###3.1 户型 id 获取户型信息，房间信息
[GET] http://121.40.212.161:8000/data/house/info/6
>info 后为户型 id

###3.2 效果图第上传
[POST] http://121.40.212.161:8000/data/order/design/edit?act=update

参数          | 说明
--------------|--------
design_schema_id | 复制的设计方案 id
house_type_id | 户型 id
name          | 方案名称
price         | 设计费
deposit       | 订金
estimate_price | 装修预估价
room_id[]     | 户型下房间的 id
design_pic[]  | 设计图地址










