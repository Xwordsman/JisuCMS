<?php
/**
 * Author: Xwordsman
 * Date: 2026-4-23
 * Description:
 */
class baidusitemap{
    public $baidu_items;

    function __construct() {
        $this->baidu_items = array();   //baidu 元素
    }

    /**
     * @param $loc  网址
     * @param string $lastmod   文件上次修改日期
     * @param string $changefreq    页面可能发生更改的频率 always、hourly、daily、weekly、monthly、yearly、never
     * @param string $priority  网页的优先级。有效值范围从 0.0 到 1.0 (选填项) 。0.0优先级最低、1.0最高。
     * @return array
     */
    function baiduxml_item($loc = '', $lastmod = '', $changefreq = 'weekly',$priority = '1.0'){
        $data = array();
        $data['loc'] =  $loc;
        $data['lastmod'] =  empty($lastmod) ? '' : $lastmod;
        $data['changefreq'] =  $changefreq;
        $data['priority'] =  $priority;
        $this->baidu_items[] = $data;
        return $data;
    }

    function baiduxml_build( $file_name = null, $encoding = 'UTF-8' ) {
        $map = "<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n";
        $map .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:mobile=\"http://www.baidu.com/schemas/sitemap-mobile/1/\">\n";
        foreach ($this->baidu_items as $item){
            $map .= "\t\t<url>\n\t\t\t<loc>$item[loc]</loc>\n";
            $map .= "\t\t\t<mobile:mobile type=\"pc,mobile\"/>\n";
            $map .= "\t\t\t<lastmod>$item[lastmod]</lastmod>\n";
            $map .= "\t\t\t<changefreq>$item[changefreq]</changefreq>\n";
            $map .= "\t\t\t<priority>$item[priority]</priority>\n";
            $map .= "\t\t</url>\n";
        }
        $map .= "</urlset>\n";
        return FW($file_name, $map);
    }

    function baiduxml_build_sitemapindex( $file_name = null, $encoding = 'UTF-8' ) {
        $map = "<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n";
        $map .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:mobile=\"http://www.baidu.com/schemas/sitemap-mobile/1/\">\n";
        foreach ($this->baidu_items as $item){
            $map .= "\t\t<sitemap>\n\t\t\t<loc>$item[loc]</loc>\n";
            $map .= "\t\t\t<lastmod>$item[lastmod]</lastmod>\n";
            $map .= "\t\t</sitemap>\n\n";
        }
        $map .= "</sitemapindex>\n";
        return FW($file_name, $map);
    }
}