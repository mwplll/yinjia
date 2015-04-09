#用户-设计方案相关API

##1 
###1.1 加入我的新家  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/collect

>传入参数

	{   "id":INT,//设计方案id
	}
	
>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":{
			"collectionId"://收藏设计方案id
		}
	}

###1.2 ”我的方案“列表  ``` √ ```
[GET] http://121.40.212.161:8000/data/my/design/collection
>传入参数

	{   无
	}
	
>返回参数

    	{   "errCode":INT,  //成功返回22000，失败返回22001
        	"data": {
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
                ]

        	}
        }


###1.3 在”我的方案列表“中删除设计方案  ``` √ ```
[GET] http://121.40.212.161:8000/data/design/collection/del

>传入参数

	{   "ids":ARRAY,//要删除的设计方案id数组
	}
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 


###1.4 查看明细报价清单  ``` √ ```
[GET] http://121.40.212.161:8000/data/my/design/material
>传入参数

	{   "id":INT,//设计方案id
	}
	
>返回参数

	{	"errorCode":22000,//成功返回22000，失败返回22001
		"data":[{
				"id"://材料-用户id
				"userId"://用户id
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
	


###1.5 保存明细报价清单  ``` √ ```
[GET] http://121.40.212.161:8000/data/my/design/material/edit?act=save
>传入参数

	{   "id":INT,//设计方案id
	    "materialList":[{
			"id":INT,//用户的设计方案材料子项id
			"goodsId":INT,//替换的商品id
			"productsId":INT，//替换的某一具体规格的商品id
			"num":INT，//商品数量
		}
		……
		]
	}
	
>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE 
	} 















