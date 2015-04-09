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
DROP TABLE IF EXISTS `wm_design_pic`;
DROP TABLE if EXISTS `wm_design_schema`;
DROP TABLE if EXISTS `wm_design_cad`;
DROP TABLE if EXISTS `wm_design_room`;
DROP TABLE if EXISTS `wm_design_material`;
DROP TABLE if EXISTS `wm_design_comment`;
DROP TABLE if EXISTS `wm_design_style`;
DROP TABLE IF EXISTS `wm_building`;
DROP TABLE IF EXISTS `wm_company`;
DROP TABLE IF EXISTS `wm_house_type`;
DROP TABLE IF EXISTS `wm_city`;
DROP TABLE IF EXISTS `wm_manual`;

--
-- 表的结构 `wm_house_type`
--

CREATE TABLE IF NOT EXISTS `wm_house_type` (
    `house_type_id` INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局户型ID',
    `house_number` VARCHAR(20) NOT NULL default '0' COMMENT '户型编号',
    `house_type_name` VARCHAR(50) NOT NULL COMMENT '户型名称',
    `building_id` INT  NOT NULL DEFAULT 1 COMMENT '楼盘ID， 外键',
    `pic` TEXT NOT NULL COMMENT '户型图地址',
    `design_num` INT NOT NULL DEFAULT 0 COMMENT '关联的设计图数量',
    `usable_area` DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT '可使用面积',
    `gross_area` DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT '建筑面积',
    `house_del` INT(6) NOT NULL DEFAULT 0 COMMENT '是否有效，0代表正常，1代表删除，2代表前台不显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='户型基本信息表';

CREATE TABLE IF NOT EXISTS `wm_building` (
    `building_id` INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '楼盘全局ID',
    `city_id` INT(6) NOT NULL  COMMENT '所在城市ID',
    `area_id` INT(6) NOT NULL  COMMENT '所在区域ID',
    `building_del` TINYINT(6) NOT NULL default 0 COMMENT '是否有效，0代表正常，1代表删除',
    `building_recommend` TINYINT(6) NOT NULL default 0 COMMENT '是否在首页推荐，0为否，1为是',
    `company_id` INT(11) NOT NULL  COMMENT '所属的房产公司ID',
    `building_name` VARCHAR(20) NOT NULL  COMMENT '楼盘名称',
    `total_design_num` INT NOT NULL DEFAULT 0  COMMENT '该楼盘总的设计方案数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='户型地址信息表';


CREATE TABLE IF NOT EXISTS `wm_city` (
    `city_id` INT(6) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局城市ID,为6位的全国唯一编码',
    `prov_name` VARCHAR(10) NOT NULL  COMMENT '所在省份名称',
    `city_name` VARCHAR(10) NOT NULL  COMMENT '所在城市名称',
    `manual_coe` DECIMAL(10,2) NOT NULL DEFAULT 1.00 COMMENT '城市施工系数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='城市表';


CREATE TABLE IF NOT EXISTS `wm_company` (
    `company_id` INT(6) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '开发商全局ID',
    `company_name`VARCHAR(10) NOT NULL  COMMENT '开发商名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='房地产开发商表';


CREATE TABLE IF NOT EXISTS `wm_design_schema` (
    `design_schema_id` INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局设计图ID',
    `design_name` VARCHAR(256) NOT NULL COMMENT '设计方案名',
    `design_sn` INT(10) NOT NULL COMMENT '设计方案编号',
    `design_content` TEXT NOT NULL COMMENT '设计简要说明',
    `house_type_id` INT NOT NULL COMMENT '关联的户型图 id',
    `view_num` INT NOT NULL DEFAULT 0 COMMENT '浏览量',
    `like_num` INT NOT NULL DEFAULT 0 COMMENT '喜欢量',
    `comment_num` INT NOT NULL DEFAULT 0 COMMENT '评论数',
    `design_price` DECIMAL(15,2)  NOT NULL COMMENT '设计费(0.01元)',
    `design_deposit` DECIMAL(15,2) NOT NULL COMMENT '订金（0.01元）',
    `estimate_price` DECIMAL(15,2) NOT NULL COMMENT '装修预估均价（0.01元/㎡)',
    `total_price` DECIMAL(15,2) NOT NULL COMMENT '装修总价（0.01元）',
    `user_id` INT NOT NULL COMMENT '设计师用户 id',
    `design_style_id` INT NOT NULL COMMENT '设计方案风格 id',
    `matl_price` DECIMAL(15,2) NOT NULL COMMENT '建材费(0.01元)',
    `cons_price` DECIMAL(15,2) NOT NULL COMMENT '施工费(0.01元)',
    # mysql 默认表的第一个timestamp 字段为 not null current_timestamp on update current_timestamp
    # 必须显示定义改变这种行为或者将需要自动更新的提前
    `create_time` INT(11) NOT NULL COMMENT '创建时间',
    `modify_time` INT(11) NOT NULL COMMENT '最后修改时间',
    `main_pic` TEXT NOT NULL COMMENT '设计方案主图URL',
    `cad_file` TEXT NULL COMMENT '设计方案施工图工程文件地址',
    `fail_reason` TEXT NULL COMMENT '审核失败原因',
    `design_schema_recommend` INT(6) NOT NULL default 0 COMMENT '是否在首页推荐，0为否，1为是',
    design_schema_del TINYINT(11) NOT NULL DEFAULT 2 COMMENT '是否删除，0为正常上架（审核通过），1为删除,2为待审核，3为下架，4为审核失败'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案总信息表';


CREATE TABLE IF NOT EXISTS `wm_design_pic` (
    `design_pic_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '效果图全局Id',
    `design_schema_id` INT NOT NULL COMMENT '所属设计方案 id',
    `design_pic` VARCHAR(256) NOT NULL COMMENT '设计图片原始URL',
    `room_name` VARCHAR(256) NOT NULL COMMENT '房间名称',
    design_pic_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案效果图表';

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
    `design_room_type` TINYINT(11) NOT NULL DEFAULT 20 COMMENT '20为通用房间，1为客厅，2为餐厅，3为主卧，4为老人房，5为儿童房，6为书房，7为厨房，8为主卫，9为次卫，10为洗衣阳台，11为阳台',
    `design_room_del` TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案房间表';

CREATE TABLE IF NOT EXISTS `wm_design_material` (
    `design_material_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '设计方案材料全局Id',
    `design_schema_id` INT NOT NULL COMMENT '所属设计方案 id，外键',
    `design_room_id` INT NOT NULL COMMENT '设计方案房间 id，外键',
    `design_material_number` VARCHAR(256) NOT NULL COMMENT '材料编号',
    `design_material_name` VARCHAR(256) NOT NULL COMMENT '材料名称',
    `goods_id` INT NOT NULL COMMENT '商品 id，外键',
    `products_id` INT NOT NULL COMMENT '货品 id，外键',
    `products_num` INT NOT NULL DEFAULT 0 COMMENT '商品数量',
    `designer_content` VARCHAR(256)  NULL COMMENT '设计师备注',
    design_material_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案材料表';

CREATE TABLE IF NOT EXISTS `wm_manual` (
    `manual_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '施工价格全局Id',
    `design_style_id` INT NOT NULL COMMENT '设计方案风格 id，外键',
    `manual_name` VARCHAR(256) NOT NULL COMMENT '施工类目名称',
    `manual_price` DECIMAL(15,2) NOT NULL COMMENT '施工类目单价（0.01元）',
    manual_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='施工表';

CREATE TABLE IF NOT EXISTS `wm_design_style` (
    `design_style_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '设计方案风格全局Id',
    `design_style_name` VARCHAR(256) NOT NULL COMMENT '风格名称名称',
    design_style_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，默认为0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案风格表';

CREATE TABLE IF NOT EXISTS wm_design_comment (
    design_comment_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '设计方案评价全局id',
    design_schema_id INT(11) NOT NULL  COMMENT '设计方案id，外键',
    user_id INT(11) NOT NULL  COMMENT '用户id，外键',
    comment_time INT(11) NOT NULL  COMMENT '评论时间',
    point INT(11) NOT NULL DEFAULT 5 COMMENT '用户评分',
    content TEXT NOT NULL  COMMENT '评论内容',
    design_comment_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，默认为0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计方案评论信息表';

#####################
# Define foreign keys
#####################






