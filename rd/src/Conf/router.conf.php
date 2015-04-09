<?php
/**
 * 路由分发配置文件
 */


//路由规则表
$routerRules = array(

	//用户页面
	'people/(\d+)' => 'people/index?uid=$1',
	'people/(\d+)/profile' => 'people/index?uid=$1&type=profile',
	'people/(\d+)/recommend' => 'recommend/getList?uid=$1',
	'people/(\d+)/collection' => 'favorite/getList?uid=$1',
	'people/(\d+)/following' => 'follow/getFollowingList?uid=$1',
	'people/(\d+)/follower' => 'follow/getFollowerList?uid=$1',

	//榜单
	'top'=>'top/index',
	'top/(\w+)'=>'top/others?type=$1',
	'top/(\w+)/(\d+)'=>'top/others?type=$1&no=$2',

	//专辑
	'album/(\d+)' => 'album/detail?album_id=$1',
	'album/(\d+)/ajax' => 'album/detail?album_id=$1&tn=ajax',

	//app
	'app/tingradio' => 'app/tingradio::index',

	'helloworld' => 'helloWorld',
	'helloworld/(.*)' => 'helloWorld',

	'testsmarty' => 'testSmarty',
	'testdb/(\d+)' => 'testdb?userid=$1',
    'testjson' => 'testjson',

    //测试
    'data/test/json/decode' => 'testDecodeJson',


    // 户型信息相关
    //'data/search/building' => 'house/getBuildingListApi',    //根据城市Id搜索楼盘
    'data/search/housetype' => 'house/getHouseTypeListApi',    //根据楼盘ID搜索户型图
    'data/house/type' => 'house/houseInfoApi',    //户型搜索结果
    //'data/house/info' => 'house/getHouseInfoApi', // 查询户型信息
    //'data/house/edit' => 'house/editHouseInfoApi', // 编辑户型

    //楼盘管理
    //'data/building/list' => 'adminBuilding/buildingListApi', // 楼盘列表
    //'data/building/info' => 'adminBuilding/buildingInfoApi', // 楼盘信息
    //'data/building/edit' => 'adminBuilding/editBuildingApi', // 操作楼盘

    // 设计方案相关
    'data/design/info' => 'design/designInfoApi',     //同一户型的设计方案列表
    'data/design/list' => 'design/designListApi',     //按条件查询的设计方案列表
    'data/design/details' => 'design/designDetailsApi',     //前台用户看的设计方案详情页
    'data/design/edit' => 'design/editDesignApi',          //添加设计方案效果图
    'data/order/design/edit' => 'design/editOrderDesignApi',          //与订单关联的设计方案效果图
    'data/design/display' => 'design/designPropagadaApi', //not use
    //'data/design/collect' => 'design/collectDesignApi', // 收藏设计方案
    'data/design/buy' => 'design/buyDesignApi', // 购买设计方案


    // 用户注册
//    'data/user/register' => 'user/register',
    //上传图片到又拍云测试
    'test/upyun'=>'testupyun',

    // 用户相关
    //'data/user/verify'=>'user/sendVerify',  //发送验证码
    //'data/user/register' => 'user/userRegisterApi', // 注册
    //'data/user/info' => 'user/userInfoApi', // 显示当前用户信息
    'data/user/check' => 'user/checkApi', //
    'data/check/administrator' => 'user/checkAdministratorApi', //检查管理员是否登录
    //'data/user/login' => 'user/userLoginApi', // 登录
    //'data/administrator/login' => 'user/administratorLoginApi', // 管理员登录
    //'data/user/logout' => 'user/userLogoutApi', // 退出登录
    'data/user/update' => 'user/userEditApi', // 基本信息更新

    'data/user/setting' => 'user/userSettingApi', // 用户个人中心
    'data/check/designer' => 'user/checkDesignerApi',//判断是否是通过实名认证的设计师

    //后台管理系统-用户管理
    //'data/admin/user/list' => 'adminUser/adminUserListApi', // 普通用户列表
    //'data/admin/user/info' => 'adminUser/adminUserInfoApi', // 普通用户信息
    //'data/admin/user/edit' => 'adminUser/editAdminUserApi', // 对普通用户操作
    'data/admin/designer/list' => 'adminDesigner/adminDesignerListApi', // 设计师用户列表
    'data/admin/designer/info' => 'adminDesigner/adminDesignerInfoApi', // 设计师用户信息
    'data/admin/designer/edit' => 'adminDesigner/editAdminDesignerApi', // 对设计师用户操作

    //实名认证相关
    //'data/verify/submit' => 'verify/submitVerifyApi', // 提交认证
    //'data/verify/result' => 'verify/verifyResultApi', // 认证结果



    //建材相关
    'data/goods/list' => 'goods/goodsListApi', // 建材列表
    'data/goods/info' => 'goods/goodsInfoApi', // 单个商品详细信息
    'data/goods/edit' => 'goods/editGoodsApi', // 编辑建材信息
    'data/goods/details' => 'goods/goodsDetailsApi', // 单个建材详情

    // 图片上传
    'data/image/upload' => 'image/uploadImageApi',
    // 文件上传
    'data/file/upload' => 'file/uploadFileApi',

    //个人中心
    'data/my/housetype' => 'my/myHouseTypeApi',    //获取我的户型图
    'data/add/myhouse' => 'my/addMyHouseTypeApi',    //设为我的户型
    //'data/my/design/collection' => 'my/myDesignCollectionApi', // 查询关注的设计方案列表
    'data/my/design/order' => 'my/designOrderApi', // 查询已经购买的设计订单

    //订单相关
    'data/design/order/info' => 'order/designOrderInfoApi',  //设计方案（定金/余款）订单详情
    'data/design/order/status' => 'order/designOrderStatusApi',  //设计方案（定金/余款）订单状态更新
    'data/designer/order/list' => 'order/designerOrderListApi',  //设计师中心订单列表
    'data/order/list' => 'order/orderListApi',  //订单列表


    //收货地址
    'data/user/addr' => 'user/userAddrListApi', // 查询用户的收货地址列表
    'data/addr/edit' => 'user/editAddrApi', // 编辑用户的收货地址列表

    //商品分类管理
    'data/category/list' => 'category/categoryListApi', // 分类列表
    'data/category/edit' => 'category/editCategoryApi', // 编辑分类（新增，更新，删除，是否显示）

    //商品品牌管理
    'data/brand/list' => 'brand/brandListApi', // 品牌列表
    'data/brand/edit' => 'brand/editBrandApi', // 编辑品牌（新增，更新，删除，排序）
    'data/brand/info' => 'brand/brandInfoApi', // 品牌信息

    //商品品牌管理
    'data/provider/list' => 'provider/providerListApi', // 供应商列表
    'data/provider/edit' => 'provider/editProviderApi', // 编辑供应商（新增，更新，删除，排序）
    'data/provider/info' => 'provider/providerInfoApi', // 供应商信息

    //商品规格管理
    'data/spec/list' => 'spec/specListApi', // 规格列表
    'data/spec/edit' => 'spec/editSpecApi', // 编辑规格（新增，更新，删除，排序）
    'data/spec/info' => 'spec/specInfoApi', // 规格信息
    'data/spec/pic/list' => 'spec/specPicListApi', // 规格图片列表
    'data/spec/pic/edit' => 'spec/editSpecPicApi', // 编辑规格图片（删除）

    //20150301后添加接口
    //户型相关接口
    'data/building/list' => 'house/buildingListApi', //楼盘列表
    'data/building/recommend' => 'house/buildingRecommendApi', //首页推荐楼盘列表
    'data/building/info' => 'house/buildingInfoApi', // 楼盘信息
    'data/building/edit' => 'house/buildingEditApi', // 操作楼盘，新增、更新、删除、推荐

    'data/house/list' => 'house/houseListApi',//户型列表
    'data/house/info' => 'house/houseInfoApi',//单个户型详情
    'data/house/edit' => 'house/houseEditApi',//编辑户型信息
    //设计方案相关接口
    'data/design/base/edit' => 'design/designBaseEditApi',   //设计方案基本信息操作
    'data/design/base/info' => 'design/designBaseInfoApi',   //设计方案基本信息
    'data/design/pic/edit' => 'design/designPicEditApi',   //设计方案效果图操作
    'data/design/pic/info' => 'design/designPicInfoApi',   //设计方案效果图信息
    'data/design/cad/edit' => 'design/designCadEditApi',   //设计方案施工图操作
    'data/design/cad/info' => 'design/designCadInfoApi',   //设计方案施工图信息
    'data/design/material/edit' => 'design/designMaterialEditApi',   //设计方案材料清单操作
    'data/design/material/info' => 'design/designMaterialInfoApi',   //设计方案材料清单信息
    'data/design/material/info2user' => 'design/designMaterialInfo2UserApi',   //设计方案材料清单信息（给普通用户查看）
    'data/design/manual/info' => 'design/designManualInfoApi',   //设计方案人工+辅料单价信息
    'data/design/manual/list' => 'design/designManualListApi',   //所有设计方案人工+辅料单价信息
    'data/admin/design/manual/list' => 'design/adminDesignManualListApi',   //所有设计方案人工+辅料单价信息(后台管理系统使用)
    'data/design/manual/edit' => 'design/designManualEditApi',   //所有设计方案人工+辅料信息编辑

    'data/designer/schema/list' => 'design/designerSchemaListApi',  //设计师的设计方案列表
    'data/designer/schema/edit' => 'design/designerSchemaEditApi',  //设计师对设计方案进行操作

    'data/design/schema/list' => 'design/designSchemaListApi',  //设计方案列表

    'data/admin/design/schema/edit' => 'design/adminDesignSchemaEditApi',  //后台管理系统设计方案操作

    'data/design/comment/list' => 'design/designCommentListApi',//设计方案评论列表
    'data/design/comment/edit' => 'design/designCommentEditApi',//设计方案评论编辑（添加、删除）
    //用户-设计方案操作接口
    'data/design/collect' => 'my/collectDesignApi', // 收藏设计方案
    'data/my/design/collection' => 'my/myDesignCollectionApi', // 查询收藏的设计方案列表
    'data/design/collection/del' => 'my/myDesignCollectionDelApi', // 在收藏的设计方案列表中删除方案
    'data/my/design/material' => 'my/myDesignMaterialApi', // 查询收藏的设计方案的材料清单
    'data/my/design/material/edit' => 'my/myDesignMaterialEditApi', // 查询收藏的设计方案的材料清单编辑

    //文章相关接口
    'data/article/category/list' => 'articleCat/articleCatListApi',//文章分类列表
    'data/article/category/edit' => 'articleCat/articleCatEditApi',//文章分类列表

    'data/article/list' => 'article/articleListApi',//文章列表
    'data/article/info' => 'article/articleInfoApi',//文章详情
    'data/article/edit' => 'article/articleEditApi',//编辑文章
    //用户相关接口
    'data/user/identifying/code'=>'user/sendIdentifyingCodeApi',  //发送验证码
    'data/user/register' => 'user/userRegisterApi', // 注册
    'data/user/login' => 'user/userLoginApi', // 登录
    'data/user/tel/right' => 'user/userCheckTelApi', // 验证手机号和验证码是否一致
    'data/user/pwd/reset' => 'user/userPwdRstApi', // 重置密码
    'data/administrator/login' => 'user/administratorLoginApi', // 管理员登录
    'data/user/logout' => 'user/userLogoutApi', // 退出登录
    'data/admin/user/list' => 'user/adminUserListApi', // 用户列表(管理员查看)
    'data/super/user/list' => 'user/superUserListApi', // 管理员用户列表(管理员查看)
    'data/user/info' => 'user/userInfoApi', // 显示当前用户信息
    'data/user/edit' => 'user/userEditApi', // 修改当前用户信息
    'data/admin/user/info' => 'user/adminUserInfoApi', //用户信息（管理员查看）
    'data/admin/user/edit' => 'user/adminUserEditApi', // 编辑用户（管理员）

    'data/user/verify' => 'user/userVerifyApi', // 提交认证
    'data/user/addr/list' => 'user/userAddrListApi', // 收件地址列表
    'data/user/addr/info' => 'user/userAddrInfoApi', // 收件地址详情
    'data/user/addr/edit' => 'user/userAddrEditApi', // 编辑收件地址



);

//路由配置
$config['routerConfig'] = array(
	'defaultAction' => 'index',		//默认分发action页面
	'baseDir' => ROOT_PATH,			//运行根目录
	'uiDir' => 'Ui/',				//设置ui的根目录
	'baseAction' => 'base',			//默认action基类
	'baseController' => 'base',		//默认controller基类
	'routerRules' => $routerRules,	//加载路由规则
);

?>
