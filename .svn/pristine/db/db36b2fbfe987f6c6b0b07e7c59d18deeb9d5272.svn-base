# 后台管理系统-户型图管理 API


##1 查询

###1.1 按条件查询，返回户型图列表
[GET]http://121.40.212.161:8000/data/house/type

参数           | 说明
-------------  | -------------
num            | 每页的个数
page           | 当前的分页，第一页为1
city           | 城市编码id
area           | 区域编码id
keywords       | 楼盘名/搜索关键字
minarea        | 建筑面积最小值
maxarea        | 建筑面积最大值
enable         | all代表返回is_enable为1（前台显示）或者2（前台不显示）的户型;其他情况只返回is_enable为1的户型

###1.2 单个户型图详情
[GET]http://121.40.212.161:8000/data/house/info

参数           | 说明
-------------  | -------------
house_type_id  | 户型id


##2 新增

###2.1 根据城市和区域查询楼盘
[GET]http://121.40.212.161:8000/data/search/building

参数           | 说明
-------------  | -------------
city_id        | 城市id
area_id        | 区域id，当只查询城市时，area_id=NULL

###2.2 新增户型图
[POST] http://121.40.212.161:8000/data/house/edit?act=add

参数           | 说明
------------- | -------------
name          | 户型名称
building_id   | 楼盘id
pic           | 户型图图片地址
usable_area   | 可使用面积
gross_area    | 建筑面积

###2.3 更新户型图
[POST] http://121.40.212.161:8000/data/house/edit?act=update

参数           | 说明
------------- | -------------
name          | 户型名称
building_id   | 楼盘id
house_id      | 户型id
pic           | 户型图图片地址
usable_area   | 可使用面积
gross_area    | 建筑面积



##3 删除/前台显示/前台不显示

[POST] http://121.40.212.161:8000/data/house/edit?act=enable

参数           | 说明
------------- | -------------
house_id      | 户型id
enable_id     | 0代表删除，1代表显示，2代表不显示,默认值为1












