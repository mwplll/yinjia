# 后台管理系统-建材管理 API


##1 建材列表查询

###1.1 按条件查询，返回建材列表
[GET] http://121.40.212.161:8000/data/goods/list

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
num            |   NULL |      >0,整数       | 每页的个数,默认为15
page          |    NULL    |    >0,整数         | 当前的分页，第一页为1，默认为1
catId          |    NULL    |    >0,整数         | 分类id，可以是顶层分类，也可以是子分类，默认为NULL
state          |    NULL    |    [0,1,2,3]         | 0为上架，1为删除，2为下架，3为待审，默认为NULL
maxNum          |    NULL    |    >0,整数,>=minNum         | 库存最大值，库存量<=最大值，默认为10000
minNum          |    NULL    |    >0,整数,<=maxNum         | 库存最小值，困存量>=最小值,默认为0，库存状态分为“无货”，“低于10”,“10-100”,“100以上”
period          |    NULL    |    [0,1,2,3]         | 所属装修阶段，0为水电阶段，1为泥木阶段，2为漆作接单，3为成品安装阶段，默认为所有阶段
keywords          |    NULL    |   字符串           | 商品名称搜索关键字，默认为NULL
brand          |    NULL    |   字符串           | 品牌搜索关键字，默认为NULL
sortWords          |    NULL    |   [0,1,2,3]           | 0代表价格，1代表喜欢数，2代表评论数，3代表上架时间。默认为NULL（后台管理系统不需要此字段）
turn          |    NULL    |   [0,1]           | 排序顺序，0为由低到高，由时间久的到时间近的；1与之相反。默认为0

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"goodsList":[{
				"id":String,   //建材id
				"name":String,  //建材名称
				"cat":String,  //所属分类名称
				"price":String, //销售价格
				"storeNum":String  //库存量
				"state":String  //状态，0为上架，1为删除，2为下架，3为待审
				"sort":String  //排序
				"period":String  //所属装修阶段，0为水电阶段，1为泥木阶段，2为漆作接单，3为成品安装阶段，默认为所有阶段
				"pic":String  //商品主图
				}],
			"pagination":{
				"count":Number,  //总个数
				"page":Number    //页数
				}
			}
	}    

###1.2 单个建材详情
[GET] http://121.40.212.161:8000/data/goods/info

参数           | 说明
-------------  | -------------
id         | 建材id

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": {  
			    "id":String,   //建材id
				"name":String,  //建材名称
				"goodsSn":String,//建材型号
				"content":String, //建材详情
				"sellPrice":String,//销售价格
				"marketPrice":String,//市场价格
				"costPrice":String,//成本价格
				"storeNum":String,//库存量
				"weight":String,//重量,单位为克
				"catId":String,  //所属分类Id
				"brandId":String,  //品牌Id
				"brandName":String,  //品牌名称
				"seriesId":String,  //系列id
				"state":String,  //状态，0为上架，1为删除，2为下架，3为待审
				"sort":String,  //排序 
				"unit":String,  //计量单位 
				"period":String  //所属装修阶段，0为水电阶段，1为泥木阶段，2为漆作接单，3为成品安装阶段，默认为所有阶段
				"pic":String  //商品主图
				"providerId":String  //供应商id
				"content":String  //建材详情
				"productList": [{   //具体某一商品信息
					"productId":String,//货品id
					"productSn":String,//货品货号
					"sellPrice":String,//销售价格
					"marketPrice":String,//市场价格
					"costPrice":String,//成本价格
					"storeNum":String,//库存量
					"weight":String,//重量,单位为克
					"specArray":String//json规格数据	
				}]，
				"attrList":[{
					"attrName":String,//属性名称
					"attrValue"：String,//属性值
				}]，
				"picList":[{
					"pic":String,//商品图片列表
				}]
				
		}  
	} 

###1.3 新增/编辑建材
[POST] http://121.40.212.161:8000/data/goods/edit?act=save

参数           | 说明
------------- | -------------
goodsId       | 建材id,新增时无，更新有
brandId       | 品牌id
seriesId       | 系列id
seriesId      | 系列id
catId       | 分类id
providerId       | 供应商id
name          | 建材名称
goodsSn          | 建材型号
content          | 建材详情
goodsSellPrice          | 建材销售价格，0.00
goodsMarketPrice          | 建材市场价格，0.00
goodCostPrice          | 建材成本价格，0.00
goodsWeight          | 建材重量，单位克
goodsStoreNum         | 建材库存量
unit          | 建材计价单位
mainPic          | 建材主图
state          | 状态，0为上架，1为删除，2为下架，3为待审
period          | 所属装修阶段，0为水电阶段，1为泥水阶段，2为木工阶段，3为漆作接单，4为成品安装阶段，5软装阶段，10为其他，默认为其他
sort          | 排序，不能为负数，默认为99
productsId[]          | 货品id数组，新增时无，更新有
productsSn[]          | 货品编号，新增时无，更新有
sellPrice[]          | 建材销售价格，0.00
marketPrice[]          | 建材市场价格，0.00
costPrice[]          | 建材成本价格，0.00
weight[]          | 建材重量，单位克
storeNum[]         | 建材库存量
specArray[]     |建材规格 
pic[]         | 商品图片

###1.4 新增/编辑建材详情
[POST] http://121.40.212.161:8000/data/goods/edit?act=saveContent

参数           | 说明
------------- | -------------
id       | 建材id,新增时无，更新有
content        | 建材详情


###1.5 删除/前台显示/前台不显示
[GET] http://121.40.212.161:8000/data/goods/edit?act=state

参数           | 说明
------------- | -------------
ids        | 要删除的规格id组,格式为ids=[id1,id2,id3]
state     | 状态，0为上架，1为删除，2为下架，3为待审

###1.6 建材排序
[GET] http://121.40.212.161:8000/data/goods/edit?act=sort

参数           | 说明
------------- | -------------
id        | 建材id
sort     | 排序顺序，默认为99



##2 建材分类管理

###2.1 查询建材分类列表(树形结构)
[GET]http://121.40.212.161:8000/data/category/list

输入参数           | 说明
-------------  | -------------

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": [{  
			"id": String, // 商品分类id  
			"name": String, // 商品分类名称 
			"father_id": String, // 该分类的父分类id   
			"layer": String, // 分类编号，限定为5层，初始值为00000000,每两位一组，每层最多99个子类别  
			"del": String, // 0代表正常显示，1代表删除，2代表前台不显示  
		}]  
	} 

###2.2 新增/编辑建材分类
[POST] http://121.40.212.161:8000/data/category/edit?act=save

参数           | 说明
------------- | -------------
id            | 类别id,新增时为NULL,编辑后保存时传入
name          | 类别名称
father        | 父类别id (根节点为0)，新增时保存需要传入，编辑后保存不需要
del           | 0代表正常显示，1代表删除，2代表前台不显示

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 

###2.3 删除分类
[GET] http://121.40.212.161:8000/data/category/edit?act=del

参数           | 说明
------------- | -------------
id       | 类别id，约定当该分类还有子分类时不能删除

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 
	
##3 商品规格管理
###4.1 规格列表
[GET] http://121.40.212.161:8000/data/spec/list

参数          | 说明
------------- | -------------
num           | 每页的个数
page          | 当前的分页，第一页为1

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"specList":[{
				"id":String,   //规格id
				"name":String,  //规格名称
				"value":array,  //规格值,数组，如果是图片类型，为图片url数组
				"type":String, //规格类型，0为文字，1为图片
				"del":String  //是否删除，0为正常，1为删除
				}],
			"pagination":{
				"count":Number,  //总个数
				"page":Number    //页数
				}
			}
	}

###4.2 单个规格详情
[GET] http://121.40.212.161:8000/data/spec/info

参数          | 说明
------------- | -------------
id            | 规格id

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001，参数错误返回22005
		"data":{
				"id":String,   //规格id
				"name":String,  //规格名称
				"value":array,  //规格值,数组，如果是图片类型，为图片url数组
				"type":String, //规格类型，0为文字，1为图片
				"del":String  //是否删除，0为正常，1为删除
				"picList":[{  //规格图片数组。如果是图片类型，有该字段；文字类型，该字段不存在				
					"picId":String, //规格图片id
					"pic":String, //规格图片
					"picName":String //图片名称
				}
				]
			}
	}

###4.3 新增/编辑规格
[GET/POST]http://121.40.212.161:8000/data/spec/edit?act=save

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id            |   NULL/NOT NULL |             | 规格id，新增时不传，编辑时需要传入id
name          |     NOT NULL    |             | 规格名称
value          |      NULL    |             | 规格值数组,value="value1","value2",为图片时为图片的地址数组
type          |     NOT NULL    |             | 规格类型，0为文字，1为图片，默认为0
picId[]          |     NOT NULL    |             | 图片id
pic[]          |     NOT NULL    |             | 如果是图片类型，需传该字段，图片url数组
picName[]          |     NOT NULL    |             | 如果是图片类型，需传该字段，图片名称

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001，参数错误返回22005
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 
	
###4.4 删除/批量删除规格
[GET] http://121.40.212.161:8000/data/spec/edit?act=delete

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
ids            |     NOT NULL    |             | 要删除的规格id组,格式为ids=[id1,id2,id3]

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001，参数错误返回22005
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 

###4.5 规格图片列表
[GET] http://121.40.212.161:8000/data/spec/pic/list

参数          | 说明
------------- | -------------
num           | 每页的个数
page          | 当前的分页，第一页为1

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"picList":[{
				"id":String,   //规格图片id
				"name":String,  //规格图片名称
				"pic":array,  //规格图片地址
				"time":String, //创建时间
				}],
			"pagination":{
				"count":Number,  //总个数
				"page":Number    //页数
				}
			}
	}
	
###4.6 删除/批量删除规格图片
[GET] http://121.40.212.161:8000/data/spec/pic/edit?act=delete

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
ids            |     NOT NULL    |             | 要删除的规格图片id组，格式为ids=[id1,id2,id3]

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001，参数错误返回22005
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 	
	

##4 品牌管理
###4.1 品牌列表
[GET] http://121.40.212.161:8000/data/brand/list

参数          | 说明
------------- | -------------
num           | 每页的个数
page          | 当前的分页，第一页为1

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"brandlist":[{
				"id":String,   //品牌id
				"name":String,  //品牌名称
				"enName":String,  //品牌英文名称
				"logo":String,  //品牌logo地址
				"contents":String, //品牌描述
				"url":String,  //品牌官网地址
				"sort":String,  //品牌排序
				"del":String  //是否删除，0为正常，1为删除
				"seriesList":[{  //系列数组				
					"seriesId":String, //系列id
					"seriesName":String //系列名称
				}
				}],
			"pagination":{
				"count":Number,  //总个数
				"page":Number    //页数
				}
			}
	}

###4.2 单个品牌详情
[GET] http://121.40.212.161:8000/data/brand/info

参数          | 说明
------------- | -------------
id           | 品牌id

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001，参数错误返回22005
		"data":{
				"id":String,   //品牌id
				"name":String,  //品牌名称
				"enName":String,  //品牌英文名称
				"logo":String,  //品牌logo地址
				"contents":String, //品牌描述
				"url":String,  //品牌官网地址
				"sort":String,  //品牌排序
				"del":String  //是否删除，0为正常，1为删除
				"seriesList":[{  //系列数组				
					"seriesId":String, //系列id
					"seriesName":String //系列名称
				}
			}
	}


###4.4 新增/编辑品牌
[GET/POST]http://121.40.212.161:8000/data/brand/edit?act=save

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id            |   NULL/NOT NULL |             | 品牌id，新增时不传，编辑时需要传入id
name          |     NOT NULL    |             | 品牌名称
enName          |     NOT NULL    |             | 品牌英文名称
logo          |     NULL        |             | 品牌logo图片地址，相对地址
content       |     NULL        |             | 品牌描述
url           |     NULL        |             | 品牌官网地址
sort          |     NULL        | >=0,整数    | 品牌排序，自然数，不能出现负数或者小数
seriesName[]          |     NULL        |   | 系列数组
seriesId[]          |     NULL        |   | 系列id,新增时和编辑时都传入

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001，参数错误返回22005
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 

###4.4 品牌排序
[GET]http://121.40.212.161:8000/data/brand/edit?act=sort

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id            |     NOT NULL    |             | 品牌id
sort          |     NULL        | >=0,整数,不同品牌顺序可重复    | 品牌排序

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001，参数错误返回22005
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 

###4.5 删除品牌
[GET] http://121.40.212.161:8000/data/brand/edit?act=delete

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id            |     NOT NULL    |             | 品牌id

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001，参数错误返回22005
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 

##5 商品属性管理

##6 供应商管理
###6.1 供应商列表
[GET] http://121.40.212.161:8000/data/provider/list

参数          | 说明
------------- | -------------
num           | 每页的个数
page          | 当前的分页，第一页为1

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"providerList":[{
				"id":String,   //供应商id
				"name":String,  //供应商名称
				"del":String  //是否删除，0为正常，1为删除
				}],
			"pagination":{
				"count":Number,  //总个数
				"page":Number    //页数
				}
			}
	}
	
###6.2 单个供应商详情
[GET] http://121.40.212.161:8000/data/provider/info

参数          | 说明
------------- | -------------
id           | 供应商id

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001，参数错误返回22005
		"data":{
				"id":String,   //供应商id
				"name":String,  //供应商名称
				"del":String  //是否删除，0为正常，1为删除
			}
	}
		
###6.3 新增/编辑供应商
[GET/POST]http://121.40.212.161:8000/data/provider/edit?act=save

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id            |   NULL/NOT NULL |             | 供应商id，新增时不传，编辑时需要传入id
name          |     NOT NULL    |             | 供应商名称


>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001，参数错误返回22005
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 

###6.4 删除/批量删除供应商
[GET] http://121.40.212.161:8000/data/provider/edit?act=delete

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
ids            |     NOT NULL    |             | 供应商ids，格式为ids=[id1,id2,id3]

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001，参数错误返回22005
		"data": BOOLEN,//成功为TRUE，失败为FLASE 







