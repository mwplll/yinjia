<?php
/**
 * 定义全站错误信息
 * 号段范围 22000 ~ 22999
 */
//公用保留
//50个（22000--22050）
define('SUCCESS', 22000);//操作成功
define('FAILED', 22001);//操作失败
define('SYSTERM_ERROR', 22003);//系统错误
define('PARAM_ERROR', 22005);//参数错误
define('CANNOT_DELETE', 22017);//参数错误
define('NUM_TOO_BIG', 22006);//过多超出限制
define('NUM_TOO_SMALL', 22007);//过少超出限制
define('REQUEST_METHOD_NOT_EXIST',22008); // 请求的方法不存在
define('NO_PERMISSION',22009); // 没有权限
define('SIGNATURE_ERROR',22010); // API签名错误
define('ACTION_FREQUENT',22011); // 操作过频繁
define('CONTENT_OFFLINE', 22012);	//	内容已下架
define('DOWNLOAD_LIMIT', 22013);	//	下载限制
define('VCODE_ERROR', 22014);		//	验证码错误
define('COMMENT_REPEAT',22015); // 请不要重复评论，谢谢！
define('COMMENT_FREQUENT',22016); // 您操作的过于频繁，请稍候再试

//文件上传，像册操作
//30个（22201--22230 ）
define('UP_HOST_CONNECT_ERROR', 22201); //连接文件服务器失败
define('UP_OVERSIZE', 22202); //文件过大
define('UP_UNDERSIZE', 22203); //文件过小
define('UP_TYPE_NOT_ALLOW', 22204); //不允许上传的文件格式
define('UP_FILE_NULL', 22205); //文件为空

//socket/mysql等
//30个（22051--22080）
define('SOCKET_CONNECT_ERROR', 22051);//socket连接失败
define('SOCKET_WRITE_ERROR', 22052);//socket写失败
define('SOCKET_READ_ERROR', 22053);//socket读失败
define('MYSQL_CONNECT_ERROR', 22054);//mysql连接失败
define('MYSQL_SQL_ERROR', 22055);//sql语句错误

//通知、听信
//20个（22081--22100）
define('INFORM_DEL_NOT_ALLOWED', 22081);//通知无删除权限
define('TMSG_SEND_NOT_ALLOWED', 22082);//无权发送听信

//搜索
//50个（22101--22150 ）
define('SEARCH_CONNECT_ERROR', 22101);//search服务器连接失败
define('SEARCH_NO_MATCH_RESULT', 22102);//没有合适的匹配结果

//音乐盒
//50个（22151--22200）
define('BOX_ERROR', 22151);
define('BOX_GET_CHANNEL_ERROR', 22152);
define('BOX_GET_CHANNEL_SONGS_ERROR', 22153);
define('BOX_SEARCH_ARTIST_ERROR', 22154);
define('BOX_SONG_BITRATE_ZERO', 22155);//选链码率为0
define('BOX_NO_PROPER_LINK', 22156);//没有合适的链接




//黄反ip过滤
//50个（22231--22280）
define('CONTENT_HAVE_ANTI', 22231);//内容含有黄反
define('IP_FORBIDDEN', 22232);//ip被禁止
define('IP_NOTFOUND', 22233);//无ip信息
define('IP_NOTPUBLIC', 22234);//ip为内网ip

//关注
//20个（22281--22300）
define('FOLLOW_NOT_ALLOW_SELF', 22281); //不能关注自己
define('FOLLOW_DONE', 22282); //已经关注过
define('FOLLOW_EXCEED_LIMIT', 22283); //关注的人数超过限制

//推荐
//20个（22301--22320）
define('RECOMMEND_ILLEGAL_TYPE', 22301);	//非法的推荐类型
define('RECOMMEND_SONG_COUNT_MAX', 22311);	//推荐歌曲已达到最大数量
define('RECOMMEND_ALBUM_COUNT_MAX', 22312);	//推荐专辑已达到最大数量
define('RECOMMEND_DIY_COUNT_MAX', 22313);	//推荐DIY已达到最大数量
define('RECOMMEND_PEOPLE_COUNT_MAX', 22314);//推荐人已达到最大数量

//收藏
//20个（22321--22340）
define('FAVORITE_ILLEGAL_TYPE', 22321);	//非法的收藏类型
define('FAVORITE_DUPLICATE', 22322);	//收藏重复
define('FAVORITE_SONG_COUNT_MAX', 22331);//收藏歌曲已达到最大数量
define('FAVORITE_ALBUM_COUNT_MAX', 22332);//收藏专辑已达到最大数量
define('FAVORITE_DIY_COUNT_MAX', 22333);//收藏DIY已达到最大数量
define('SONG_UNCOLLECT', 22334);//歌曲为收藏

//留言、评论
//50个（22401--22450）
define('COMMENT_ERROR_TYPE', 22401);//错误的评论类型
define('COMMENT_DEL_NOT_ALLOWED', 22402);//无删除权限

//用户操作
//100个（22451--22550）
define('USER_AVATAR_UPDATE_FAILED', 22451);//更新头像失败
define('USER_UNLOGIN', 22452);//用户未登录
define('USER_UNACTIVE', 22453);//用户未激活
define('USER_DELETE', 22454);//用户已删除
define('PASSPORTINFO_GET_FAILED', 22455);//获取用户passport信息失败
define('USER_BASE_INFO_ADD_FAILED', 22456);//添加用户基本信息失败
define('TING_UID_ASSIGN_FAILED', 22457);//分配Ting Uid失败
define('USER_IS_ACTIVATED', 22458);//用户已激活
define('USER_NICK_ISEMPTY', 22459);//用户昵称不能为空
define('USER_SIGN_TOOLONG', 22460);//用户签名过长



//歌单
define('PLAYLIST_MAX_COUNT_LIMIT',22677);
define('PLAYLIST_TITLE_DUP',22678);
define('PLAYLIST_HAS_DEL',22679);
define('PLAYLIST_MAX_SONG_COUNT_LIMIT',22680);

//专辑
//20个(22691-22610)
define("ALBUM_ID_ISVALID_ERROR",22691);//非法专辑代号

//邀请
//20个(22720--22730)
define('INVITATION_CODE_INVALID', 22720);
define('INVITATION_CODE_USED', 22721);
define('INVITATION_CODE_NOHAVE', 22722);
define('INVITATION_CODE_AVAIL', 22723);
define('INVITATION_CODE_FAILED', 22725);

//外部通讯录 + 明星邀请活动
//10个(22730--22740)
define('CONTACT_FETCH_FAILED', 22730);//暂时未能取得通讯录
define('CONTACT_ACCOUNT_ERROR', 22731);//账号或密码错误
define('CONTACT_TIMEOUT', 22732);//连接超时

define('INVITE_ACTIVITY_NOT_FOLLOWED', 22733);//没有关注明星

//首发活动
define('SHOUFA_REVOTED',22800);	//重复投票


//投票错误常量
//30个（22850--22880）
define('NOT_VALID_VOTE', 22850);//不是有效的投票
define('VOTE_IS_EXPIRE', 22851);//投票过期啦
define('VOTE_OUT_LIMITS', 22852);//投票超出最大选项
define('IS_ALREADY_POST', 22853);//对这个主题已投过票啦
define('VOTE_IS_CLOSE', 22854);//投票关闭
//顶踩错误常量
define('NOT_VALID_UPD', 22860);//不是有效的顶踩数据
define('UPD_IS_EXPIRE', 22861);//过期啦
define('UPD_OUT_LIMITS', 22862);//顶踩超出最大选项
define('IS_ALREADY_UPD', 22863);//对这个主题已顶过啦

//短信平台发送短信失败常量
define('SEND_FAILED', 22900);

//个人域名格式相关
define('Domain_len', 22910);//长度不合法
define('Domain_bad', 22911);//含有特殊字符
define('Domain_late', 22912);//已被注册，注册晚了

//抽奖相关
define('LOTTERY_NO_CHANCE', 23000);//没有抽奖机会了
define('LOTTERY_GIFT_UNRECEIVE', 23001);//未领奖

//付费相关
define('HAVENOT_BUY_SONG', 23101);//尚未购买

//云操作相关
define('CLOUD_FAV_SUCC', 23200);//收藏成功
define('CLOUD_FAV_FAIL', 23201);//收藏失败
define('CLOUD_FAV_REPEAT', 23202);//重复收藏
define('CLOUD_FAV_OVERFLOW', 23203);//收藏歌曲已达到最大数量
//演出活动
define('TICKET_OFF_SHELF', 23301);//下架
define('TICKET_NOT_ENOUGH',23302);//余票不足
define('TICKET_NUM_LIMIT',23303);//超过购买限制
?>
