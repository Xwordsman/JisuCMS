<?php
defined('ROOT_PATH') or exit;

class tool_sitemaps_control extends admin_control {

    //设置
    public function setting(){
        if(empty($_POST)) {
            $cfg = $this->runtime->xget();
            $this->assign('weburl', $cfg['weburl']);

            $sitemaps_setting = $this->kv->xget('tool_sitemaps_setting');

            $changefreq_arr = array(
                'always'=>'一直更新',
                'hourly'=>'小时',
                'daily'=>'天',
                'weekly'=>'周',
                'monthly'=>'月',
                'yearly'=>'年',
                'never'=>'从不更新',
            );
            $priority_arr = array(
                '1'=>1,
                '0.9'=>0.9,'0.8'=>0.8,'0.7'=>0.7,'0.6'=>0.6,'0.5'=>0.5,
                '0.4'=>0.4,'0.3'=>0.3,'0.2'=>0.2,'0.1'=>0.1,
            );

            $input = array();
            $input['life'] = form::get_number('life', $sitemaps_setting['life']);
            $input['count'] = form::get_number('count', $sitemaps_setting['count']);
            $input['baidu_changefreq_index'] = form::layui_loop('select', 'baidu_changefreq_index', $changefreq_arr, $sitemaps_setting['baidu_changefreq_index']);
            $input['baidu_priority_index'] = form::layui_loop('select', 'baidu_priority_index', $priority_arr, $sitemaps_setting['baidu_priority_index']);

            $input['baidu_changefreq_category'] = form::layui_loop('select', 'baidu_changefreq_category', $changefreq_arr, $sitemaps_setting['baidu_changefreq_category']);
            $input['baidu_priority_category'] = form::layui_loop('select', 'baidu_priority_category', $priority_arr, $sitemaps_setting['baidu_priority_category']);

            $cms_arr = $this->models->find_fetch(array(), array('mid' => 1));
            $models = array();
            foreach ($cms_arr as $k=>$v) {
                $mid = $v['mid'];
                if ($mid > 1) {

                    $baidu_changefreq_content = isset($sitemaps_setting['baidu_changefreq_content_'.$mid]) ? $sitemaps_setting['baidu_changefreq_content_'.$mid] : 'daily';
                    $baidu_priority_content = isset($sitemaps_setting['baidu_priority_content_'.$mid]) ? $sitemaps_setting['baidu_priority_content_'.$mid] : '0.8';
                    $content_count = isset($sitemaps_setting['content_count_'.$mid]) ? $sitemaps_setting['content_count_'.$mid] : 500;

                    $baidu_changefreq_tag = isset($sitemaps_setting['baidu_changefreq_tag_'.$mid]) ? $sitemaps_setting['baidu_changefreq_tag_'.$mid] : 'daily';
                    $baidu_priority_tag = isset($sitemaps_setting['baidu_priority_tag_'.$mid]) ? $sitemaps_setting['baidu_priority_tag_'.$mid] : '0.7';
                    $tag_count = isset($sitemaps_setting['tag_count_'.$mid]) ? $sitemaps_setting['tag_count_'.$mid] : 100;

                    $input['baidu_changefreq_content_'.$mid] = form::layui_loop('select', 'baidu_changefreq_content_'.$mid, $changefreq_arr, $baidu_changefreq_content);
                    $input['baidu_priority_content_'.$mid] = form::layui_loop('select', 'baidu_priority_content_'.$mid, $priority_arr, $baidu_priority_content);
                    $input['content_count_'.$mid] = form::get_number('content_count_'.$mid, $content_count);

                    $input['baidu_changefreq_tag_'.$mid] = form::layui_loop('select', 'baidu_changefreq_tag_'.$mid, $changefreq_arr, $baidu_changefreq_tag);
                    $input['baidu_priority_tag_'.$mid] = form::layui_loop('select', 'baidu_priority_tag_'.$mid, $priority_arr, $baidu_priority_tag);
                    $input['tag_count_'.$mid] = form::get_number('tag_count_'.$mid, $tag_count);

                    $models[$mid] = $v['name'];
                }else{
                    unset($cms_arr[$k]);
                }
            }

            $def_mid = 2;
            $input['mid'] = form::layui_loop('select', 'mid', $models, $def_mid);

            $this->assign('input', $input);
            $this->assign('models_arr', $cms_arr);

            $this->display();
        }else{
            _trim($_POST);

            $arr = array(
                'life' => (int)R('life','P'),
                'baidu_changefreq_index'=>R('baidu_changefreq_index', 'P'),
                'baidu_priority_index'=>R('baidu_priority_index', 'P'),
                'baidu_changefreq_category'=>R('baidu_changefreq_category', 'P'),
                'baidu_priority_category'=>R('baidu_priority_category', 'P'),
                'count' => (int)R('count','P'),
            );

            if($arr['count'] > 10000){
                E(1, '不能超过10000.');
            }
            empty($arr['count']) && $arr['count'] = 2000;

            $cms_arr = $this->models->find_fetch(array(), array('mid' => 1));
            foreach ($cms_arr as $v) {
                $mid = $v['mid'];
                if ($mid > 1) {
                    $arr['baidu_changefreq_content_'.$mid] = R('baidu_changefreq_content_'.$mid, 'P');
                    $arr['baidu_priority_content_'.$mid] = R('baidu_priority_content_'.$mid, 'P');
                    $arr['content_count_'.$mid] = (int)R('content_count_'.$mid, 'P');

                    $arr['baidu_changefreq_tag_'.$mid] = R('baidu_changefreq_tag_'.$mid, 'P');
                    $arr['baidu_priority_tag_'.$mid] = R('baidu_priority_tag_'.$mid, 'P');
                    $arr['tag_count_'.$mid] = (int)R('tag_count_'.$mid, 'P');
                }
            }

            $this->kv->set('tool_sitemaps_setting', $arr);

            $this->kv->delete('tool_sitemaps');
            E(0, '修改成功！');
        }
    }

}

