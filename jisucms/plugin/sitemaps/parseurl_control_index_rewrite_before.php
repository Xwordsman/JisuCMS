<?php
//百度sitemap插件 伪静态路径拦截
preg_match("/^sitemap\.(xml|html|txt)$/i", $uri, $mat);
if(isset($mat[1])){
    $_GET['control'] = 'views';
    $_GET['action'] = 'sitemaps';
    $_GET['fmt'] = $mat[1];
    return;
}