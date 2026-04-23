<?php
//百度sitemap插件 生成
function sitemaps(){
    $fmt = R('fmt', 'G');
    $allow_fmt = array('html', 'xml', 'txt');
    if( !in_array($fmt, $allow_fmt) ){core::error404();}

    $sitemaps_setting = $this->kv->get('tool_sitemaps_setting');

    $cfg = $this->runtime->xget();
    $domain = $cfg['weburl'];
    $this->assign('cfg', $cfg);

    if($fmt == 'html'){
        //优先从缓存读取
        $tool_sitemaps = $this->runtime->get('tool_sitemaps_html');
        if($tool_sitemaps){
            $Htmlx = $tool_sitemaps;
        }else{
            $Htmlx = '';

            //分类
            $category = $this->category->find_fetch(array('type'=>0), array('cid'=>1));
            foreach ($category as $cate){
                $url = $this->category->category_url($cate);
                $Htmlx .= '<li><a href="' . $url . '" title="' . $cate['name'] . '" target="_blank">' . $cate['name'] . '</a></li>';
            }

            //内容URL 和 标签URL
            $models_arr = $this->models->find_fetch(array(), array('mid' => 1));
            foreach ($models_arr as $m) {
                $mid = $m['mid'];
                if($mid > 1){
                    $content_count = isset($sitemaps_setting['content_count_'.$mid]) ? (int)$sitemaps_setting['content_count_'.$mid] : 0;
                    $tag_count = isset($sitemaps_setting['tag_count_'.$mid]) ? (int)$sitemaps_setting['tag_count_'.$mid] : 0;
                    $table = $m['tablename'];

                    if ($content_count) {
                        $this->cms_content->table = 'cms_'.$table;
                        $list_arr = $this->cms_content->find_fetch(array(), array('id' => -1), 0, $content_count);
                        foreach ($list_arr as $v){
                            $url = $this->cms_content->content_url($v);
                            $Htmlx .= '<li><a href="' . $url . '" title="' . $v['title'] . '" target="_blank">' . $v['title'] . '</a></li>';
                        }
                    }

                    if ($tag_count) {
                        $this->cms_content_tag->table = 'cms_'.$table.'_tag';
                        $list_arr = $this->cms_content_tag->find_fetch(array(), array('tagid' => -1), 0, $tag_count);
                        foreach ($list_arr as $v){
                            $url = $this->cms_content->tag_url($mid, $v);
                            $Htmlx .= '<li><a href="' . $url . '" title="' . $v['name'] . '" target="_blank">' . $v['name'] . '</a></li>';
                        }
                    }
                }
            }

            if( $sitemaps_setting['life'] ){
                $this->runtime->set('tool_sitemaps_html', $Htmlx, $sitemaps_setting['life']);
            }
        }

        $this->assign('htmlx', $Htmlx);

        $lastTime = date('Y-m-d H:i:s');
        $this->assign('lastTime', $lastTime);

        $GLOBALS['run'] = &$this;

        $this->_cfg = $this->runtime->xget();
        $_ENV['_theme'] = &$this->_cfg['theme'];
        $this->display('sitemaps_tpl.htm');
    }elseif($fmt == 'txt'){
        //优先从缓存读取
        $tool_sitemaps = $this->runtime->get('tool_sitemaps_txt');
        if($tool_sitemaps){
            $Txtx = $tool_sitemaps;
        }else{
            $Txtx = $domain . PHP_EOL;

            //分类
            $category = $this->category->find_fetch(array('type'=>0), array('cid'=>1));
            foreach ($category as $cate){
                $url = $this->category->category_url($cate);
                $Txtx .= $url . PHP_EOL;
            }

            //内容URL 和 标签URL
            $models_arr = $this->models->find_fetch(array(), array('mid' => 1));
            foreach ($models_arr as $m) {
                $mid = $m['mid'];
                if($mid > 1){
                    $content_count = isset($sitemaps_setting['content_count_'.$mid]) ? (int)$sitemaps_setting['content_count_'.$mid] : 0;
                    $tag_count = isset($sitemaps_setting['tag_count_'.$mid]) ? (int)$sitemaps_setting['tag_count_'.$mid] : 0;
                    $table = $m['tablename'];

                    if ($content_count) {
                        $this->cms_content->table = 'cms_'.$table;
                        $list_arr = $this->cms_content->find_fetch(array(), array('id' => -1), 0, $content_count);
                        foreach ($list_arr as $v){
                            $url = $this->cms_content->content_url($v);
                            $Txtx .= $url . PHP_EOL;
                        }
                    }

                    if ($tag_count) {
                        $this->cms_content_tag->table = 'cms_'.$table.'_tag';
                        $list_arr = $this->cms_content_tag->find_fetch(array(), array('tagid' => -1), 0, $tag_count);
                        foreach ($list_arr as $v){
                            $url = $this->cms_content->tag_url($mid, $v);
                            $Txtx .= $url . PHP_EOL;
                        }
                    }
                }
            }

            if( $sitemaps_setting['life'] ){
                $this->runtime->set('tool_sitemaps_txt', $Txtx, $sitemaps_setting['life']);
            }
        }

        $this->assign('txt', $Txtx);

        $lastTime = date('Y-m-d H:i:s');
        $this->assign('lastTime', $lastTime);

        $GLOBALS['run'] = &$this;

        $this->_cfg = $this->runtime->xget();
        $_ENV['_theme'] = &$this->_cfg['theme'];
        $this->display('sitemaps_txt.htm');
    }elseif ($fmt == 'xml'){
        $today = date('c');

        //优先从缓存读取
        // $tool_sitemaps = $this->runtime->get('tool_sitemaps_xml');
        $tool_sitemaps=false;
        if($tool_sitemaps){
            $baidu_items = $tool_sitemaps;
        }else{
            include_once PLUGIN_PATH.'tool_sitemaps_pro/baidusitemap.class.php';
            $sitemapObj = new baidusitemap();
            
            $baidu_changefreq_index = $sitemaps_setting['baidu_changefreq_index'];
            $baidu_priority_index = $sitemaps_setting['baidu_priority_index'];
            $baidu_changefreq_category = $sitemaps_setting['baidu_changefreq_category'];
            $baidu_priority_category = $sitemaps_setting['baidu_priority_category'];

            //生成百度地图头部　－第一条 首页
            $sitemapObj->baiduxml_item($domain, $today, $baidu_changefreq_index, $baidu_priority_index);
            //开始改造xml文件
            $xmldz=ROOT_PATH.'sitemaps/txt2/*.xml';
            $xmlFiles = glob($xmldz);
            $xurl='';
            if (!empty($xmlFiles)) {
                foreach ($xmlFiles as $xurl) {
                    //替换成网址
                    $xurl=str_replace(ROOT_PATH,$domain,$xurl);
                    $sitemapObj->baiduxml_item($xurl, $today, $baidu_changefreq_index, $baidu_priority_index);
                }
            }
            // die;
            //改造结束//
            //分类
            $category = $this->category->find_fetch(array('type'=>0), array('cid'=>1));
            foreach ($category as $cate){
                $url = $this->category->category_url($cate);
                $sitemapObj->baiduxml_item($url, $today, $baidu_changefreq_category, $baidu_priority_category);
            }

            //内容URL 和 标签URL
            $models_arr = $this->models->find_fetch(array(), array('mid' => 1));
            foreach ($models_arr as $m) {
                $mid = $m['mid'];
                if($mid > 1){
                    $content_count = isset($sitemaps_setting['content_count_'.$mid]) ? (int)$sitemaps_setting['content_count_'.$mid] : 0;
                    $tag_count = isset($sitemaps_setting['tag_count_'.$mid]) ? (int)$sitemaps_setting['tag_count_'.$mid] : 0;
                    $table = $m['tablename'];

                    if ($content_count) {
                        $this->cms_content->table = 'cms_'.$table;
                        $list_arr = $this->cms_content->find_fetch(array(), array('id' => -1), 0, $content_count);
                        foreach ($list_arr as $v){
                            $url = $this->cms_content->content_url($v);
                            $updatetime = date('c',$v['lasttime']);
                            $sitemapObj->baiduxml_item($url, $updatetime, $sitemaps_setting['baidu_changefreq_content_'.$mid],$sitemaps_setting['baidu_priority_content_'.$mid]);
                        }
                    }

                    if ($tag_count) {
                        $this->cms_content_tag->table = 'cms_'.$table.'_tag';
                        $list_arr = $this->cms_content_tag->find_fetch(array(), array('tagid' => -1), 0, $tag_count);
                        foreach ($list_arr as $v){
                            $url = $this->cms_content->tag_url($mid, $v);
                            $sitemapObj->baiduxml_item($url, '', $sitemaps_setting['baidu_changefreq_tag_'.$mid],$sitemaps_setting['baidu_priority_tag_'.$mid]);
                        }
                    }
                }
            }

            $baidu_items = $sitemapObj->baidu_items;

            if( $sitemaps_setting['life'] ){
                $this->runtime->set('tool_sitemaps_xml', $baidu_items, $sitemaps_setting['life']);
            }
        }

        $this->assign('baidu_items', $baidu_items);
        $this->assign_value('xml', '<?xml version="1.0" encoding="UTF-8" ?>');

        $GLOBALS['run'] = &$this;

        $this->_cfg = $this->runtime->xget();
        $_ENV['_theme'] = &$this->_cfg['theme'];
        $this->display('sitemaps_xml.htm');
    }else{
        core::error404();
    }
}
//生成txt文件
function sitemaps_txt(){
    $start_time = microtime(1);
    $mid = max(2, R('mid','G'));
    $method = (int)R('method','G');

    $cfg = $this->runtime->xget();

    if( !isset($cfg['table_arr'][$mid]) ){
        core::error404();
    }

    //txt文件存放目录
    $txt_dir = ROOT_PATH.'sitemaps/txt'.$mid;
    if(!is_dir($txt_dir) && !mkdir($txt_dir, 0755, true)) {
        exit("创建文件夹{$txt_dir}失败！");
    }

    $sitemaps_setting = $this->kv->get('tool_sitemaps_setting');
    $pagenum = isset($sitemaps_setting['count']) ? (int)$sitemaps_setting['count'] : 1000;
    $page = max(1, intval(R('page')));

    $table = $cfg['table_arr'][$mid];
    $this->cms_content->table = 'cms_'.$table;

    $total = $this->cms_content->count();
    $maxpage = max(1, ceil($total/$pagenum));
    if($page > $maxpage){
        exit('全部生成完毕！');
    }

    if($method){    //部分
        $files = glob($txt_dir.'/*.txt');
        $txtfile_count = count($files);

        if($txtfile_count > $maxpage){
            exit('全部生成完毕，无需生成！');
        }else{
            $page < $txtfile_count && $page = $txtfile_count;
            $txt_filename = $page.'.txt';
            $xml_filename = $page.'.xml';
            $list_arr = $this->cms_content->list_arr(array(), 'id', 1, ($page-1)*$pagenum, $pagenum, $total);
            // var_dump($list_arr);
            // die;
        }
    }else{  //全部
        $txt_filename = $page.'.txt';
        $xml_filename = $page.'.xml';
        $list_arr = $this->cms_content->list_arr(array(), 'id', 1, ($page-1)*$pagenum, $pagenum, $total);
        // var_dump($list_arr);
        //     die;
    }
    $xml1= <<<EOD
<?xml version="1.0" encoding="utf-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
EOD;
    $xml2= <<<EOD
</urlset>
    
EOD;
    
    if(empty($list_arr)){
        exit('全部生成完毕！');
    }
    $urls = '';
    $urlsxmls='';
    foreach ($list_arr as $v){
        $urls .= $this->cms_content->content_url($v) . PHP_EOL;//组装txt
        $dateline=$v["dateline"];//时间
        $datexin = date('Y-m-d', $dateline);
        $urlsxml = $this->cms_content->content_url($v);//url
        $xmlContent = <<<EOD
    <url>
        <loc>{urls}</loc>
        <lastmod>{shijian}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

EOD;
            $newString = str_replace('{urls}', $urlsxml, $xmlContent);
            $newString = str_replace('{shijian}', $datexin, $newString);
            $urlsxmls .= $newString;
    }
    
    $txt_filepath = $txt_dir.'/'.$txt_filename;
    $xml_filepath = $txt_dir.'/'.$xml_filename;
    FW($txt_filepath, $urls);
    FW($xml_filepath, $xml1.$urlsxmls.$xml2);

    echo $txt_filename.'创建成功！<br>耗时：';
    echo number_format(microtime(1) - $start_time, 2).'秒！<br>';

    if($page == $maxpage){
        exit('全部生成完毕！');
    }

    $jumpurl = "{$cfg['weburl']}index.php?views-sitemaps_txt-mid-{$mid}-method-{$method}-page-".++$page;
    echo '<script>setTimeout(function(){ window.location.href = "'.$jumpurl.'"; }, 500);</script>';
    exit();
}