# Host: localhost  (Version 5.5.53)
# Date: 2018-02-22 21:13:22
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "cmf_wechat"
#

DROP TABLE IF EXISTS `cmf_wechat`;
CREATE TABLE `cmf_wechat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(50) DEFAULT NULL,
  `secret` varchar(55) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1 测试 2 正式',
  `access_token` text CHARACTER SET utf8 COLLATE utf8_bin,
  `early_time` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL COMMENT '0 启用 1 废弃',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='微信公众配置';

#
# Data for table "cmf_wechat"
#

INSERT INTO `cmf_wechat` VALUES (1,'appid','secret',1,NULL,1516041722,0);
