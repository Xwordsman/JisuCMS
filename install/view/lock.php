<?php
$version = JISUCMS_VERSION;
?>
<!doctype html>
<head>
<title><?php echo lang('installation_wizard'); ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo $installwebdir; ?>static/layui/lib/layui-v2.8.15/css/layui.css" media="all">
    <link rel="stylesheet" href="./css/install.css" media="all">
</head>
<body>
<div class="install-wrapper">
    <!-- 顶部品牌区域 -->
    <div class="install-header">
        <div class="install-header-left">
            <h1>极速CMS</h1>
            <span class="header-subtitle">安装向导</span>
        </div>
        <div class="install-header-right">
            <p class="header-title">极速CMS 简体中文版</p>
            <p class="header-version"><?php echo $version; ?> / MitFrame 1.0</p>
        </div>
    </div>
    
    <!-- 内容区域 -->
    <div class="install-body">
        <div class="layui-card">
            <div class="layui-card-header">LECMS  <?php echo $version.' '.lang('installation_info'); ?></div>
            <div class="layui-card-body">
                <p class="layui-font-18" style="margin-top: 10px;"><?php echo lang('installed_tips'); ?></p>
            </div>
        </div>
    </div>
    
    <!-- 底部版权 -->
    <div class="install-footer">
        &copy; 2024-2026 <a href="https://www.lecms.com" target="_blank">LECMS Team</a>
    </div>
</div>
</body>
</html>
