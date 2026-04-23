<?php
defined('ROOT_PATH') or exit;


$arr = array(
    'cache_day' => 2,
    'watermark_transparency' => 50,
);
$this->kv->set('title_pic_setting', $arr);



?>