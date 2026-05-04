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
        <div class="lang-select-area">
            <h2 class="lang-select-title">请选择您需要安装的语言</h2>
            <form action="index.php?do=license" method="post" id="form" class="layui-form">
                <input type="hidden" name="lang" id="selected-lang" value="zh-cn">
                <div class="lang-cards">
                    <div class="lang-card active" data-lang="zh-cn">
                        <div class="lang-card-name">简体中文</div>
                    </div>
                    <div class="lang-card" data-lang="en">
                        <div class="lang-card-name">English</div>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 50px;">
                    <button type="submit" class="layui-btn layui-btn-normal" style="width: 200px;">下一步</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- 底部版权 -->
    <div class="install-footer">
        &copy; 2024-2026 <a href="https://www.jisucms.com" target="_blank">JisuCMS Team</a>
    </div>
</div>
<script src="<?php echo $installwebdir; ?>static/layui/lib/layui-v2.8.15/layui.js" charset="utf-8"></script>
<script type="text/javascript">
    layui.use(['form','jquery'], function(){
        var form = layui.form, $ = layui.$;
        
        // 语言卡片点击事件
        $('.lang-card').on('click', function(){
            var lang = $(this).data('lang');
            $('.lang-card').removeClass('active');
            $(this).addClass('active');
            $('#selected-lang').val(lang);
        });
        
        // 表单提交
        $('form').on('submit', function(e){
            e.preventDefault();
            var lang = $('#selected-lang').val();
            $.post("index.php?do=lang", {lang: lang}, function(res){
                window.location.href = "index.php?do=license";
            }, 'json');
            return false;
        });
    });
</script>
</body>
</html>
