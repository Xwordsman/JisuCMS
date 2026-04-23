<?php
defined('ROOT_PATH') || exit;

$this->kv->xdelete('tool_log_file_max_size');
$this->kv->save_changed();
$this->runtime->delete('cfg');
