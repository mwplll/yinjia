#户型相关API

##1 查询类

###1.1 根据区域查询楼盘列表 ``` √ ```
[GET] http://121.40.212.161:8000/data/building/list

>传入参数

	{   "cityId":INT,//城市id
	    "areaId":INT,//区域id
	    "num":INT,//每页显示个数
	    "page":INT,//所在页数，第一页为1
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": [
			"buildingList":[{
            	"id":INT,   //楼盘id
            	"cityId":INT,   //城市id
            	"prov":STRING,   //省份名称
            	"city":STRING,   //城市名称
            	"areaId":INT,   //区域id
            	"area":INT,   //区域名称
            	"name":STRING,   //楼盘名称
            	"recommend":INT,   //是否在首页推荐，0为否，1为是
            	"designNum":INT,   //该楼盘设计方案总数
            	"companyId":INT,   //开发商id
            	"company":STRING,   //开发商公司名称
            }
            ……
            ],
            "pagination":{
            	"count":INT,  //总个数
            	"page":INT    //页数
            }
		]
	}

###1.2 单个楼盘详情 ``` √ ```
[GET] http://121.40.212.161:8000/data/building/info

>传入参数

	{   "id":INT //楼盘id
    }

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": {
            "id":INT,   //楼盘id
            "cityId":INT,   //城市id
            "prov":STRING,   //省份名称
            "city":STRING,   //城市名称
            "areaId":INT,   //区域id
            "area":INT,   //区域名称
            "name":STRING,   //楼盘名称
            "recommend":INT,   //是否在首页推荐，0为否，1为是
            "designNum":INT,   //该楼盘设计方案总数
            "companyId":INT,   //开发商id
            "company":STRING,   //开发商公司名称
        }

	}

###1.3 首页主推楼盘 ``` √ ```
[GET] http://121.40.212.161:8000/data/building/recommend

    >传入参数

    	{   无
    	}

    >返回参数

    	{   "errCode":INT,  //成功返回22000，失败返回22001
        		"data": {
        			"buildingList":[{
                    	"id":INT,   //楼盘id
                    	"cityId":INT,   //城市id
                    	"prov":STRING,   //省份名称
                    	"city":STRING,   //城市名称
                    	"areaId":INT,   //区域id
                    	"area":INT,   //区域名称
                    	"name":STRING,   //楼盘名称
                    	"recommend":INT,   //是否在首页推荐，0为否，1为是
                    	"designNum":INT,   //该楼盘设计方案总数
                    	"companyId":INT,   //开发商id
                    	"company":STRING,   //开发商公司名称
                    }
                    ……
                    ]
        		}
        }

###1.4 查询户型列表 ``` √ ```
[GET] http://121.40.212.161:8000/data/house/list

    >传入参数

    	{   "cityId":INT,//城市id
            "areaId":INT,//区域id
            "buildingId":INT,//楼盘id
            "state":ARRAY,//0代表正常，1代表删除，2代表前台不显示
            "num":INT,//每页显示个数
            "page":INT,//所在页数，第一页为1
    	}

    >返回参数

    	{   "errCode":INT,  //成功返回22000，失败返回22001
        		"data": {
        			"houseList":[{
                    	"id":INT,   //户型id
                    	"name":STRING,   //户型，如“两室一厅一厨一卫”
                    	"grossArea":STRING,   //建筑面积
                    	"usableArea":STRING,   //可使用面积
                    	"pic":STRING,   //户型图
                    	"houseDesignNum":INT,   //该户型设计方案数
                    	"state":INT,   //状态，0代表正常，1代表删除，2代表前台不显示
                    	"areaId":INT,   //区域id
                    	"area":INT,   //区域名称
                    	"cityId":INT,   //城市id
                        "prov":STRING,   //省份名称
                        "city":STRING,   //城市名称
                        "buildingId":INT,   //楼盘id
                    	"building":STRING,   //楼盘名称
						"buildingDesignNum":STRING,   //该楼盘设计方案总数
                    	"companyId":INT,   //开发商id
                    	"company":STRING,   //开发商公司名称
                    }
                    ……
                    ],
                    "pagination":{
                        "count":INT,  //总个数
                        "page":INT    //页数
                    }
        		}
        }

###1.5 单个户型信息  ``` √ ```
[GET] http://121.40.212.161:8000/data/house/info

    >传入参数

    	{   "id":INT,//户型id
    	}

    >返回参数

    	{   "errCode":INT,  //成功返回22000，失败返回22001
        	"data": {
                "id":INT,   //户型id
                "name":STRING,   //户型，如“两室一厅一厨一卫”
                "grossArea":STRING,   //建筑面积
                "usableArea":STRING,   //可使用面积
                "pic":STRING,   //户型图
                "houseDesignNum":INT,   //该户型设计方案数
                "state":INT,   //状态，0代表正常，1代表删除，2代表前台不显示
                "areaId":INT,   //区域id
                "area":INT,   //区域名称
                "cityId":INT,   //城市id
                "prov":STRING,   //省份名称
                "city":STRING,   //城市名称
                "buildingId":INT,   //楼盘id
                "building":STRING,   //楼盘名称
                "buildingDesignNum":STRING,   //该楼盘设计方案总数
                "companyId":INT,   //开发商id
                "company":STRING   //开发商公司名称
        	}
        }

##2 编辑
###2.1 新增楼盘 ``` √ ```
[GET] http://121.40.212.161:8000/data/building/edit?act=add

>传入参数

	{   "cityId":INT, //城市id
	    "areaId":INT, //区域id
	    "name":STRING, //楼盘名称
	    "company":STRING, //房产公司名称
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data":INT   //成功返回新增的楼盘id，失败返回0
	}

###2.2 更新楼盘 ``` √ ```
[GET] http://121.40.212.161:8000/data/building/edit?act=update

>传入参数

	{   "id":INT,//楼盘id
	    "cityId":INT, //城市id
	    "areaId":INT, //区域id
	    "name":STRING, //楼盘名称
	    "companyId":INT, //房产公司id
	    "company":STRING, //房产公司名称
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": BOOLEAN //成功为TRUE，失败为FALSE
	}


###2.3 推荐楼盘 ``` √ ```
[GET] http://121.40.212.161:8000/data/building/edit?act=recommend

>传入参数

	{   "id":INT,//楼盘id
	    "recommend":INT,//是否推荐，0为否，1为是
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": BOOLEAN //成功为TRUE，失败为FALSE
	}

###2.4 新增户型 ``` √ ```
[GET] http://121.40.212.161:8000/data/house/edit?act=add

>传入参数

	{
	    "buildingId":INT, //楼盘id
	    "name":STRING, //户型名称
	    "grossArea":STRING, //建筑面积，0.00
	    "usableArea":STRING, //可使用面积，0.00
	    "pic":STRING, //户型图地址
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data":INT   //成功返回新增的户型id，失败返回0
	}

###2.5 更新户型 ``` √ ```
[GET] http://121.40.212.161:8000/data/house/edit?act=update

>传入参数

	{   "id":INT, //户型id
	    "buildingId":INT, //楼盘id
	    "name":STRING, //户型名称
	    "grossArea":STRING, //建筑面积，0.00
	    "usableArea":STRING, //可使用面积，0.00
	    "pic":STRING, //户型图地址
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": BOOLEAN //成功为TRUE，失败为FALSE
	}


##3 删除
###3.1 删除楼盘 ``` √ ```
[GET] http://121.40.212.161:8000/data/building/edit?act=del

>传入参数

	{   "id":INT //楼盘id
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": BOOLEAN //成功为TRUE，失败为FALSE
	}

###3.2 更新户型状态 ``` √ ```
[GET] http://121.40.212.161:8000/data/house/edit?act=del

>传入参数

	{   "id":INT, //户型id
	    "state":INT //状态，0代表正常，1代表删除，2代表前台不显示
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": BOOLEAN //成功为TRUE，失败为FALSE
	}
