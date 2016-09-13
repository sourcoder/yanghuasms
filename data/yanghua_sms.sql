-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-09-13 19:35:47
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yanghua_sms`
--

-- --------------------------------------------------------

--
-- 表的结构 `sms_contacts`
--

CREATE TABLE IF NOT EXISTS `sms_contacts` (
  `id` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `groups` varchar(100) NOT NULL,
  `extra` varchar(200) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sms_contacts`
--

INSERT INTO `sms_contacts` (`id`, `name`, `tel`, `groups`, `extra`, `time`) VALUES
('71421be9-6ba4-11e6-b942-448a5b462df3', '张三', '18602840143', '48971673-6ba4-11e6-b942-448a5b462df3', '', '2016-08-26 23:47:50'),
('71423c2c-6ba4-11e6-b942-448a5b462df3', '李四', '18602840143', '48971673-6ba4-11e6-b942-448a5b462df3', '', '2016-08-26 23:47:50');

-- --------------------------------------------------------

--
-- 表的结构 `sms_group`
--

CREATE TABLE IF NOT EXISTS `sms_group` (
  `id` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `app` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sms_group`
--

INSERT INTO `sms_group` (`id`, `name`, `organization`, `time`, `app`) VALUES
('48971673-6ba4-11e6-b942-448a5b462df3', '主编团', '3be157bd-6b6a-11e6-b942-448a5b462df3', '2016-08-26 23:46:42', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sms_organization`
--

CREATE TABLE IF NOT EXISTS `sms_organization` (
  `id` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `admin` varchar(100) NOT NULL,
  `invite` varchar(20) NOT NULL,
  `rest` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sms_organization`
--

INSERT INTO `sms_organization` (`id`, `name`, `admin`, `invite`, `rest`, `time`) VALUES
('3be157bd-6b6a-11e6-b942-448a5b462df3', '扬华E媒体', 'a2a65c27-6c21-11e6-b942-448a5b462df3', '12345678', 100, '2016-08-26 16:51:09');

-- --------------------------------------------------------

--
-- 表的结构 `sms_send`
--

CREATE TABLE IF NOT EXISTS `sms_send` (
  `id` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `content` varchar(200) NOT NULL,
  `sendlog` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sms_send`
--

INSERT INTO `sms_send` (`id`, `contact`, `content`, `sendlog`, `status`, `time`) VALUES
('5c6ec6ba-6ba5-11e6-b942-448a5b462df3', '71421be9-6ba4-11e6-b942-448a5b462df3', '张三同学你好！', 'e3ac37d8-6ba4-11e6-b942-448a5b462df3', 1, '2016-08-26 23:54:25'),
('957cfe3e-6ba5-11e6-b942-448a5b462df3', '71423c2c-6ba4-11e6-b942-448a5b462df3', '李四同学你不好！', 'e3ac37d8-6ba4-11e6-b942-448a5b462df3', 1, '2016-08-26 23:56:01');

-- --------------------------------------------------------

--
-- 表的结构 `sms_sendlog`
--

CREATE TABLE IF NOT EXISTS `sms_sendlog` (
  `id` varchar(100) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `app` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sms_sendlog`
--

INSERT INTO `sms_sendlog` (`id`, `organization`, `app`, `user`, `time`) VALUES
('e3ac37d8-6ba4-11e6-b942-448a5b462df3', '3be157bd-6b6a-11e6-b942-448a5b462df3', 1, '9148109b-6b6a-11e6-b942-448a5b462df3', '2016-08-26 23:51:02');

-- --------------------------------------------------------

--
-- 表的结构 `sms_user`
--

CREATE TABLE IF NOT EXISTS `sms_user` (
  `id` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `permission` varchar(100) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sms_user`
--

INSERT INTO `sms_user` (`id`, `username`, `password`, `name`, `tel`, `organization`, `permission`, `time`) VALUES
('5e1e31d0-6c3b-11e6-b942-448a5b462df3', 'test123', 'test1234', 'test1', '12312341234', '3be157bd-6b6a-11e6-b942-448a5b462df3', '60', '2016-08-27 17:48:15'),
('9148109b-6b6a-11e6-b942-448a5b462df3', 'catfish', 'liutianyu', '刘天宇', '18602840143', '3be157bd-6b6a-11e6-b942-448a5b462df3', '90', '2016-08-26 16:53:33'),
('a2a65c27-6c21-11e6-b942-448a5b462df3', 'admin', 'admin', '管理员', '18602840143', '3be157bd-6b6a-11e6-b942-448a5b462df3', '80', '2016-08-27 14:44:03'),
('f804c3f5-6c37-11e6-b942-448a5b462df3', 'test', 'test', 'test', '12312341234', '3be157bd-6b6a-11e6-b942-448a5b462df3', '60', '2016-08-27 17:23:56');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
