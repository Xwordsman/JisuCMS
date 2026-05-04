<?php
/**
 * Author: 极速CMS <https://www.jisucms.com>
 * Date: 2026-05-01
 * Description:安装 参数配置
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
    <style>
        .layui-badge{
            margin-bottom: 5px;
            display: inline-block;
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        #cont {
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
            line-height: 2;
        }
        
        /* 进度条样式 */
        .install-progress {
            margin-bottom: 20px;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #f0f0f0;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-bar-inner {
            height: 100%;
            background: #1890FF;
            width: 0%;
            transition: width 0.3s ease;
        }
        
        .progress-text {
            text-align: center;
            margin-top: 10px;
            color: #666;
            font-size: 14px;
        }
        
        /* 安装进度页面 */
        #install-process {
            display: block;
        }
        
        /* 安装完成页面 */
        #install-success {
            display: none;
            text-align: center;
            padding: 60px 20px;
        }
        
        .success-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: #5FB878;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
        }
        
        .success-icon i {
            font-size: 60px;
            color: #fff;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .success-title {
            font-size: 24px;
            color: #333;
            font-weight: bold;
            margin-bottom: 40px;
        }
        
        .success-info {
            margin-bottom: 30px;
            text-align: left;
            background: #f8f8f8;
            padding: 20px;
            border-radius: 4px;
            line-height: 2;
        }
        
        .success-info p {
            margin: 5px 0;
            color: #666;
        }
        
        .success-actions {
            margin-top: 30px;
        }
        
        .success-actions .layui-btn {
            width: 200px;
            margin: 10px;
        }
    </style>
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
        <!-- 安装进度页面 -->
        <div id="install-process">
            <h2 class="content-title"><?php echo lang('installation_info'); ?></h2>
            
            <!-- 进度条 -->
            <div class="install-progress">
                <div class="progress-bar">
                    <div class="progress-bar-inner" id="progress-bar"></div>
                </div>
                <div class="progress-text" id="progress-text">正在准备安装...</div>
            </div>
            
            <div class="layui-elem-field" style="border: 1px solid #e6e6e6;">
                <div class="layui-field-box" style="padding: 0;">
                    <div id="cont" class="content"></div>
                </div>
            </div>
        </div>
        
        <!-- 安装完成页面 -->
        <div id="install-success">
            <div class="success-icon">
                <i class="layui-icon layui-icon-ok"></i>
            </div>
            <div class="success-title">站点安装完成，感谢您的支持！</div>
            
            <div class="success-info" id="success-info">
                <!-- 这里会动态插入安装信息 -->
            </div>
            
            <div class="success-actions">
                <a href="<?php echo $installwebdir; ?>" class="layui-btn layui-btn-primary layui-btn-lg" target="_blank">
                    <i class="layui-icon layui-icon-home"></i> 访问首页
                </a>
                <a href="<?php echo $installwebdir; ?>admin/" class="layui-btn layui-btn-normal layui-btn-lg" target="_blank">
                    <i class="layui-icon layui-icon-set"></i> 进入管理后台
                </a>
            </div>
            
            <div style="margin-top: 30px; color: #FF5722; font-size: 14px;">
                <i class="layui-icon layui-icon-tips"></i> 请及时删除 install 安装目录，以确保网站安全！
            </div>
        </div>
    </div>
    
    <!-- 底部版权 -->
    <div class="install-footer">
        &copy; 2024-2026 <a href="https://www.jisucms.com" target="_blank">JisuCMS Team</a>
    </div>
</div>
<script src="<?php echo $installwebdir; ?>static/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var messageQueue = [];
    var currentIndex = 0;
    var isCollecting = true; // 是否正在收集消息
    var installInfo = {
        homeUrl: '',
        adminUrl: '',
        username: '',
        password: ''
    };
    
    // 显示消息的函数（由PHP后端调用）
    function jsShow(s = '', err = 0) {
        var message = {
            text: s,
            type: err
        };
        
        // 收集消息到队列
        messageQueue.push(message);
        
        // 提取安装信息（用于完成页面显示）
        if(err == 3) {
            // 蓝色消息通常包含重要信息
            if(s.indexOf('href=') > -1) {
                // 提取URL
                var match = s.match(/href="([^"]+)"/);
                if(match) {
                    var url = match[1];
                    if(url.indexOf('admin') > -1) {
                        installInfo.adminUrl = url;
                    } else {
                        installInfo.homeUrl = url;
                    }
                }
            }
            // 提取用户名和密码
            if(s.indexOf('用户名') > -1 || s.indexOf('username') > -1) {
                installInfo.credentials = s.replace(/<[^>]+>/g, ''); // 移除HTML标签
            }
        }
    }
    
    // 开始播放安装动画
    function startInstallAnimation() {
        isCollecting = false;
        
        if(messageQueue.length === 0) {
            // 如果没有消息，直接显示完成页面
            showSuccessPage();
            return;
        }
        
        // 开始逐条显示消息
        processQueue();
    }
    
    // 处理消息队列
    function processQueue() {
        if(currentIndex >= messageQueue.length) {
            // 所有消息显示完毕，延迟1秒后跳转到完成页面
            setTimeout(function(){
                showSuccessPage();
            }, 1000);
            return;
        }
        
        var message = messageQueue[currentIndex];
        var str = '';
        
        // 根据类型设置样式
        if(message.type == 1){
            str = '<span class="layui-badge layui-bg-red">'+message.text+'</span>';
        }else if(message.type == 2){
            str = '<span style="color: #666;">'+message.text+'</span>';
        }else if(message.type == 3){
            str = '<span class="layui-badge layui-bg-blue">'+message.text+'</span>';
        }else{
            str = '<span class="layui-badge layui-bg-green">'+message.text+'</span>';
        }
        
        // 添加消息到页面
        $("#cont").append(str + "<br>");
        
        // 滚动到底部
        $("#cont").scrollTop($("#cont")[0].scrollHeight);
        
        // 更新进度
        var progress = Math.floor(((currentIndex + 1) / messageQueue.length) * 100);
        var progressText = '正在安装... (' + (currentIndex + 1) + '/' + messageQueue.length + ')';
        updateProgress(progress, progressText);
        
        currentIndex++;
        
        // 延迟后显示下一条消息（模拟真实安装过程）
        setTimeout(function(){
            processQueue();
        }, 100); // 每条消息间隔100毫秒
    }
    
    // 显示完成页面
    function showSuccessPage() {
        // 隐藏安装进度页面
        $('#install-process').fadeOut(500, function(){
            // 显示完成页面
            $('#install-success').fadeIn(500);
            
            // 填充安装信息
            var infoHtml = '';
            if(installInfo.homeUrl) {
                infoHtml += '<p><strong>网站首页：</strong><a href="'+installInfo.homeUrl+'" target="_blank">'+installInfo.homeUrl+'</a></p>';
            }
            if(installInfo.adminUrl) {
                infoHtml += '<p><strong>管理后台：</strong><a href="'+installInfo.adminUrl+'" target="_blank">'+installInfo.adminUrl+'</a></p>';
            }
            if(installInfo.credentials) {
                infoHtml += '<p><strong>登录信息：</strong>'+installInfo.credentials+'</p>';
            }
            
            // 只有当有信息时才显示信息区域，否则隐藏
            if(infoHtml) {
                $('#success-info').html(infoHtml).show();
            } else {
                $('#success-info').hide();
            }
        });
    }
    
    // 更新进度条
    function updateProgress(percent, text) {
        $('#progress-bar').css('width', percent + '%');
        $('#progress-text').text(text);
    }
    
    // 初始化
    $(document).ready(function(){
        updateProgress(0, '正在准备安装...');
        
        // 等待PHP输出完成后开始动画
        // 使用setTimeout确保所有PHP输出的jsShow调用都已执行
        setTimeout(function(){
            startInstallAnimation();
        }, 500);
    });
</script>
</body>
</html>
