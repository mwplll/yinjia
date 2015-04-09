-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 04 月 03 日 19:38
-- 服务器版本: 5.5.40
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `iwebshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `iwebshop_delivery`
--

CREATE TABLE IF NOT EXISTS `iwebshop_delivery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '快递名称',
  `description` varchar(50) DEFAULT NULL COMMENT '快递描述',
  `area_groupid` text COMMENT '配送区域id',
  `firstprice` text COMMENT '配送地址对应的首重价格',
  `secondprice` text COMMENT '配送地区对应的续重价格',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '配送类型 0先付款后发货 1先发货后付款',
  `first_weight` int(11) unsigned NOT NULL COMMENT '首重重量(克)',
  `second_weight` int(11) unsigned NOT NULL COMMENT '续重重量(克)',
  `first_price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '首重价格',
  `second_price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '续重价格',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启状态',
  `sort` smallint(5) NOT NULL DEFAULT '99' COMMENT '排序',
  `is_save_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持物流保价 1支持保价 0  不支持保价',
  `save_rate` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '保价费率',
  `low_price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '最低保价',
  `price_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '费用类型 0统一设置 1指定地区费用',
  `open_default` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用默认费用 1启用 0 不启用',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 0:未删除 1:删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配送方式表' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `iwebshop_delivery_doc`
--

CREATE TABLE IF NOT EXISTS `iwebshop_delivery_doc` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '发货单ID',
  `order_id` int(11) unsigned NOT NULL COMMENT '订单ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `admin_id` int(11) unsigned NOT NULL COMMENT '管理员ID',
  `seller_id` int(11) unsigned DEFAULT '0' COMMENT '商户ID',
  `name` varchar(255) NOT NULL COMMENT '收货人',
  `postcode` varchar(6) DEFAULT NULL COMMENT '邮编',
  `telphone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `country` int(11) unsigned DEFAULT NULL COMMENT '国ID',
  `province` int(11) unsigned NOT NULL COMMENT '省ID',
  `city` int(11) unsigned NOT NULL COMMENT '市ID',
  `area` int(11) unsigned NOT NULL COMMENT '区ID',
  `address` varchar(250) NOT NULL COMMENT '收货地址',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `time` datetime NOT NULL COMMENT '创建时间',
  `freight` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `delivery_code` varchar(255) NOT NULL COMMENT '物流单号',
  `delivery_type` varchar(255) NOT NULL COMMENT '物流方式',
  `note` text COMMENT '管理员添加的备注信息',
  `if_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未删除 1:已删除',
  `freight_id` int(11) unsigned NOT NULL COMMENT '货运公司ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='发货单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `iwebshop_order`
--

CREATE TABLE IF NOT EXISTS `iwebshop_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `pay_type` int(11) NOT NULL COMMENT '支付方式ID,当为0时表示货到付款',
  `distribution` int(11) DEFAULT NULL COMMENT '配送ID',
  `status` tinyint(1) DEFAULT '1' COMMENT '订单状态 1生成订单,2支付订单,3取消订单,4作废订单,5完成订单',
  `pay_status` tinyint(1) DEFAULT '0' COMMENT '支付状态 0：未支付，1：已支付，2：退款',
  `distribution_status` tinyint(1) DEFAULT '0' COMMENT '配送状态 0：未发送,1：已发送,2：部分发送',
  `accept_name` varchar(20) NOT NULL COMMENT '收货人姓名',
  `postcode` varchar(6) DEFAULT NULL COMMENT '邮编',
  `telphone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `country` int(11) DEFAULT NULL COMMENT '国ID',
  `province` int(11) DEFAULT NULL COMMENT '省ID',
  `city` int(11) DEFAULT NULL COMMENT '市ID',
  `area` int(11) DEFAULT NULL COMMENT '区ID',
  `address` varchar(250) DEFAULT NULL COMMENT '收货地址',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `payable_amount` decimal(15,2) DEFAULT '0.00' COMMENT '应付商品总金额',
  `real_amount` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '实付商品总金额',
  `payable_freight` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '总运费金额',
  `real_freight` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '实付运费',
  `pay_time` datetime DEFAULT NULL COMMENT '付款时间',
  `send_time` datetime DEFAULT NULL COMMENT '发货时间',
  `create_time` datetime DEFAULT NULL COMMENT '下单时间',
  `completion_time` datetime DEFAULT NULL COMMENT '订单完成时间',
  `invoice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发票：0不索要1索要',
  `postscript` varchar(255) DEFAULT NULL COMMENT '用户附言',
  `note` text COMMENT '管理员备注',
  `if_del` tinyint(1) DEFAULT '0' COMMENT '是否删除1为删除',
  `insured` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '保价',
  `if_insured` tinyint(1) DEFAULT '0' COMMENT '是否保价0:不保价，1保价',
  `pay_fee` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '支付手续费',
  `invoice_title` varchar(100) DEFAULT NULL COMMENT '发票抬头',
  `taxes` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '税金',
  `promotions` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '促销优惠金额',
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '订单折扣或涨价',
  `order_amount` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `if_print` varchar(255) DEFAULT NULL COMMENT '已打印的类型,类型的代码以逗号进行分割; shop购物单,pick配货单,merge购物和配货,express快递单',
  `prop` varchar(255) DEFAULT NULL COMMENT '使用的道具id',
  `accept_time` varchar(80) DEFAULT NULL COMMENT '用户收货时间',
  `exp` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '增加的经验',
  `point` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '增加的积分',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0普通订单,1团购订单,2限时抢购',
  `trade_no` varchar(255) DEFAULT NULL COMMENT '支付平台交易号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `iwebshop_order_goods`
--

CREATE TABLE IF NOT EXISTS `iwebshop_order_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL COMMENT '订单ID',
  `goods_id` int(11) unsigned DEFAULT NULL COMMENT '商品ID',
  `img` varchar(255) NOT NULL COMMENT '商品图片',
  `product_id` int(11) DEFAULT NULL COMMENT '货品ID',
  `goods_price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `real_price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '实付金额',
  `goods_nums` int(11) NOT NULL DEFAULT '1' COMMENT '商品数量',
  `goods_weight` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '重量',
  `goods_array` text COMMENT '商品和货品名称name和规格value串json数据格式',
  `is_send` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已发货 0:未发货;1:已发货',
  `is_checkout` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否给商家结算货款 0:未结算;1:已结算',
  `delivery_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送ID',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单商品表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `iwebshop_order_log`
--

CREATE TABLE IF NOT EXISTS `iwebshop_order_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `user` varchar(20) DEFAULT NULL COMMENT '操作人：顾客或admin或seller',
  `action` varchar(20) DEFAULT NULL COMMENT '动作',
  `addtime` datetime DEFAULT NULL COMMENT '添加时间',
  `result` varchar(10) DEFAULT NULL COMMENT '操作的结果',
  `note` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单日志表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `iwebshop_order_prop_relation`
--

CREATE TABLE IF NOT EXISTS `iwebshop_order_prop_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned DEFAULT NULL COMMENT '订单ID',
  `prop_id` int(11) unsigned DEFAULT NULL COMMENT '道具ID',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户ID',
  `create_time` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单与道具表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `iwebshop_payment`
--

CREATE TABLE IF NOT EXISTS `iwebshop_payment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '支付名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:线上、2:线下',
  `class_name` varchar(50) NOT NULL COMMENT '支付类名称',
  `description` text COMMENT '描述',
  `logo` varchar(255) NOT NULL COMMENT '支付方式logo图片路径',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '安装状态 0启用 1禁用',
  `order` smallint(5) NOT NULL DEFAULT '99' COMMENT '排序',
  `note` text COMMENT '支付说明',
  `poundage` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `poundage_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '手续费方式 1百分比 2固定值',
  `config_param` text COMMENT '配置参数,json数据对象',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='支付方式表' AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
