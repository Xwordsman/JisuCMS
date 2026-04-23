<?php
defined('ROOT_PATH') || exit;

$tableprefix = $_ENV['_config']['db']['master']['tablepre'];
$sql = "DROP TABLE IF EXISTS `{$tableprefix}ads`;";
$this->db->query($sql);