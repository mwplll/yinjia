#管理员用户接口

###1 管理员用户列表
[GET] http://121.40.212.161:8000/data/super/user/list
>传入参数

	{   无
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": {
			"userList":[{
            	"id":INT,   //用户id
            	"user":STRING,   //用户名
            	"isSpecial":STRING,   //用户类型，10为超级管理员，11设计方案管理员，12为材料管理员，13文章管理员
            }
            ……
            ]
		}
	}

###2 新增管理员
[GET] http://121.40.212.161:8000/data/admin/user/edit?act=add
>传入参数

	{   "user":STRING, //用户名
	    "pwd":STRING, //密码
	    "isSpecial":INT, //拥有权限的模块，10为超级管理员，11设计方案管理员，12为材料管理员，13文章管理员
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}


###3 修改用户名/密码/权限模块
[GET] http://121.40.212.161:8000/data/admin/user/edit?act=update
>传入参数

	{   "id":INT, //用户id
	    "user":STRING, //用户名
	    "pwd":STRING, //密码
	    "isSpecial":INT, //拥有权限的模块，10为超级管理员，11设计方案管理员，12为材料管理员，13文章管理员
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}