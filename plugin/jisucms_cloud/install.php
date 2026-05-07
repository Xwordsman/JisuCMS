<?php
defined('ROOT_PATH') || exit;
$tableprefix = $_ENV['_config']['db']['master']['tablepre'];

$sql = "CREATE TABLE IF NOT EXISTS ".$tableprefix."cloud_site (
  cloud_site_id char(32) NOT NULL DEFAULT '',
  domain varchar(255) NOT NULL DEFAULT '',
  jisucms_version varchar(32) NOT NULL DEFAULT '',
  php_version varchar(64) NOT NULL DEFAULT '',
  mysql_version varchar(64) NOT NULL DEFAULT '',
  os varchar(64) NOT NULL DEFAULT '',
  language varchar(32) NOT NULL DEFAULT '',
  theme_active varchar(80) NOT NULL DEFAULT '',
  plugins_active mediumtext NOT NULL,
  cloud_site_installed_at int(10) unsigned NOT NULL DEFAULT '0',
  first_connect_at int(10) unsigned NOT NULL DEFAULT '0',
  last_connect_at int(10) unsigned NOT NULL DEFAULT '0',
  connect_count int(10) unsigned NOT NULL DEFAULT '0',
  last_payload mediumtext NOT NULL,
  latest_response mediumtext NOT NULL,
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (cloud_site_id),
  KEY domain (domain),
  KEY last_connect_at (last_connect_at)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$this->db->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS ".$tableprefix."cloud_site_log (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  cloud_site_id char(32) NOT NULL DEFAULT '',
  domain varchar(255) NOT NULL DEFAULT '',
  jisucms_version varchar(32) NOT NULL DEFAULT '',
  event_type varchar(32) NOT NULL DEFAULT 'connect',
  payload mediumtext NOT NULL,
  response mediumtext NOT NULL,
  dateline int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY cloud_site_id (cloud_site_id),
  KEY dateline (dateline)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$this->db->query($sql);
