<?php
defined('ROOT_PATH') || exit;
$tableprefix = $_ENV['_config']['db']['master']['tablepre'];	//表前缀

$sql_table = "CREATE TABLE IF NOT EXISTS ".$tableprefix."spider (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  spider char(20) NOT NULL DEFAULT '' COMMENT '蜘蛛名称',
  url varchar(255) NOT NULL DEFAULT '' COMMENT '抓取地址',
  dateline int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抓取时间',
  ip int(10) NOT NULL DEFAULT '0' COMMENT 'IP',
  PRIMARY KEY (id),
  KEY spider (spider)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
$this->db->query($sql_table);
