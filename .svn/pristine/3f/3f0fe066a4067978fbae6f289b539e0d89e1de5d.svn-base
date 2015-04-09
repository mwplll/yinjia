# 个人中心相关 API




##1 我的户型图
###1.1 获取我的户型图
[GET] http://121.40.212.161:8000/data/my/housetype



###1.2 设置为我的户型
[GET] http://121.40.212.161:8000/data/add/myhouse

参数           | 说明
-------------  | -------------
house_type_id  | 户型id


---
##2 我的设计方案

###2.1 查询我的方案列表
[GET/POST] http://121.40.212.161:8000/data/my/design/collection

> 示例: http://121.40.212.161:8000/data/my/design/collection

###2.2 申请修改方案

    TODO

###2.3 加入我的新家计划
[GET/POST] http://121.40.212.161:8000/data/design/collect


参数            | 说明
-------------  | -------------
design_id      | 设计方案 id

> 示例: http://121.40.212.161:8000/data/design/collect?design_id=1

---
##3 我的订单

### 3.1 提交设计订单
[GET/POST] http://121.40.212.161:8000/data/design/buy
> 示例: http://121.40.212.161:8000/data/design/buy?design_id=3&addr_id=3&type=1

参数            | 说明
-------------  | -------------
design_id      | 设计方案 id
addr_id        | 地址id
type           | 订单类型，1为定金订单，2为余款订单


>返回参数

参数        |  说明
----------  | ------------
sn          | 订单号

### 3.2 设计订单列表
[GET/POST] http://121.40.212.161:8000/data/my/design/order

> 示例: http://121.40.212.161:8000/data/my/design/order

### 3.3 设计订单详情
[GET]http://121.40.212.161:8000/data/design/order/info

>示例：http://121.40.212.161:8000/data/design/order/info?sn=2015010752971015

参数           | 说明
-------------  | -------------
sn             | 订单号 

### 3.4 确认收货 
[GET]http://121.40.212.161:8000/data/design/order/status?act=confirm

>说明：订单状态约定，order_status，0为未知，1为等待买家付款，2为买家已付款、等待卖家发货，3为卖家已发货、等待买家确认收货，4为买家已确认收货，10为已关闭的订单，11为完成的订单

参数           | 说明
-------------  | -------------
sn             | 订单号 

### 3.5 取消订单 
[GET]http://121.40.212.161:8000/data/design/order/status?act=cancel

参数           | 说明
-------------  | -------------
sn             | 订单号 

##4 收货地址

###4.1 获取我的收货地址列表
[GET]http://121.40.212.161:8000/data/user/addr

###4.2 新增/更新我的收货地址
[POST]http://121.40.212.161:8000/data/addr/edit?act=add

> 新增示例：http://121.40.212.161:8000/data/addr/edit?act=add&area_id=310106&name=%E7%AC%A8%E7%AC%A82&tel=13712345678&zip=310027&addr=%E5%8D%83%E5%B2%9B%E6%B9%96
> 更新示例：http://121.40.212.161:8000/data/addr/edit?act=add&addr_id=1&area_id=310106&name=%E7%AC%A8%E7%AC%A8&tel=13712345678&zip=310027&addr=%E5%8D%83%E5%B2%9B%E6%B9%96

参数           | 说明
-------------  | -------------
area           | 区名称
city           | 市名称
prov           | 省名称
addr_id        | 地址id，新增时为NULL，更新时为addr_id
name		   | 收件人姓名
zip            | 邮政编码
tel            | 联系电话
addr           | 详细地址
mobile         | 座机号码
default        | 是否为默认地址，1为默认，0为否

###4.3 修改我的收货地址
[GET]http://121.40.212.161:8000/data/addr/edit?act=edit

>示例:http://121.40.212.161:8000/data/addr/edit?act=edit&addr_id=2

参数           | 说明
-------------  | -------------
addr_id        | 地址id


###4.4 删除收货地址
[GET]http://121.40.212.161:8000/data/addr/edit?act=del

>示例：http://121.40.212.161:8000/data/addr/edit?act=del&addr_id=3

参数           | 说明
-------------  | -------------
addr_id        | 地址id

###4.5 设为默认收货地址
[GET]http://121.40.212.161:8000/data/addr/edit?act=default

>示例：http://121.40.212.161:8000/data/addr/edit?act=default&addr_id=2

参数           | 说明
-------------  | -------------
addr_id        | 地址id

##5 用户基本信息
###5.1 更新基本信息
[POST]http://121.40.212.161:8000/data/user/update

参数           | 说明
-------------  | -------------
avator_pic     | 头像URL地址
sex            | 性别 0代表男，1代表女，2为保密
content        | 个性签名
birthday       | 生日 0000-00-00格式

##6 实名认证
###6.1 身份证上传
    type=cid_pic  跟图片上传的那个接口一致
	
###6.2 确认提交
[POST]http://121.40.212.161:8000/data/verify/submit

参数           | 说明
-------------  | -------------
designer_id    | 设计师id，第一次确认提交为空，修改后重新提交有designer_id
name           | 真实姓名
cid            | 身份证号码
front_pic      | 身份证正面（个人信息面）图片地址
back_pic       | 身份证反面（国徽面）图片地址

###6.3 审核结果
[GET]http://121.40.212.161:8000/data/verify/result

####说明 is_checked字段，2为审核中，0为审核失败，1为审核通过
####fail_reason     失败原因



