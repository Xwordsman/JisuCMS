<?php
defined('ROOT_PATH') || exit;

$this->kv->xdelete('cfg_extend');

$this->kv->save_changed();
$this->runtime->delete('cfg');