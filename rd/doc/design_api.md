## 图片上传
[POST] http://121.40.212.161:8000/data/image/upload

参数      |说明     | 参数可选值  | 可选值说明
---------|---------|---------------------------
type     | 图片类型 | avator     | 用户头像
         |         | house_type | 户型图
         |         | design_room| 房间设计图
file     | 图片文件， input type=file name=file，即 name 为 file 的表单元素 || 



返回

    errorCode: 22000
    data:
        link: xxx



## 设计师中心
**************
### 选择已有设计方案 TODO
**************

#### 1. 获取城市列表

#### 2. 城市 id 获取楼盘列表

#### 3. 楼盘 id 获取户型列表

************
### 添加新的户型图
************
#### 1. 传入户型图相关信息, 添加户型图
[POST] http://121.40.212.161:8000/data/house/edit?act=add

参数           | 说明
------------- | -------------
name          | 户型名称
building_id   | 楼盘id
city_id       | 城市id
pic           | 户型图图片地址
usable_area   | 可使用面积
gross_area    | 建筑面积
room_name[]   | 房间名称
room_size[]   | 房间面积

http://121.40.212.161:8000/data/house/edit?act=add&name=%E9%98%B3%E5%85%89%E5%AE%B6%E5%9B%AD&build_id=1&room_name[]=%E5%8E%A8%E6%88%BF&room_area[]=12&room_name[]=%E5%AE%A2%E5%8E%85&room_area[]=11&room_name[]=%E5%8D%AB%E7%94%9F%E9%97%B4&room_area[]=8


************
### 发布设计方案
**********
#### 1. 户型 id 获取户型信息，房间信息
[GET] http://121.40.212.161:8000/data/house/info/6
>info 后为户型 id

#### 2. 上传房间户型图
参考图片上传，type 参数为 design_room

#### 3. 创建新的设计方案
[POST] http://121.40.212.161:8000/data/design/edit?act=add

参数          | 说明
--------------|--------
house_type_id | 户型 id
name          | 方案名称
price         | 设计费
deposit       | 订金
estimate_price | 装修预估价
room_id[]     | 户型下房间的 id
design_pic[]  | 设计图地址


需要登录 http://121.40.212.161:8000/data/design/edit?act=add&name=%E6%B5%8B%E8%AF%95%E6%96%B9%E6%A1%88&house_type_id=6&price=9000&deposit=2000&room_id[]=47&design_pic[]=xx.com&room_id[]=48&design_pic[]=xx.com&room_id[]=49&design_pic[]=xx.com
http://121.40.212.161:8000/data/design/edit?act=add&name=%E6%B5%8B%E8%AF%95%E6%96%B9%E6%A1%88&house_type_id=2&price=9000&deposit=2000&room_id[]=8&design_pic[]=xx.com&room_id[]=9&design_pic[]=xx.com&room_id[]=10&design_pic[]=xx.com&room_id[]=11&design_pic[]=xx.com&room_id[]=12&design_pic[]=xx.com&room_id[]=13&design_pic[]=xx.com&room_id[]=14&design_pic[]=xx.com&room_id[]=15&design_pic[]=xx.com&room_id[]=16&design_pic[]=xx.com

流程说明：

1. 验证是否提供了必须字段
2. 验证用户是否是设计师
3. 验证是否提供了全部房间的设计图
4. 添加设计方案记录
5. 添加设计房间记录
