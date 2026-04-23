<?php
defined('ROOT_PATH') || exit;

$cfg_extend = array(
    'zhname'=>array('name'=>'简体网站名称', 'val'=>'site', 'remark'=>'备注'),
    'enname'=>array('name'=>'英语网站名称', 'val'=>'site', 'remark'=>'备注'),
);
$this->kv->xset('cfg_extend', $cfg_extend, 'cfg');

$this->kv->save_changed();
$this->runtime->delete('cfg');
