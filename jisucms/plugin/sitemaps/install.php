<?php
defined('ROOT_PATH') || exit;

if( plugin_is_enable('tool_sitemaps') ){
    E(1, '请停用tool_sitemaps插件');
}
if(empty($_ENV['_config']['toolcms_parseurl'])) {
    E(1, '请开启伪静态');
}

$arr = array(
    'life' => 3600,
    'baidu_changefreq_index'=>'daily',
    'baidu_priority_index'=>'1',
    'baidu_changefreq_category'=>'daily',
    'baidu_priority_category'=>'0.9',

    'count'=>2000,  //生成地图文件，每个文件URL数量
);

$cms_arr = $this->models->find_fetch(array(), array('mid' => 1));
foreach ($cms_arr as $v){
    $mid = $v['mid'];
    if($mid > 1){
        $arr['baidu_changefreq_content_'.$mid] = 'daily';
        $arr['baidu_priority_content_'.$mid] = '0.8';
        $arr['content_count_'.$mid] = 500;

        $arr['baidu_changefreq_tag_'.$mid] = 'daily';
        $arr['baidu_priority_tag_'.$mid] = '0.7';
        $arr['tag_count_'.$mid] = 100;
    }
}

$this->kv->set('tool_sitemaps_setting', $arr);