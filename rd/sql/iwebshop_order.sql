-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 03 月 30 日 21:37
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
