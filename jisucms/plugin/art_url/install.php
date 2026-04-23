<?php
defined('ROOT_PATH') || exit;
$arr = array(	
    'art_mid' => 2,
	'art_cid' => 1,
    'art_urlnum' => 100,
);
$this->kv->set('art_url', $arr);
$this->kv->save_changed();
$this->runtime->delete('art_url');