<?php
//插件设置
function art_url() {
    if (empty($_POST)) {
        $art_url = $this->kv->xget('art_url');
        $input = array();
        $input['art_mid'] = form::get_number('art_mid', $art_url['art_mid']);
        $input['art_cid'] = form::get_number('art_cid', $art_url['art_cid']);
        $input['art_urlnum'] = form::get_number('art_urlnum', $art_url['art_urlnum']);
        //新增 域名
        $cfg = $this->runtime->xget();
        $domain = http().$cfg['webdomain'];
        if (empty($art_url['art_mid'])) {
            $mid = max(2, R('mid', 'R'));
        } else {
            $mid = $art_url['art_mid'];
        }
        $modles = $this->models->get($mid);
        if (empty($modles)) {
            exit('mid值错误！');
        }        
        $table = $modles['tablename'];
        // 初始模型表名
        $this->cms_content->table = 'cms_' . $table;
        $cidset = $art_url['art_cid'];
        $limit = $art_url['art_urlnum'];
        
        // 修改部分：当cid为0时不设置分类条件
        $where = array();
        if ($cidset != 0) {
            $where['cid'] = $cidset;
        }
        
        $list_arr = $this->cms_content->find_fetch($where, array('id' => -1), 0, $limit);
        //内容URL
        $urls = array();
        foreach ($list_arr as $v) {
            //$urls[] = $domain.$this->cms_content->content_url($v['cid'], $v['id'], $v['alias'], $mid)."\n";
            $urls[] = $this->cms_content->content_url($v, $mid)."\n";//1.0.0+
        }
        $geturls = implode('', $urls);
        $input['art_urls'] = form::get_textarea('art_urls', $geturls, '', 'id="artUrls"');
        $this->assign('input', $input);
        $this->display('tool_art_url.htm');
    } else {
        _trim($_POST);
        $arr = ['art_mid' => (int)R('art_mid', 'P'),'art_cid' => (int) R('art_cid', 'P'),'art_urlnum' => (int)R('art_urlnum', 'P'),'art_urls' => R('art_urls', 'P')];
        $this->kv->set('art_url', $arr);
        $this->kv->save_changed();
        $this->runtime->delete('art_url');
        E(0, '修改成功！');
    }
}