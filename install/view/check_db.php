<?php
/**
 * Author: 极速CMS <https://www.jisucms.com>
 * Date: 2026-05-01
 * Description:安装 参数配置
 */
$version = JISUCMS_VERSION;
$err = 0;
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
        <h2 class="content-title"><?php echo lang('db_and_admin'); ?></h2>
        <form id="form" class="layui-form" method="post" action="index.php?do=complete">
                    <fieldset class="layui-elem-field">
                        <legend><?php echo lang('step_2_title'); ?></legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('mysql'); ?>:</label>
                                <div class="layui-input-block">
                                    <?php if(!$mysql_support && !$mysqli_support && !$pdo_mysql_support){ $err = 1; ?>
                                        <span class="layui-badge"><?php echo lang('no_mysql'); ?></span>
                                    <?php }else{ ?>
                                        <?php if($mysql_support){ ?>
                                        <input type="radio" name="dbtype" value="mysql" title="mysql" <?php echo $mysql_support ? "checked" : ''; ?>>
                                        <?php } if($mysqli_support){ ?>
                                        <input type="radio" name="dbtype" value="mysqli" title="mysqli" <?php echo $mysqli_support ? "checked" : ''; ?>>
                                        <?php } if($pdo_mysql_support){ ?>
                                        <input type="radio" name="dbtype" value="pdo_mysql" title="pdo_mysql" <?php echo $pdo_mysql_support ? "checked" : ''; ?>>
                                    <?php }} ?>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('db_host'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="dbhost" required lay-verify="required" value="127.0.0.1" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux"><?php echo lang('db_host_tip'); ?></div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('db_port'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="dbport" required lay-verify="required" value="3306" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux"><?php echo lang('db_port_tip'); ?></div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('db_user'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="dbuser" required lay-verify="required" value="root" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux"><?php echo lang('db_user_tip'); ?></div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('db_pass'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="dbpw" required lay-verify="required" placeholder="<?php echo lang('db_pass_tip'); ?>" value="" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux"><?php echo lang('db_pass_tip'); ?></div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('db_name'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="dbname" required lay-verify="required" value="jisucms" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('db_prefix'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="dbpre" required lay-verify="required" value="jisu_" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('cover'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="checkbox" name="cover" title="<?php echo lang('yes'); ?>" value="1" lay-skin="primary" checked>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="layui-elem-field">
                        <legend><?php echo lang('administrators'); ?></legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('username'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="adm_user" minlength="2" maxlength="16" required lay-verify="required" value="admin" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label required"><?php echo lang('password'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="adm_pass" minlength="6" maxlength="32" required lay-verify="required" placeholder="<?php echo lang('password_tips'); ?>" value="" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><?php echo lang('author'); ?>:</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="adm_author" maxlength="50" value="<?php echo lang('author_name'); ?>" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <?php
                    if($err == 0){
                    ?>
                    <div class="layui-form-item" style="text-align: center; margin-top: 30px;">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="form" style="width: 180px;"><?php echo lang('install'); ?></button>
                    </div>
                    <?php }else{ ?>
                    <div class="layui-form-item" style="text-align: center; margin-top: 30px;">
                        <button class="layui-btn layui-btn-danger" style="width: 180px;">
                            <?php echo lang('no_mysql_extend'); ?>
                        </button>
                    </div>
                    <?php } ?>
                </form>
    </div>
    
    <!-- 底部版权 -->
    <div class="install-footer">
        &copy; 2024-2026 <a href="https://www.jisucms.com" target="_blank">JisuCMS Team</a>
    </div>
</div>
<script src="<?php echo $installwebdir; ?>static/layui/lib/layui-v2.8.15/layui.js" charset="utf-8"></script>
<script>
    layui.use('form', function(){
        var form = layui.form,layer = layui.layer;
        form.on('submit(form)', function(data){
        });
    });
</script>
</body>
</html>
