-- phpMyAdmin SQL Dump
-- version 2.11.5.1
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 17-08-31 13:41 
-- 서버 버전: 5.1.45
-- PHP 버전: 5.2.17p1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 데이터베이스: `jaeyong1`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `tb_remote`
--

DROP TABLE IF EXISTS `tb_remote`;
CREATE TABLE IF NOT EXISTS `tb_remote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tm` datetime DEFAULT NULL,
  `command` varchar(50) DEFAULT NULL,
  `state` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='remote table for garden' AUTO_INCREMENT=62 ;

--
-- 테이블의 덤프 데이터 `tb_remote`
--

INSERT INTO `tb_remote` (`id`, `tm`, `command`, `state`) VALUES
(1, '2017-07-17 22:51:28', 'fan 10 min', 'ok'),
(2, '2017-07-17 23:01:35', 'lamp on', 'ok'),
(3, '2017-07-17 23:56:29', 'fan 5 min', 'ok'),
(4, '2017-07-19 00:02:17', 'Lamp on', 'ok'),
(5, '2017-07-19 00:16:04', 'Fan OFF', 'ok'),
(6, '2017-07-19 00:23:22', 'Fan On 10Min', 'ok'),
(7, '2017-07-19 00:24:06', 'Fan On 10Min', 'ok'),
(8, '2017-07-19 00:24:10', 'Fan OFF', 'ok'),
(9, '2017-07-19 00:24:36', 'Fan OFF', 'ok'),
(10, '2017-07-19 00:25:07', 'Fan On 10Min', 'ok'),
(11, '2017-07-19 00:26:15', 'Lamp On', 'ok'),
(12, '2017-07-19 00:26:19', 'Lamp Off', 'ok'),
(13, '2017-07-19 00:27:15', 'Fan On 10Min', 'ok'),
(14, '2017-07-19 00:28:20', 'Fan On', 'ok'),
(15, '2017-07-19 00:28:25', 'Fan OFF', 'ok'),
(16, '2017-07-19 00:29:50', 'Fan On 10Min', 'ok'),
(17, '2017-07-26 23:58:45', 'Lamp On', 'ok'),
(18, '2017-07-26 23:59:07', 'Lamp Off', 'ok'),
(19, '2017-07-26 23:59:32', 'Fan On', 'ok'),
(20, '2017-07-26 23:59:51', 'Fan OFF', 'ok'),
(21, '2017-07-27 00:29:33', 'Fan On', 'ok'),
(22, '2017-07-27 00:45:04', 'Lamp On', 'ok'),
(23, '2017-07-27 00:45:31', 'Lamp Off', 'ok'),
(24, '2017-07-27 20:23:12', 'Fan On', 'ok'),
(25, '2017-07-27 20:23:15', 'Lamp On', 'ok'),
(26, '2017-07-27 20:42:19', 'Lamp On', 'ok'),
(27, '2017-07-27 20:42:21', 'Fan On', 'ok'),
(28, '2017-07-27 20:42:27', 'Fan OFF', 'ok'),
(29, '2017-07-27 20:50:24', 'Lamp Off', 'ok'),
(30, '2017-07-27 20:50:31', 'Fan OFF', 'ok'),
(31, '2017-07-28 06:39:00', 'Lamp On', 'ok'),
(32, '2017-07-28 06:39:05', 'Lamp Off', 'ok'),
(33, '2017-07-29 00:23:01', 'Lamp On', 'ok'),
(34, '2017-07-29 01:04:42', 'Lamp On', 'ok'),
(35, '2017-07-29 01:05:00', 'Lamp Off', 'ok'),
(36, '2017-07-29 10:33:47', 'Lamp On', 'ok'),
(37, '2017-08-29 13:38:38', 'Lamp On', 'ok'),
(38, '2017-08-29 14:34:56', 'Lamp On', 'ok'),
(39, '2017-08-29 14:36:43', 'Lamp On', 'ok'),
(40, '2017-08-29 14:36:48', 'Lamp On', 'ok'),
(41, '2017-08-29 14:39:47', 'Lamp On', 'ok'),
(42, '2017-08-29 14:40:08', 'Lamp On', 'ok'),
(43, '2017-08-29 14:40:30', 'Lamp On', 'ok'),
(44, '2017-08-29 14:40:46', 'Lamp On', 'ok'),
(45, '2017-08-29 14:40:57', 'Lamp On', 'ok'),
(46, '2017-08-29 14:41:05', 'Lamp On', 'ok'),
(47, '2017-08-29 14:41:15', 'Lamp On', 'ok'),
(48, '2017-08-29 14:41:38', 'Lamp Off', 'ok'),
(49, '2017-08-29 14:41:54', 'Lamp Off', 'ok'),
(50, '2017-08-29 14:41:58', 'Lamp On', 'ok'),
(51, '2017-08-29 14:42:03', 'Lamp On', 'ok'),
(52, '2017-08-29 14:45:50', 'Fan On', 'ok'),
(53, '2017-08-29 14:47:52', 'Fan OFF', 'ok'),
(54, '2017-08-29 14:48:06', 'Fan OFF', 'ok'),
(55, '2017-08-29 15:17:17', 'Lamp On', 'ok'),
(56, '2017-08-29 15:17:49', 'Lamp On', 'ok'),
(57, '2017-08-29 15:19:45', 'Lamp Off', 'ok'),
(58, '2017-08-30 13:52:08', 'Lamp On', 'ok'),
(59, '2017-08-30 14:40:25', 'Lamp Off', 'ok'),
(60, '2017-08-30 14:43:25', 'Fan On', 'ok'),
(61, '2017-08-30 17:42:57', 'Lamp On', 'ok');

-- --------------------------------------------------------

--
-- 테이블 구조 `tb_remote_garden_now`
--

DROP TABLE IF EXISTS `tb_remote_garden_now`;
CREATE TABLE IF NOT EXISTS `tb_remote_garden_now` (
  `tm` datetime DEFAULT NULL,
  `lamp` int(11) DEFAULT NULL,
  `fan` int(11) DEFAULT NULL,
  `humidity` int(11) DEFAULT NULL,
  `temperature` int(11) DEFAULT NULL,
  `reserved1` varchar(10) DEFAULT NULL,
  `reserved2` varchar(10) DEFAULT NULL,
  `reserved3` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `tb_remote_garden_now`
--

INSERT INTO `tb_remote_garden_now` (`tm`, `lamp`, `fan`, `humidity`, `temperature`, `reserved1`, `reserved2`, `reserved3`) VALUES
('2017-08-30 17:43:00', 1, 1, 30, 40, 'a', 'b', 'c');
