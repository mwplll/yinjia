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

--
-- 表的结构 `ting_user_base_info`
--

CREATE TABLE IF NOT EXISTS `ting_user_base_info` (
  `ting_uid` bigint(20) unsigned NOT NULL default '0' COMMENT '全局UID',
  `nick` varchar(24) NOT NULL COMMENT '昵称',
  `sex` tinyint(4) NOT NULL default '0' COMMENT '性别，0女，1男，2人妖',
  `province_id` smallint(6) NOT NULL COMMENT '省会，关联addr_id',
  `province` char(10) NOT NULL COMMENT '冗余省会',
  `city_id` smallint(6) NOT NULL COMMENT '城市，关联addr_id',
  `city` char(10) NOT NULL COMMENT '冗余城市',
  `birth` date NOT NULL default '0000-00-00' COMMENT '用户生日',
  `email` varchar(100) NOT NULL COMMENT '用户邮箱',
  `email_active` tinyint(1) unsigned NOT NULL default '0' COMMENT '用户邮箱激活状态',
  UNIQUE KEY `ting_uid` (`ting_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户基本信息表';

--
-- 导出表中的数据 `ting_user_base_info`
--

INSERT INTO `ting_user_base_info` (`ting_uid`, `nick`, `sex`, `province_id`, `province`, `city_id`, `city`, `birth`, `email`, `email_active`) VALUES
(3805, '胡灵', 1, 0, '', 0, '', '1986-06-28', '', 0),
(3806, '周笔畅', 1, 0, '', 0, '', '1985-07-26', '', 0),
(3807, '柏栩栩', 0, 0, '', 0, '', '1980-03-30', '', 0),
(3808, '孙燕姿', 1, 0, '', 0, '', '1978-07-23', '', 0),
(3809, '苏醒', 0, 0, '', 0, '', '1984-03-05', '', 0),
(3810, '尚雯婕', 1, 0, '', 0, '', '1982-12-22', '', 0);
