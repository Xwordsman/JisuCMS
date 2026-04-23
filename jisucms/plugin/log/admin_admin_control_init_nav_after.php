<?php
defined('ROOT_PATH') || exit;

$menu['menuInfo']['tools']['child'][] = [
    'title' => '日志管理',
    'icon' => 'fa fa-file',
    'href' => '',
    'target' => '_self',
    'child' => [
        ['title' => '错误日志', 'href' => 'index.php?log-index', 'icon' => 'fa fa-file-o', 'target' => '_self'],
        ['title' => '404日志', 'href' => 'index.php?log-log404', 'icon' => 'fa fa-file-o', 'target' => '_self'],
        ['title' => '登录日志', 'href' => 'index.php?log-login', 'icon' => 'fa fa-file-o', 'target' => '_self'],
    ],
];
