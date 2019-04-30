# Host: localhost  (Version: 5.5.53)
# Date: 2019-04-30 17:42:36
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "account"
#

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '用户密码',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `access` int(11) unsigned DEFAULT '0' COMMENT '用户权限',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `token` varchar(255) DEFAULT NULL COMMENT '验证秘钥',
  `updated_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `created_time` varchar(255) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户数据';

#
# Structure for table "chat"
#

DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL COMMENT '用户名',
  `context` varchar(255) DEFAULT NULL COMMENT '聊天信息',
  `streamname` varchar(255) DEFAULT NULL COMMENT '直播房间名称',
  `updated_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `created_time` varchar(255) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='聊天池';

#
# Structure for table "whitelist"
#

DROP TABLE IF EXISTS `whitelist`;
CREATE TABLE `whitelist` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `streamname` varchar(255) DEFAULT NULL COMMENT '直播流名称',
  `key` varchar(255) DEFAULT NULL COMMENT '直播流秘钥',
  `username` varchar(255) DEFAULT NULL COMMENT '用户名称',
  `title` varchar(255) DEFAULT '直播标题' COMMENT '直播标题',
  `stream_state` varchar(255) NOT NULL DEFAULT '0' COMMENT '是否开播[0:下播1:开播]',
  `aud_num` varchar(255) DEFAULT '0' COMMENT '观众人数',
  `updated_time` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `created_time` varchar(255) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='直播流白名单';
