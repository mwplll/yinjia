# 后台管理系统-楼盘管理 API


##1 查询

###1.1 按条件查询，返回楼盘列表
[GET]http://121.40.212.161:8000/data/building/list

参数           | 说明
-------------  | -------------
city_id        | 城市6位编码
area_id        | 区域6位编码，当只查城市时，area_id=NULL
num            | 每页的个数
page           | 当前的分页，第一页为1

###1.2 单个楼盘信息
[GET]http://121.40.212.161:8000/data/building/info

参数           | 说明
-------------  | -------------
build_id      | 楼盘id


##2 新增/更新

###2.1 新增楼盘
[GET]http://121.40.212.161:8000/data/building/edit?act=add

参数           | 说明
-------------  | -------------
city_id        | 城市6位编码
area_id        | 区域6位编码
name           | 楼盘名
company        | 开发商名

###2.2 更新楼盘
[GET]http://121.40.212.161:8000/data/building/edit?act=update

参数           | 说明
-------------  | -------------
build_id       | 楼盘id
city_id        | 城市6位编码
area_id        | 区域6位编码
name           | 楼盘名
company_id     | 开发商id
company        | 开发商名


##3 删除

[POST] http://121.40.212.161:8000/data/building/edit?act=delete

参数           | 说明
------------- | -------------
build_id      | 楼盘id













