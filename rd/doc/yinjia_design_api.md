#设计方案相关API

##1 查询类
###1.1 设计方案列表  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/schema/list

    >传入参数

    	{   "cityId":INT,//城市id
            "areaId":INT,//区域id
            "buildingId":INT,//楼盘id
            "houseId":INT,//户型id
            "states":ARRAY,//状态，0上架，1删除，2审核中，3下架，4审核失败
            "recommend":ARRAY,//是否在首页推荐，0为否，1为是 ``` 注意，这里修改为ARRAY型 ```
            "num":INT,//每页显示个数
            "page":INT,//所在页数，第一页为1
            "keywords":STRING,//搜索关键字，按设计方案名称、楼盘名对设计方案进行搜索
			"sort":STRING,//排序关键字，可选time，price
			"turn":INT,//排序方向，0为正序（由低到高，时间由远到近），1为倒序
    	}

    >返回参数

    	{   "errCode":INT,  //成功返回22000，失败返回22001
        	"data": [
        		"schemaList":[{
                    	"id":String,   //设计方案id
                    	"name":String,   //设计方案名称
                    	"designSn":String,   //编号
                    	"userId":String,   //设计师id
                    	"userName":String,   //设计师昵称
                    	"realName":String,   //设计师真实名字
                    	"qq":String,   //设计师qq
                    	"designerSn":String,   //设计师编号
                    	"avatar":String,   //设计师头像
                    	"totalPrice":String,   //装修总价
                    	"price":String,   //设计费
                    	"deposit":String,   //定金
                    	"mainPic":String,   //设计方案主图
                    	"modifyTime":String,   //更新时间
                    	"viewNum":String,   //浏览量
                    	"commentNum":String,   //评论数
                    	"likeNum":String,   //喜欢数
                    	"state":String,   //状态，0上架，1删除，2审核中，3下架，4审核失败
						"recommend":String,   //状态，是否在首页推荐，0为否，1为是
                    	"houseType":{
                    		"id":String, //户型id
                    		"name":String,//户型名称
                    		"grossArea":String,//建筑面积
                    		"building":String,//楼盘
                    		"area":String,//区域
                    		"city":String,//城市
                    		"prov":String //省
                    	}
                    	},
                    	……
                ],
                "pagination":{
                     "count":INT,  //总个数
                     "page":INT    //页数
                }

        	]
        }
		
###1.2 设计方案基本信息  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/base/info 

>传入参数

	{   "id":INT,//设计方案id
	}

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
			"data":{
				"id":String,//设计方案id
				"name":String,//设计方案名称
				"designSn":String,//设计方案编码
				"houseTypeId":String,//户型图id
				"totalPrice":String,   //装修总价
				"manualPrice":String,   //施工费
				"materialPrice":String,   //材料费			
				"price":String,//设计费
				"deposit":String,//设计费定金
				"content":String,//设计简要说明
				"mainPic":String, //设计方案主图地址
				"cadFile":String, //设计方案施工图工程文件地址
				"designer":{
				    "id":STRING,//设计师id
				    "realName":STRING,//设计师真实名字
				    "userName":STRING,//设计师昵称
				    "avatar":STRING,//头像
				    "tel":STRING,//电话
				    "qq":STRING,//qq号
				    "designerSn":STRING//设计师编号
				}
				"houseType":{
                     "id":String, //户型id
                     "name":String,//户型名称
                     "grossArea":String,//建筑面积
                     "building":String,//楼盘
                     "area":String,//区域
                     "city":String,//城市
                     "prov":String //省
                }
				}
		} 
		
###1.3 设计方案效果图信息  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/pic/info 

>传入参数

	{   "id":INT,//设计方案id
	}

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"picList":[{
				"picId":String,   //效果图id
				"name":String,  //效果图对应的房间名称
				"pic":String  //效果图地址
			}
			……
			],
			"id":String,//设计方案id
			"mainPic":String //设计方案主图
		}
	}

###1.4 设计方案施工图信息  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/cad/info 

>传入参数

	{   "id":INT,//设计方案id
	}


>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"picList":[{
				"picId":String,   //施工图id
				"name":String,  //施工图名称
				"pic":String  //施工图地址
			}
			……
			],
			"id":String,//设计方案id
			"file":String //设计方案施工图DWG文件
		}
	}

###1.5 设计方案材料清单信息  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/material/info 

>传入参数

	{   "id":INT,//设计方案id
	}

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
			"data":{
				"roomId"://设计方案房间id
				"roomName"://房间名称
				"roomArea"://房间面积
				"roomType"://房间类型
				"materialList":[{
					"materialId"://材料id
					"materialNo"://材料编号
					"materialName"://材料类目名称，前端写死的那个
					"goodsId"://商品id
					"goodsName"://商品名称
					"unit"://单位
					"productsId"://货品id
					"sellPrice"://销售价格
					"num"://货品数量
					"content"://设计师备注
				}]，
			}]，
	}

###1.6 设计方案人工+辅料信息  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/manual/info 

>传入参数

	{   "id":INT,//设计方案id
	}

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":[{
				"id"://项目id
				"name"://项目名称
				"price"://项目价格
				"styleId"://设计方案装修风格id
				"styleName"://设计方案装修风格名称
				}
				……
		]
	}

###1.6 所有人工+辅料信息列表（前台用） ``` √ ```
[GET] http://121.40.212.161:8000/data/design/manual/list

>传入参数

	{   "id":INT,//设计方案id
	}

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":[{
				"id"://项目id
				"name"://项目名称
				"price"://项目价格
				"styleId"://设计方案装修风格id
				"styleName"://设计方案装修风格名称
				}
				……
		]
	}

###1.7 所有人工+辅料信息列表（后台管理系统用） ``` √ ```
[GET] http://121.40.212.161:8000/data/admin/design/manual/list

>传入参数

	{   无
	}

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":[{
				"id"://项目id
				"name"://项目名称
				"price"://项目价格
				"styleId"://设计方案装修风格id
				"styleName"://设计方案装修风格名称
				}
				……
		]
	}


###1.8 设计方案材料清单信息for user  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/material/info2user

>传入参数

	{   "id":INT,//设计方案id
	}

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":[{
				"materialId"://材料id
				"materialNo"://材料编号
				"materialName"://材料类目名称，前端写死的那个
				"goodsId"://商品id
				"goodsName"://商品名称
				"unit"://单位
				"productsId"://货品id
				"sellPrice"://售价
				"period"://所处装修阶段
				"num"://货品数量
				"content"://设计师备注
				}
				……
				]
	}

##2 编辑
###2.1 设计方案基本信息新增/编辑  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/base/edit?act=save

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id            |  NULL |     >0，整数      | 设计方案id,第一次新增不传，再编辑必须传
name            |  NOT NULL |     不多于20字       | 设计方案名称
houseTypeId            |  NOT NULL |    >0，整数        | 户型图id
content            |   NULL |    不多于120字       | 设计简要说明

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,   //成功为TRUE，失败为FLASE 
	} 

###2.2 设计方案效果图新增/编辑  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/pic/edit?act=save

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id            |  NOT NULL |     >0，整数      | 设计方案id
mainPic            |  NOT NULL |        | 效果图主图
picId[]            |  NOT NULL |           | 效果图id
name[]            |  NOT NULL |           | 房间名称
pic[]            |  NOT NULL |           | 房间效果图地址


>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,   //成功为TRUE，失败为FLASE 
	} 

###2.3 设计方案施工图新增/编辑  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/cad/edit?act=save

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id            |  NOT NULL |     >0，整数      | 设计方案id
picId[]            |  NOT NULL |           | 施工图id
name[]            |  NOT NULL |           | 施工图名称
pic[]            |  NOT NULL |           | 施工图地址
file            |  NULL |           | 施工图工程文件

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,   //成功为TRUE，失败为FLASE 
	} 

###2.4 设计方案材料清单新增/编辑  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/material/edit?act=save

>传入参数

	{	"id"://设计方案id
		"roomList":[{
			"roomId"://设计方案房间id，新增的不传，编辑的必须传
			"roomName"://房间名称
			"roomArea"://房间面积
			"roomType"://房间类型
			"materialList":[{
				"materialId"://材料id，新增时不传，编辑时传入
				"materialNo"://材料编号
				"materialName"://材料类目名称，前端写死的那个
				"goodsId"://商品id
				"productsId"://货品id
				"num"://货品数量
				"content"://设计师备注
			}]
		}]
	} 
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,   //成功为TRUE，失败为FLASE 
	} 
	
###2.5 施工方案选择  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/manual/edit?act=select

>传入参数

	{   "id":INT,  //设计方案Id
		"styleId": INT,   //风格（施工报价方案）id
	} 
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,   //成功为TRUE，失败为FLASE 
	} 
	
###2.6 新增施工报价方案  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/manual/edit?act=add

>传入参数

	{   "name":STRING,  //施工报价方案名称
		"manualList": [{
			"manualName":STRING,//项目名称
			"price":STRING,//价格
		}
		……
		]
	} 
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": INT,   //新增的style的id，失败返回空
	} 
	
###2.7 修改施工报价方案  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/manual/edit?act=update

>传入参数

	{   "id":INT,//施工报价方案id
		"name":STRING,  //施工报价方案名称
		"manualList": [{
			"manualId":INT,  //项目id
			"manualName":STRING,//项目名称
			"price":STRING,//价格
		}
		……
		]
	} 
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,   //成功为TRUE，失败为FLASE 
	}
	
###2.8 删除施工报价方案  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/manual/edit?act=del

>传入参数

	{   "id":INT,//施工报价方案id
	} 
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,   //成功为TRUE，失败为FLASE 
	}
	
###2.9 删除施工报价方案的项目  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/manual/edit?act=delManual

>传入参数

	{   "id":INT,//施工报价方案的收费项目id
	} 
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,   //成功为TRUE，失败为FLASE 
	}
	
###2.10 添加设计方案浏览量  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/base/edit?act=view

>传入参数

	{   "id":INT,//设计方案id
	} 
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,   //成功为TRUE，失败为FLASE 
	}
	
###2.11 添加设计方案点赞数  ``` √ ```
[POST] http://121.40.212.161:8000/data/design/base/edit?act=like

>传入参数

	{   "id":INT,//设计方案id
	} 
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,   //成功为TRUE，失败为FLASE 
	}

##3 设计师管理设计方案
###3.1 设计师的设计方案列表  ``` √ ```
[GET] http://121.40.212.161:8000/data/designer/schema/list

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
num            |   NULL |      >0,整数       | 每页的个数,默认为15
page          |    NULL    |    >0,整数         | 当前的分页，第一页为1，默认为1
keywords            |  NULL |           | 设计方案名称搜索关键字
state            |  NULL |      [0,2,3]     | 0为已发布的设计方案，2为审核中的设计方案，3为仓库中的设计方案，默认为全部设计方案
sort            |  NULL |    [time,price]       | 排序关键字,time:更新时间，price:设计费
turn            |  NULL |     [0,1]      |  0为正序（由低到高，时间由远到近），1为倒序

>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"schemaList":[{
				"id":String,   //设计方案id
				"name":String,   //设计方案名称
				"designSn":String,   //编号
				"totalPrice":String,   //装修总价
				"price":String,   //设计费
				"deposit":String,   //定金
				"mainPic":String,   //设计方案主图
				"modifyTime":String,   //更新时间
				"viewNum":String,   //浏览量
				"state":String,   //状态，0上架，1删除，2审核中，3下架，4审核失败
				"houseType":{
					"id":String, //户型id
					"name":String,//户型名称
					"building":String,//楼盘
					"area":String,//区域
					"city":String,//城市
					"prov":String,//省
					}
				}],
			"pagination":{
				"count":Number,  //总个数
				"page":Number    //页数
				}
			}
	} 

###3.2 设计师对设计方案操作  ``` √ ```
[POST] http://121.40.212.161:8000/data/designer/schema/edit

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id             |  NOT  NULL |      >0,整数       | 设计方案id
act             |  NOT  NULL |            | 操作，可选值（del:删除,up：发布,down：下架）

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 

##4 后台管理系统管理设计方案
###4.1 推荐设计方案  ``` √ ```
[GET] http://121.40.212.161:8000/data/admin/design/schema/edit?act=recommend

>传入参数

	{   "id":INT,//设计方案id
	    "recommend":INT,//是否推荐，0为否，1为是
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": BOOLEAN //成功为TRUE，失败为FALSE
	}

###4.2 审核设计方案  ``` √ ```
[POST] http://121.40.212.161:8000/data/admin/design/schema/edit?act=check

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id             |  NOT  NULL |      >0,整数       | 设计方案id
isCheck             |  NOT  NULL |            | 操作，可选值（1：审核通过，0：审核失败）
reason             | NULL |            | 审核失败原因

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 

###4.2 删除设计方案  ``` √ ```
[POST] http://121.40.212.161:8000/data/admin/design/schema/edit?act=del

参数          |  是否允许为空   |     约束    |说明
------------- |---------------- | ----------- |-------------
id             |  NOT  NULL |      >0,整数       | 设计方案id

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	}

##5 设计方案评论
###5.1 评论列表  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/comment/list

>传入参数

	{   "designSchemaId":INT,//设计方案id
        "num":INT,//每页显示个数
        "page":INT,//所在页数，第一页为1
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": [
			"commentList":[{
            	"id":INT,   //评论id
            	"designSchemaId":INT,   //设计方案id
            	"designName":STRING,   //设计方案名称
            	"houseTypeId":INT,   //户型id
            	"userId":INT,   //用户id
            	"userName":STRING,   //用户昵称
            	"avatar":STRING,   //用户头像
            	"content":STRING,   //评论内容
            	"point":INT,   //评分
            	"time":STRING   //评论时间
            }
            ……
            ],
            "pagination":{
            	"count":INT,  //总个数
            	"page":INT    //页数
            }
		]
	}

###5.2 发表评论  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/comment/edit?act=save

>传入参数

	{   "designSchemaId":INT,   //设计方案id
        "content":STRING,   //评论内容
        "point":INT   //评分

	}

>返回参数

    {   "errCode":22000,  //成功返回22000，失败返回22001
    	"data": INT,//成功返回新增评论的id，失败为FLASE
    }

###5.3 删除评论  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/comment/edit?act=del

>传入参数

	{   "id":INT,   //评论id
	}

>返回参数

    {   "errCode":22000,  //成功返回22000，失败返回22001
    	"data": BOOLEAN,//成功为TRUE，失败为FALSE
    }

	














