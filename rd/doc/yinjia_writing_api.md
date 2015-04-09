#文章相关API

##1 查询类

###1.1 文章列表
[GET] http://121.40.212.161:8000/data/writing/list

>传入参数

	{   "catId":INT,//文章分类id
	    "num":INT,//每页显示个数
	    "page":INT,//所在页数，第一页为1
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": [
			"writingList":[{
            	"id":INT,   //文章id
            	"name":STRING,   //文章名称
            	"modifyTime":STRING,   //文章最新更新日期

            }
            ……
            ],
            "pagination":{
            	"count":INT,  //总个数
            	"page":INT    //页数
            }
		]
	}