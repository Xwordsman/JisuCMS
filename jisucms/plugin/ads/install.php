<?php
defined('ROOT_PATH') || exit;
$tableprefix = $_ENV['_config']['db']['master']['tablepre'];	//表前缀

$sql = "CREATE TABLE IF NOT EXISTS ".$tableprefix."ads (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  alias char(20) NOT NULL DEFAULT '' COMMENT '唯一标识',
  title varchar(80) NOT NULL DEFAULT '' COMMENT '标题',
  pic varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  exdate int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间',
  url varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  content mediumtext NOT NULL COMMENT '内容',
  code mediumtext NOT NULL COMMENT '代码',
  client varchar(255) NOT NULL DEFAULT '' COMMENT '显示选项',
  status varchar(255) NOT NULL DEFAULT '' COMMENT '用户可见',
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
$this->db->query($sql);
