#用户相关API

##1 用户注册
###1.1 发送验证码  ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/identifying/code
>传入参数

	{   "tel":STRING,//11位手机号
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//发送成功为TRUE，失败为FALSE
	}

###1.2 提交注册信息  ``` √ ``` 2015-03-15
[POST] http://121.40.212.161:8000/data/user/register
>传入参数

	{   "tel":STRING, //11位手机号
	    "code":STRING,  //验证码
	    "userName":STRING,  //用户名
	    "pwd":STRING,  //密码
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": INT,//成功返回新增的用户id，失败为FALSE
	}

##2 用户登录
###2.1 手机号/用户名登录  ``` √ ``` 2015-03-15
[POST] http://121.40.212.161:8000/data/user/login
>传入参数

	{   "user":STRING,  //用户名或手机号码
	    "pwd":STRING,  //密码
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//登录成功为TRUE，失败为FALSE
	}

###2.2 管理员登录  ``` √ ``` 2015-03-15
[POST] http://121.40.212.161:8000/data/administrator/login
>传入参数

	{   "user":STRING,  //用户名或手机号码
	    "pwd":STRING,  //密码
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//登录成功为TRUE，失败为FALSE
	}

###2.3 退出登录  ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/logout
>传入参数

	{   无
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}


##3 用户后台管理
###3.1 用户列表  ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/admin/user/list
>传入参数

	{   "isSpecial":INT,  //用户类型，0为普通用户，1为设计师用户，10为超级管理员，11设计方案管理员，12为材料管理员，13文章管理员，设计师用户拥有普通用户权限，超级管理员拥有所有权限
	    "states":ARRAY,  //审核状态，0为否，1为是，2为审核中，3为未知
	    "num":INT,//每页显示个数
        "page":INT,//所在页数，第一页为1
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": [
			"userList":[{
            	"id":INT,   //用户id
            	"tel":STRING,   //手机号
            	"userName":STRING,   //用户名
            	"realName":STRING,   //真实名字
            	"createTime":STRING,   //注册时间
            	"userSex":STRING,   //性别，0为男，1为女，2为未知
            	"avatar":STRING,   //用户头像
            	"birthday":STRING,   //生日
            	"isSpecial":STRING,   //用户类型，0为普通用户，1为设计师用户，10为超级管理员
            	"state":STRING,   //审核状态，0为否，1为是，2为审核中，3为未知
            	"userShow":STRING,   //个性签名
            	"qq":STRING,   //qq号码
            	"email":STRING,   //电子邮箱
            	"alipay":STRING,  //支付宝账号
            	"cid":STRING,  //身份证号码
            	"cidFrontPic":STRING,  //身份证正面（个人信息面）图片
            	"cidBackPic":STRING,  //身份证反面（国徽图案面）图片
            	"reason":STRING,  //审核失败原因
            	"designerSn":STRING //设计师编号
            }
            ……
            ],
            "pagination":{
            	"count":INT,  //总个数
            	"page":INT    //页数
            }
		]
	}


###3.2 单个用户信息（管理员查看）  ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/admin/user/info
>传入参数

	{   "id":INT,  //用户id
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": {
            "id":INT,   //用户id
            "tel":STRING,   //手机号
            "userName":STRING,   //用户名
            "realName":STRING,   //真实名字
            "createTime":STRING,   //注册时间
            "userSex":STRING,   //性别，0为男，1为女，2为未知
            "avatar":STRING,   //用户头像
            "birthday":STRING,   //生日
            "isSpecial":STRING,   //用户类型，0为普通用户，1为设计师用户，10为超级管理员
            "state":STRING,   //审核状态，0为否，1为是，2为审核中，3为未知
            "userShow":STRING,   //个性签名
            "qq":STRING,   //qq号码
            "email":STRING,   //电子邮箱
            "alipay":STRING,  //支付宝账号
            "cid":STRING,  //身份证号码
            "cidFrontPic":STRING,  //身份证正面（个人信息面）图片
            "cidBackPic":STRING,  //身份证反面（国徽图案面）图片
            "reason":STRING,  //审核失败原因
            "designerSn":STRING //设计师编号
        }
	}

###3.3 删除用户  ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/admin/user/edit?act=del
>传入参数

	{   "id":INT,  //用户id
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}


###3.4 审核设计师用户  ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/admin/user/edit?act=check
>传入参数

	{   "id":INT,  //用户id
	    "isChecked":INT, //是否审核通过，0为否，1为是
	    "failReason":STRING, //审核不通过原因
	}

##4 实名认证
###4.1 提交实名认证信息/修改后提交实名认证信息 ``` √ ``` 2015-03-15
[POST] http://121.40.212.161:8000/data/user/verify
>传入参数

	{   "realName":INT,  //真实姓名
	    "qq":STRING,   //qq号码
        "alipay":STRING,  //支付宝账号
        "cid":STRING,  //身份证号码
        "cidFrontPic":STRING,  //身份证正面（个人信息面）图片
        "cidBackPic":STRING,  //身份证反面（国徽图案面）图片
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}

##5 用户信息维护
###5.1 当前用户信息 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/info
>传入参数

	{   无
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": {
            "id":INT,   //用户id
            "tel":STRING,   //手机号
            "userName":STRING,   //用户名
            "realName":STRING,   //真实名字
            "createTime":STRING,   //注册时间
            "userSex":STRING,   //性别，0为男，1为女，2为未知
            "avatar":STRING,   //用户头像
            "birthday":STRING,   //生日
            "isSpecial":STRING,   //用户类型，0为普通用户，1为设计师用户，10为超级管理员
            "state":STRING,   //审核状态，0为否，1为是，2为审核中，3为未知
            "userShow":STRING,   //个性签名
            "qq":STRING,   //qq号码
            "email":STRING,   //电子邮箱
            "alipay":STRING,  //支付宝账号
            "cid":STRING,  //身份证号码
            "cidFrontPic":STRING,  //身份证正面（个人信息面）图片
            "cidBackPic":STRING,  //身份证反面（国徽图案面）图片
            "reason":STRING,  //审核失败原因
            "designerSn":STRING //设计师编号
        }
	}

###5.2 当前用户修改个人基本信息 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/edit?part=base
>传入参数

	{   "avatar":STRING,  //基本信息
	    "userSex":INT,    //性别，0为男，1为女，2为未知
        "birthday":STRING,   //生日
        "userShow":STRING,   //个性签名
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}

###5.3 当前用户修改密码 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/edit?part=pwd
>传入参数

	{   "oldPwd":STRING,  //旧密码
	    "newPwd":STRING,    //新密码
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}

###5.4 当前用户修改手机号 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/edit?part=tel
>传入参数

	{   "tel":STRING,    //手机号
	    "code":STRING,    //验证码
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}

###5.5 当前用户修改邮箱 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/edit?part=email
>传入参数

	{   "email":STRING,    //邮箱号
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}

##6 收件地址
###6.1 当前用户收件地址列表 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/addr/list
>传入参数

	{   无
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": {
			"addrList":[{
            	"id":INT,   //收件地址id
            	"userId":STRING,   //用户id
            	"address":STRING,   //详细地址
            	"area":STRING,   //区域名
            	"city":STRING,   //城市名
            	"province":STRING,   //省份名
            	"name":STRING,   //收件人名
            	"zip":STRING,   //邮政编码
            	"telephone":STRING,   //手机号
            	"mobile":STRING,   //座机号
            	"isDefault":STRING   //是否是默认地址，0为否，1为是
            }
            ……
            ]
		}
	}


###6.2 收件地址详情 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/addr/info
>传入参数

	{   "id":INT,    //收件地址id
	}

>返回参数

	{   "errCode":INT,  //成功返回22000，失败返回22001
		"data": {
            "id":INT,   //收件地址id
            "userId":STRING,   //用户id
            "address":STRING,   //详细地址
            "area":STRING,   //区域名
            "city":STRING,   //城市名
            "province":STRING,   //省份名
            "name":STRING,   //收件人名
            "zip":STRING,   //邮政编码
            "telephone":STRING,   //手机号
            "mobile":STRING,   //座机号
            "isDefault":STRING   //是否是默认地址，0为否，1为是
		}
	}

###6.3 新增/修改收件地址 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/addr/edit?act=save
>传入参数

	{   "id":INT,   //收件地址id，新增时不用传
        "address":STRING,   //详细地址
        "area":STRING,   //区域名
        "city":STRING,   //城市名
        "province":STRING,   //省份名
        "name":STRING,   //收件人名
        "zip":STRING,   //邮政编码
        "telephone":STRING,   //手机号
        "mobile":STRING,   //座机号，非必填
        "isDefault":STRING   //是否是默认地址，0为否，1为是
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功返回新增收件地址id，失败为FALSE
	}

###6.4 设为默认地址 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/addr/edit?act=default
>传入参数

	{   "id":INT,    //收件地址id
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}

###6.5 删除收件地址 ``` √ ``` 2015-03-15
[GET] http://121.40.212.161:8000/data/user/addr/edit?act=del
>传入参数

	{   "id":INT,    //收件地址id
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//成功为TRUE，失败为FALSE
	}

##7 找回密码
###7.1 验证手机号与验证码是否一致
[GET] http://121.40.212.161:8000/data/user/tel/right
>传入参数

	{   "tel":STRING,//11位手机号
	    "code":STRING,//验证码
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//发送成功为TRUE，失败为FALSE
	}

###7.2 修改密码
[GET] http://121.40.212.161:8000/data/user/pwd/reset
>传入参数

	{   "tel":STRING,//11位手机号
	    "code":STRING,//验证码
	    "pwd":STRING,//新密码
	}

>返回参数

	{   "errCode":22000,  //成功返回22000，失败返回22001
		"data": BOOLEAN,//发送成功为TRUE，失败为FALSE
	}






