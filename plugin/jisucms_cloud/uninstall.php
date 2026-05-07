<?php
defined('ROOT_PATH') || exit;
$tableprefix = $_ENV['_config']['db']['master']['tablepre'];
$this->db->query("DROP TABLE IF EXISTS ".$tableprefix."cloud_site");
$this->db->query("DROP TABLE IF EXISTS ".$tableprefix."cloud_site_log");
