#文章相关API

##1 文章管理

###1.1 文章列表  ``` √ ```
[GET] http://121.40.212.161:8000/data/article/list

>传入参数

	{   "catId":INT,//文章分类id
	    "states":ARRAY,//0代表正常，1代表删除，2代表前台不显示
	    "num":INT,//每页显示个数
	    "page":INT,//所在页数，第一页为1
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": [
			"articleList":[{
            	"id":INT,   //文章id
            	"title":STRING,   //文章标题
            	"summary":STRING,   //文章简介
            	"content":STRING,   //文章内容
            	"author":STRING,   //文章作者
            	"pic":STRING,   //文章封面图
            	"modifyTime":STRING,   //文章最新更新日期
            	"createTime":STRING,   //文章创建日期
            	"sort":STRING,   //文章排序序号
            	"top":STRING,   //是否置顶，0为否，1为是
            	"state":STRING,   //状态，0代表正常显示，1代表删除，2代表前台不显示
            	"catId":STRING,  //文章分类id
            	"category":STRING //文章分类名称

            }
            ……
            ],
            "pagination":{
            	"count":INT,  //总个数
            	"page":INT    //页数
            }
		]
	}

###1.2 文章详情  ``` √ ```
[GET] http://121.40.212.161:8000/data/article/info

>传入参数

	{   "id":INT,//文章id
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": {
            	"id":INT,   //文章id
            	"title":STRING,   //文章标题
            	"content":STRING,   //文章内容
            	"summary":STRING,   //文章简介
            	"author":STRING,   //文章作者
            	"pic":STRING,   //文章封面图
            	"modifyTime":STRING,   //文章最新更新日期
            	"createTime":STRING,   //文章创建日期
            	"sort":STRING,   //文章排序序号
            	"top":STRING,   //是否置顶，0为否，1为是
            	"state":STRING,   //状态，0代表正常显示，1代表删除，2代表前台不显示
            	"catId":STRING,  //文章分类id
                "category":STRING //文章分类名称
        }
	}

###1.3 新增/编辑文章  ``` √ ```
[GET] http://121.40.212.161:8000/data/article/edit?act=save

>传入参数

	{   "id":INT,//文章id,新增时不需要传
	{   "catId":INT,//文章分类id
	    "title":STRING,   //文章标题
        "content":STRING,   //文章内容，不少于10个字
        "summary":STRING,   //文章简介,必填
        "author":STRING,   //文章作者，可以为空，默认为系统管理员
        "pic":STRING,   //文章封面图，可以为空，按需求前台控制
        "sort":INT,   //文章排序序号
        "top":INT,   //是否置顶，0为否，1为是
        "state":INT,   //是否在前台显示，0代表前台正常显示，2代表前台不显示
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//新增成功返回最新加入的文章id，编辑成功为TRUE，失败为FLASE
	}

###1.3 删除文章  ``` √ ```
[GET] http://121.40.212.161:8000/data/article/edit?act=del

>传入参数

	{   "id":INT,//文章id
        "state":INT, //状态，0代表正常显示，1代表删除，2代表前台不显示
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE
	}

###1.4 置顶文章  ``` √ ```
[GET] http://121.40.212.161:8000/data/article/edit?act=top

>传入参数

	{   "id":INT,//文章id
        "top":INT, //状态，是否置顶，0为否，1为是
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE
	}

###1.5 文章排序  ``` √ ```
[GET] http://121.40.212.161:8000/data/article/edit?act=sort

>传入参数

	{   "id":INT,//文章id
        "sort":INT, //排序序号
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE
	}

##2 文章分类管理

###2.1 文章分类列表  ``` √ ```
[GET]http://121.40.212.161:8000/data/article/category/list

>传入参数

	{   无
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": [{
			"id": String, // 分类id
			"name": String, // 分类名称
			"fatherId": String, // 该分类的父分类id
			"layer": String, // 分类编号，限定为5层，初始值为00000000,每两位一组，每层最多99个子类别
			"state": String, // 0代表正常显示，1代表删除，2代表前台不显示
		}]
	}

###2.2 新增/编辑文章分类  ``` √ ```
[POST] http://121.40.212.161:8000/data/article/category/edit?act=save

>传入参数

	{   "id":INT,//类别id,新增时不传,编辑后保存时传入
	    "name":STRING,//分类名称
	    "fatherId":INT,//父类别id (根节点为0)，新增时保存需要传入，编辑后保存不需要
	    "state":INT,//状态，0代表正常显示，1代表删除，2代表前台不显示
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//新增成功返回最新加入的分类id，编辑成功为TRUE，失败为FLASE
	}

###2.3 删除分类  ``` √ ```
[GET] http://121.40.212.161:8000/data/article/category/edit?act=del

>传入参数

	{   "id":INT,//类别id,约定当该分类存在子分类时不能删除
    }

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEN,//成功为TRUE，失败为FLASE
	}