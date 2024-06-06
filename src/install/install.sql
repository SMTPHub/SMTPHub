DROP TABLE IF EXISTS `pre_config`;
create table `pre_config` (
  `k` varchar(32) NOT NULL,
  `v` text NULL,
  PRIMARY KEY (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pre_config` VALUES ('version', '1004');
INSERT INTO `pre_config` VALUES ('db_version', '1004');
INSERT INTO `pre_config` VALUES ('admin_user', 'admin');
INSERT INTO `pre_config` VALUES ('admin_pwd', '123456');
INSERT INTO `pre_config` VALUES ('blackip', '');
INSERT INTO `pre_config` VALUES ('site_name', 'SMTPHub');
INSERT INTO `pre_config` VALUES ('site_logo', '/assets/img/logo.png');
INSERT INTO `pre_config` VALUES ('title', '程江统一邮件发送管理系统');
INSERT INTO `pre_config` VALUES ('keywords', '程江统一邮件发送管理系统,SMTP统一管理系统,SMTP统一管理平台,邮箱SMTP,邮件推送服务,SMTP API');
INSERT INTO `pre_config` VALUES ('description', '程江统一邮件发送管理系统，类似于邮件推送 API 服务，可实现同一个 SMTP 接口对接多个业务站点，多个业务站点可以统一调用本系统接口实现邮件发送。');
INSERT INTO `pre_config` VALUES ('ip_type', '0');
INSERT INTO `pre_config` VALUES ('address', '上海市杨浦区福宁路60号404室');
INSERT INTO `pre_config` VALUES ('email', 'jksdou@qq.com');
INSERT INTO `pre_config` VALUES ('kfqq', '350430869');

DROP TABLE IF EXISTS `pre_app`;
CREATE TABLE `pre_app` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '应用ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',
  `app_type` tinyint(1) NOT NULL COMMENT '应用类型',
  `app_name` varchar(128) NOT NULL COMMENT '应用名称',
  `app_from_name` varchar(32) DEFAULT NULL COMMENT '发信人名称',
  `app_secret` varchar(32) NOT NULL COMMENT '应用密钥',
  `smtp_id` int(11) NOT NULL DEFAULT '0' COMMENT 'SMTP服务ID',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  `updatetime` datetime DEFAULT NULL COMMENT '最后更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态:1启用0关闭',
  PRIMARY KEY (`id`),
  KEY `app_type` (`app_type`),
  KEY `smtp_id` (`smtp_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `pre_record`;
CREATE TABLE `pre_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',
  `appid` int(11) DEFAULT '0' COMMENT '应用ID',
  `smtp_id` varchar(11) NOT NULL COMMENT '服务ID',
  `mail_subject` varchar(50) DEFAULT NULL COMMENT '邮件主题',
  `mail_from` varchar(100) NOT NULL COMMENT '邮件发信人',
  `mail_to` varchar(100) NOT NULL COMMENT '邮件接收人',
  `mail_date` timestamp NOT NULL COMMENT '发送日期',
  `mail_body` text NOT NULL COMMENT '邮件内容',
  `status` tinyint(1) NOT NULL COMMENT '状态:1成功0失败',
  PRIMARY KEY (`id`),
  KEY `appid` (`appid`),
  KEY `smtp_id` (`smtp_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `pre_smtp`;
CREATE TABLE `pre_smtp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '服务ID',
  `name` varchar(30) NOT NULL,
  `smtp_host` varchar(50) NOT NULL COMMENT 'SMTP服务器',
  `smtp_port` int(5) NOT NULL DEFAULT '25' COMMENT 'SMTP端口',
  `smtp_username` varchar(100) NOT NULL COMMENT 'SMTP账号',
  `smtp_password` varchar(64) DEFAULT '' COMMENT 'SMTP密码',
  `smtp_from` varchar(100) DEFAULT NULL COMMENT 'SMTP发信人地址',
  `smtp_from_name` varchar(100) DEFAULT NULL COMMENT 'SMTP发信人名字',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态:1启用0关闭',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  `updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `smtp_host` (`smtp_host`),
  KEY `smtp_username` (`smtp_username`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb4;
