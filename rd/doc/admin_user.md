# 后台管理系统-用户管理 API


##1 查询

###1.1 普通用户列表
[GET] http://121.40.212.161:8000/data/admin/user/list

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 页数，第一页为1

###1.2 设计师用户列表
[GET] http://121.40.212.161:8000/data/admin/designer/list

参数           | 说明
-------------  | -------------
state          | 审核状态，2为审核中，0为审核失败，1为审核通过
num            | 每页的个数
page           | 页数，第一页为1

###1.3 单个普通用户信息
[GET] http://121.40.212.161:8000/data/admin/user/info

参数           | 说明
-------------  | -------------
user_id        | 用户id

###1.4 单个设计师用户信息
[GET] http://121.40.212.161:8000/data/admin/designer/info

参数           | 说明
-------------  | -------------
designer_id    | 设计师id

##2 修改信息

###2.1 修改普通用户信息
[POST]http://121.40.212.161:8000/data/admin/user/edit?act=update

参数           | 说明
-------------  | -------------
user_id        | 用户id
tel            | 手机号


###2.2 修改设计师用户信息
[POST]http://121.40.212.161:8000/data/admin/designer/edit?act=update
>示例：http://121.40.212.161:8000/data/admin/designer/edit?act=update&designer_id=2&name=%E7%AC%A8%E7%AC%A8&cid=123456789012345678&tel=13512345678

参数           | 说明
-------------  | -------------
designer_id    | 设计师id
tel            | 手机号
name           | 真实姓名
cid            | 身份证号码


###2.3 设计师审核0
[GET]http://121.40.212.161:8000/data/admin/designer/edit?act=check

参数           | 说明
-------------  | -------------
designer_id    | 设计师id
is_ok          | 0表示审核不通过，1表示审核通过
reason         | 审核失败原因


##3 删除用户

###3.1 删除普通用户
[GET]http://121.40.212.161:8000/data/admin/user/edit?act=del

参数           | 说明
-------------  | -------------
user_id        | 用户id

###3.2 删除设计师用户
[GET]http://121.40.212.161:8000/data/admin/designer/edit?act=del

参数           | 说明
-------------  | -------------
designer_id    | 设计师id

###3.1 判断是否是设计师
[GET]http://121.40.212.161:8000/data/check/designer

##4 管理员用户
###4.1 管理员用户登录
[GET]http://121.40.212.161:8000/data/administrator/login

参数           | 说明
-------------  | -------------
userName        | 管理员名称
password       | 管理员密码

###4.2 管理员用户登出
[GET]http://121.40.212.161:8000/data/user/logout

###4.3 判断管理员是否登录
[GET]http://121.40.212.161:8000/data/check/administrator






