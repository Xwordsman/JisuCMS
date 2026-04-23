<?php
defined('ROOT_PATH') || exit;

$s = 10; //限制读取文件大小
$this->kv->xset('tool_log_file_max_size', $s, 'cfg');
$this->kv->save_changed();
$this->runtime->delete('cfg');
