-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- ȣ��Ʈ: localhost
-- ó���� �ð�: 16-09-02 14:41 
-- ���� ����: 5.1.41
-- PHP ����: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- �����ͺ��̽�: `ssh_db`
--

-- --------------------------------------------------------

--
-- ���̺� ���� `mydesk`
--

CREATE TABLE IF NOT EXISTS `mydesk` (
  `desk_num` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `content` text,
  `file_name` varchar(255) NOT NULL,
  `file_thumb` varchar(255) NOT NULL,
  `file_copied` varchar(255) NOT NULL,
  `vote_good` int(11) NOT NULL DEFAULT '0',
  `regist_day` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`desk_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- ���̺� ���� `reply`
--

CREATE TABLE IF NOT EXISTS `reply` (
  `reply_num` int(11) NOT NULL AUTO_INCREMENT,
  `desk_num` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `regist_day` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reply_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- ���̺� ���� `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_num` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `regist_day` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`),
  KEY `user_num` (`user_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- ���̺� ���� `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `vote_num` int(11) NOT NULL AUTO_INCREMENT,
  `desk_num` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `ip_id` varchar(255) NOT NULL,
  `regist_day` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`vote_num`),
  KEY `desk_num` (`desk_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
