-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 06 月 10 日 12:54
-- 服务器版本: 5.0.22
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `ns_ting`
--
-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `wm_room`;
DROP TABLE IF EXISTS `wm_design_pic`;
DROP TABLE if EXISTS `wm_design_schema`;
DROP TABLE IF EXISTS `wm_building`;
DROP TABLE IF EXISTS `wm_company`;
DROP TABLE IF EXISTS `wm_house_type`;
DROP TABLE IF EXISTS `wm_city`;

--
-- 表的结构 `wm_house_type`
--

CREATE TABLE IF NOT EXISTS `wm_house_type` (
    `house_type_id` INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局户型ID',
    `house_number` VARCHAR(20) NOT NULL default '0' COMMENT '户型编号',
    `house_typename` VARCHAR(50) NOT NULL COMMENT '户型图名称',
    `building_id` INT  NOT NULL DEFAULT 1 COMMENT '楼盘ID， 外键',
    `pic` TEXT NOT NULL COMMENT '户型图地址',
    `design_num` INT NOT NULL DEFAULT 0 COMMENT '关联的设计图数量',
    `usable_area` VARCHAR(6) NOT NULL COMMENT '可使用面积',
    `gross_area` VARCHAR(6) NOT NULL COMMENT '建筑面积',
    `is_enable` INT(6) NOT NULL DEFAULT 1 COMMENT '是否有效，0代表假删除，1代表有效，前台显示，2代表无效，前台不显示'

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='户型基本信息表';

INSERT INTO `wm_house_type` (`house_number`,`house_typename`,`building_id`,`pic`, `design_num`, `usable_area`, `gross_area`) VALUES
    (
        'ZJHZ0001'
        ,'龙湖春江彼岸90㎡户型3室2厅1厨1卫'
        ,1
        ,'house/type/HZ_LH_CJBA_90A.jpg'
        ,1,'63.62','89.00'
    ),
    (
        'ZJHZ0002'
        ,'龙湖春江彼岸138㎡户型4室2厅1厨2卫'
        ,1
        ,'house/type/HZ_LH_CJBA_90A.jpg'
        ,3,'120','138'
    ),
    (
        'ZJHZ0001'
        ,'龙湖春江彼岸190㎡户型5室2厅1厨2卫'
        ,1
        ,'house/type/HZ_LH_CJBA_90A.jpg'
        ,1,'168','195.00'
    );

CREATE TABLE IF NOT EXISTS `wm_building` (
    `building_id` INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '楼盘全局ID',
    `city_id`INT(6) NOT NULL  COMMENT '所在城市ID',
    `area_id`INT(6) NOT NULL  COMMENT '所在区域ID',
    `building_del`INT(6) NOT NULL default 0 COMMENT '是否删除，0代表正常，1代表删除',
    `company_id`VARCHAR(20) NOT NULL  COMMENT '所属的房产公司ID',
    `building_name`VARCHAR(20) NOT NULL  COMMENT '楼盘名称',
    `total_design_num`INT NOT NULL DEFAULT 0  COMMENT '该楼盘总的设计方案数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='户型地址信息表';

######################
# insert wm_building
######################
INSERT INTO wm_building (building_id,city_id,area_id,company_id,building_name,total_design_num) VALUES
    (1,330100,330127,1,'春江彼岸',5),
    (2,330100,330127,1,'老和山别院',4),
    (3,330100,330108,1,'千岛龙庭',3),
    (4,330200,330282,1,'哈哈哈',2);


CREATE TABLE IF NOT EXISTS `wm_city` (
    `city_id` INT(6) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局城市ID,为6位的全国唯一编码',
    `prov_name`VARCHAR(10) NOT NULL  COMMENT '所在省份名称',
    `city_name`VARCHAR(10) NOT NULL  COMMENT '所在城市名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='城市表';

######################
# insert wm_city
######################
INSERT INTO wm_city (city_id,prov_name,city_name) VALUES
    (330100,'浙江', '杭州'),
    (330500,'浙江', '湖州'),
    (330400,'浙江', '嘉兴'),
    (330700,'浙江', '金华'),
    (331100,'浙江', '丽水'),
    (330200,'浙江', '宁波'),
    (330800,'浙江', '衢州'),
    (330600,'浙江', '绍兴'),
    (331000,'浙江', '台州'),
    (330300,'浙江', '温州'),
    (330900,'浙江', '舟山');


CREATE TABLE IF NOT EXISTS `wm_company` (
    `company_id` INT(6) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '开发商全局ID',
    `company_name`VARCHAR(10) NOT NULL  COMMENT '开发商名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房地产开发商表';

######################
# insert wm_company
######################
INSERT INTO wm_company (company_id,company_name) VALUES
    (1,'龙湖');

CREATE TABLE IF NOT EXISTS `wm_design_schema` (
    `design_schema_id` INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局设计图ID',
    `design_name` VARCHAR(256) NOT NULL COMMENT '设计方案名',
    `design_sn` VARCHAR(256) NOT NULL COMMENT '设计方案编号',
    `design_content` TEXT NOT NULL COMMENT '设计简要说明',
    `house_type_id` INT NOT NULL COMMENT '关联的户型图 id',
    `view_num` INT NOT NULL DEFAULT 0 COMMENT '浏览量',
    `like_num` INT NOT NULL DEFAULT 0 COMMENT '喜欢量',
    `comment_num` INT NOT NULL DEFAULT 0 COMMENT '评论数',
    `design_price` DECIMAL(15,2)  NOT NULL COMMENT '设计费(0.01元)',
    `design_deposit` DECIMAL(15,2) NOT NULL COMMENT '订金（0.01元）',
    `estimate_price` DECIMAL(15,2) NOT NULL COMMENT '装修预估均价（0.01元/㎡）',
    `total_price` DECIMAL(15,2) NOT NULL COMMENT '装修总价（0.01元）',
    `designer_id` INT NOT NULL COMMENT '设计师用户 id',
    `matl_price` DECIMAL(15,2) NOT NULL COMMENT '建材费(0.01元)',
    `cons_price` DECIMAL(15,2) NOT NULL COMMENT '施工费(0.01元)',
    # mysql 默认表的第一个timestamp 字段为 not null current_timestamp on update current_timestamp
    # 必须显示定义改变这种行为或者将需要自动更新的提前
    `create_time` INT(11) NOT NULL COMMENT '创建时间',
    `modify_time` INT(11) NOT NULL COMMENT '最后修改时间',
    `main_pic` TEXT NOT NULL COMMENT '设计方案主图URL',
    `cad_file` TEXT NULL COMMENT '设计方案施工图工程文件地址',
    design_schema_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常上架，1为删除,2为待审核，3为下架'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案总信息表';


######################
# insert design schema
######################
INSERT INTO wm_design_schema
    (design_schema_id,design_name,design_sn,house_type_id, view_num,like_num,comment_num,design_price, design_deposit,estimate_price,designer_id,main_pic)
     VALUES
    (1,'我是方案名称最多20个字0','HZ_LH_CJBA_90A',1,12,6,0,60,12,876,1,'design/room/HZ_LH_CJBA_90A_KT.jpg'),
    (2,'我是方案名称最多20个字1','HZ_LH_CJBA_138A',2,20,15,0,80,20,1200,2,'design/room/HZ_LH_CJBA_138A_ZW.jpg'),
    (4,'我是方案名称最多20个字2','HZ_LH_CJBA_138B',2,28,15,0,80,20,1180,2,'design/room/HZ_LH_CJBA_138B_KT.jpg'),
    (5,'我是方案名称最多20个字3','HZ_LH_CJBA_138C',2,22,15,0,100,20,1500,2,'design/room/HZ_LH_CJBA_138C_KT.jpg'),
    (3,'我是方案名称最多20个字4','HZ_LH_CJBA_190A',3,35,18,0,80,20,1800,3,'design/room/HZ_LH_CJBA_190A_CT.jpg');

CREATE TABLE IF NOT EXISTS `wm_design_pic` (
    `design_pic_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '效果图全局Id',
    `design_schema_id` INT NOT NULL COMMENT '所属设计方案 id',
    `design_pic` VARCHAR(256) NOT NULL COMMENT '设计图片原始URL',
    `room_name` VARCHAR(256) NOT NULL COMMENT '房间名称',
    design_pic_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案效果图表';

#######################
# insert wm_design_pic
#######################
INSERT INTO wm_design_room (design_pic_id, design_pic,room_name) VALUES
    (1, 'design/room/HZ_LH_CJBA_90A_CT.jpg', '客厅'),
    (1, 'design/room/HZ_LH_CJBA_90A_KT.jpg', '客厅'),
    (1, 'design/room/HZ_LH_CJBA_90A_WS.jpg', '客厅'),
    (2, 'design/room/HZ_LH_CJBA_138A_ZW.jpg', '客厅'),
    (2, 'design/room/HZ_LH_CJBA_138A_CT.jpg', '客厅'),
    (2, 'design/room/HZ_LH_CJBA_138A_KT.jpg', '客厅'),
    (3, 'design/room/HZ_LH_CJBA_190A_CT.jpg', '客厅'),
    (3, 'design/room/HZ_LH_CJBA_190A_KT.jpg', '客厅'),
    (4, 'design/room/HZ_LH_CJBA_138B_KT.jpg', '客厅'),
    (4, 'design/room/HZ_LH_CJBA_138B_ZW.jpg', '客厅'),
    (5, 'design/room/HZ_LH_CJBA_138C_KT.jpg', '客厅'),
    (5, 'design/room/HZ_LH_CJBA_138C_ZW.jpg', '客厅');

CREATE TABLE IF NOT EXISTS `wm_design_cad` (
    `design_cad_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '施工图全局Id',
    `design_schema_id` INT NOT NULL COMMENT '所属设计方案 id',
    `design_cad` VARCHAR(256) NOT NULL COMMENT '施工图URL',
    `cad_name` VARCHAR(256) NOT NULL COMMENT '施工图名称',
    design_cad_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案施工图表';

CREATE TABLE IF NOT EXISTS `wm_design_room` (
    `design_room_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '设计方案房间全局Id',
    `design_schema_id` INT NOT NULL COMMENT '所属设计方案 id，外键',
    `design_room_name` VARCHAR(256) NOT NULL COMMENT '房间名称',
    `design_room_area` DECIMAL(10,2) NOT NULL COMMENT '房间面积（0.01平方米）',
    `design_room_avg_price_` DECIMAL(10,2) NOT NULL COMMENT '房间材料单方均价（0.01元/平方米）',
    `design_room_total_price_` DECIMAL(10,2) NOT NULL COMMENT '房间材料总价（0.01元）',
    design_room_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案房间表';

CREATE TABLE IF NOT EXISTS `wm_design_material` (
    `design_material_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '设计方案材料全局Id',
    `design_schema_id` INT NOT NULL COMMENT '所属设计方案 id，外键',
    `design_room_id` INT NOT NULL COMMENT '设计方案房间 id，外键',
    `design_material_number` INT NOT NULL COMMENT '材料编号',
    `design_material_name` VARCHAR(256) NOT NULL COMMENT '材料名称',
    `goods_id` INT NOT NULL COMMENT '商品 id，外键',
    `goods_name` VARCHAR(256) NOT NULL COMMENT '商品名称',
    `goods_sell_price` DECIMAL(15,2) NOT NULL COMMENT '商品销售价格（0.01元）',
    `goods_num` INT NOT NULL DEFAULT 0 COMMENT '商品数量',
    `goods_unit` VARCHAR(20) NOT NULL COMMENT '商品单位',
    `goods_total_price` DECIMAL(15,2) NOT NULL COMMENT '商品总价（0.01元）',
    `designer_content` VARCHAR(256)  NULL COMMENT '设计师备注',
    design_material_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案材料表';

#####################
# Define foreign keys
#####################
#ALTER TABLE wm_room ADD CONSTRAINT fk_room_housetype FOREIGN KEY (house_type_id) REFERENCES wm_house_type (house_type_id);
ALTER TABLE wm_design_schema ADD CONSTRAINT fk_designschema_housetype FOREIGN KEY (house_type_id) REFERENCES
    wm_house_type (house_type_id);
ALTER TABLE wm_house_type ADD CONSTRAINT fk_housetype_addr FOREIGN KEY (building_id) REFERENCES
    wm_building (building_id);

#ALTER TABLE orderitems ADD CONSTRAINT fk_orderitems_products FOREIGN KEY (prod_id) REFERENCES products (prod_id);
#ALTER TABLE orders ADD CONSTRAINT fk_orders_customers FOREIGN KEY (cust_id) REFERENCES customers (cust_id);
#ALTER TABLE products ADD CONSTRAINT fk_products_vendors FOREIGN KEY (vend_id) REFERENCES vendors (vend_id);





