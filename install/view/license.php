<?php
/**
 * Author: 极速CMS <https://www.jisucms.com>
 * Date: 2026-05-01
 * Description:安装 授权协议
 */

$version = JISUCMS_VERSION;
?>
<!doctype html>
<head>
    <title>极速CMS <?php echo $version; ?> 安装向导</title>
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
            <p class="header-title">极速CMS - 高性能内容管理系统</p>
            <p class="header-version">极速CMS开源版 V<?php echo $version; ?> / XiunoPHP 1.0</p>
        </div>
    </div>
    
    <!-- 内容区域 -->
    <div class="install-body">
        <h2 class="content-title"><?php echo lang('license_title'); ?></h2>
        <div class="license-content">
            <?php echo lang('license_content'); ?>
        </div>
        <div class="layui-form-item" style="margin-top: 30px; text-align: center;">
            <a class="layui-btn layui-btn-normal" href="index.php?do=check_env" style="width: 180px;"><?php echo lang('agree_license_to_continue');?></a>
            <button type="button" class="layui-btn layui-btn-primary" onclick="no_agree()" style="width: 180px; margin-left: 15px;"><?php echo lang('no_agree');?></button>
        </div>
    </div>
    
    <!-- 底部版权 -->
    <div class="install-footer">
        &copy; 2024-2026 <a href="https://www.jisucms.com" target="_blank">JisuCMS Team</a>
    </div>
</div>
<script>
    function no_agree() {
        window.location.replace("about:blank");
        window.close();
    }
</script>
</body>
</html>
