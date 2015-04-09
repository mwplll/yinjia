DROP TABLE IF EXISTS wm_design_user;
DROP TABLE IF EXISTS wm_addr;
DROP TABLE IF EXISTS wm_user;
DROP TABLE IF EXISTS wm_material_user;


CREATE TABLE wm_user (
    user_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局用户ID',
    user_name VARCHAR(24) NOT NULL COMMENT '用户名',
    user_passwd CHAR(32) NOT NULL COMMENT '密码 md5 hash 值',
    user_tel CHAR(11) NOT NULL COMMENT '手机号码',
    create_time INT(11) NOT NULL COMMENT '注册时间',
    user_sex INT NOT NULL DEFAULT 2 COMMENT '性别，0为男，1为女，2为保密',
    house_type_id INT NULL COMMENT '户型图ID',
    user_avatar VARCHAR(250) NULL DEFAULT '/user/avator/f231a42afc9269ffdca316d41328d221.jpg' COMMENT '头像的url地址',
    is_special TINYINT NOT NULL DEFAULT 0 COMMENT '用户类型，0为普通用户，1为设计师，10为管理员',
    birthday DATE NULL COMMENT '生日',
    user_show VARCHAR(250) NULL COMMENT '个性签名',
    real_name VARCHAR(24) NOT NULL COMMENT '真实姓名',
    designer_sn INT(10) NOT NULL COMMENT '设计师编号',
    qq VARCHAR(18) NOT NULL COMMENT 'qq号码',
    alipay VARCHAR(50) NOT NULL COMMENT '支付宝账号',
    email VARCHAR(50) NOT NULL COMMENT '邮箱',
    cid VARCHAR(18) NOT NULL COMMENT '身份证号码',
    cid_front_pic VARCHAR(250) NOT NULL COMMENT '身份证正面图片url地址',
    cid_back_pic VARCHAR(250) NOT NULL COMMENT '身份证背面图片url地址',
    fail_reason TEXT  NULL COMMENT '审核失败原因',
    is_checked INT NOT NULL DEFAULT 3 COMMENT '是否通过审核，0为否，1为是，2为审核中，3为未知',
    user_del INT NOT NULL DEFAULT 0 COMMENT '是否删除，0为否，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户帐号表';

CREATE TABLE wm_addr (
    addr_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局收货ID',
    user_id INT NOT NULL COMMENT '用户id',
    area VARCHAR(20) NOT NULL COMMENT '区名称',
    city VARCHAR(20) NOT NULL COMMENT '城市名称',
    province VARCHAR(20) NOT NULL COMMENT '省名称',
    accept_name VARCHAR(20) NOT NULL COMMENT '收货人姓名',
    zip CHAR(6) NOT NULL COMMENT '邮政编码',
    telephone CHAR(11) NOT NULL COMMENT '联系电话',
    address VARCHAR(250) NOT NULL COMMENT '收货地址',
    mobile VARCHAR(20) NULL COMMENT '座机号码',
    is_default TINYINT(6) NOT NULL default 0 COMMENT '是否为默认收货地址，0为否，1为是',
    addr_del INT NOT NULL DEFAULT 0 COMMENT '是否删除，0为否，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收货地址表';

################################################################
#   普通用户-设计方案关联表，一个用户可收藏多个设计方案
################################################################
CREATE TABLE wm_design_user (
    design_user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '全局 id',
    user_id INT NOT NULL COMMENT '用户 id 外键',
    design_schema_id INT NOT NULL COMMENT '设计方案 id 外键',
    design_user_del INT NOT NULL DEFAULT 0 COMMENT '是否删除，0为否，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='普通用户-设计方案关联表';

################################################################
#   普通用户-设计方案材料关联表，一个用户可收藏多个设计方案
################################################################
CREATE TABLE IF NOT EXISTS `wm_material_user` (
    `material_user_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '用户-材料全局Id',
    `design_schema_id` INT NOT NULL COMMENT '所属设计方案 id，外键',
    `design_room_id` INT NOT NULL COMMENT '设计方案房间 id，外键',
    user_id INT NOT NULL COMMENT '用户 id 外键',
    `design_material_number` VARCHAR(256) NOT NULL COMMENT '材料编号',
    `design_material_name` VARCHAR(256) NOT NULL COMMENT '材料名称',
    `goods_id` INT NOT NULL COMMENT '商品 id，外键',
    `products_id` INT NOT NULL COMMENT '货品 id，外键',
    `products_num` INT NOT NULL DEFAULT 0 COMMENT '商品数量',
    `designer_content` VARCHAR(256)  NULL COMMENT '设计师备注',
    design_material_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户的设计方案材料表';


###########
#   数据插入
###########

INSERT INTO `wm_user` (`user_id`, `user_name`, `user_passwd`,`designer_sn`, `user_tel`, `user_sex`, `house_type_id`, `user_avatar`, `is_special`, `birthday`, `user_show`) VALUES
(1, 'mwplll', MD5('123456'), 1,'13732256615', 0, 1, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0,  '1990-02-02', ''),
(2, 'zjd90', MD5('123456'), 2,'13732234234', 0, 2, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0,  '1988-04-03', ''),
(3, 'yinjia', MD5('yingjia'), 600,'13958109779', 2, NULL, NULL, 10,  NULL, NULL),
(7, '牟夏阳', '4d0fb811bbe735f475977dfb25654f73', 3,'13675864988', 2, NULL, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0, NULL, NULL),
(8, 'nickel.g', '58542360e3913f5de4321ad7a52ee53e',4, '13336122221', 2, NULL, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0, NULL, NULL),
(9, 'coolrain', '89588b5aa0e2117452c92455c88fd3bd',5, '13905711833', 0, 9, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0, '0000-00-00', ''),
(12, '史志鹏', '31c9847f64410263505a187debbf310b',6, '13895770604', 2, NULL, NULL, 0, NULL, NULL),
(13, '朱华华', '91d83fe2ad520194eab705810bc31adf',7, '15158129389', 2, NULL, NULL, 0, NULL, NULL),
(15, 'foursking', '258a55e0bd4c673513faddcfc3bf94a3',8, '15044442222', 0, NULL, '', 0, '2014-02-03', 'sadasdad'),
(16, 'Sxz88659361', '3b4affdc01f8ddf6341e5d46caff2b11',9, '18267027129', 2, NULL, NULL, 0, NULL, NULL),
(18, 'Joey.Yu', '597ed292db15d51445e17ea657f1d9fd', 10,'18757159772', 1, NULL, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0, '1991-07-14', ''),
(19, '晓寒', '749d864c0d59df7f2bcd34fc6a76b996', 11,'15858155086', 0, NULL, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0, '1992-02-15', ''),
(20, '洪旭红', '2d33099d49b293c40f6141d5c07b2b24', 12,'13605709604', 0, NULL, '/user/avator/cc7e3e0bd6e833d98a277c37e053f441.jpg', 0, '1990-05-31', '德厚载物'),
(24, 'MISS', '3bb9d6ccc157508a48053fcc8ed9f535', 13,'13675896096', 2, NULL, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0, NULL, NULL),
(29, 'hzdamei', '05b35faa11931a6af88478fab9723278',14, '15605710597', 2, NULL, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0, NULL, NULL),
(30, '施献峰', '84426f427e7aca01e48db80eb79ea096',15, '18868803222', 2, NULL, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 1, NULL, NULL),
(31, '阿牛', 'c91f5ca8ccee37515a7f32fc4e759ab4', 16,'13735561858', 2, NULL, '/user/avator/f231a42afc9269ffdca316d41328d221.jpg', 0, NULL, NULL);
