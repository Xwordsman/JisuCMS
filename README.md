# 极速CMS (JisuCMS)

<p align="center">
  <img src="https://img.shields.io/badge/version-1.3.0-blue.svg" alt="Version">
  <img src="https://img.shields.io/badge/php-%3E%3D5.4-brightgreen.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License">
</p>

## 📖 简介

极速CMS（JisuCMS）是一款基于 PHP + MySQL 架构的轻量级内容管理系统，采用 XiunoPHP 框架开发，专为高性能、大数据量网站设计。系统简洁高效，支持千万级数据处理，适合各类企业网站、门户网站、资讯网站等应用场景。

### ✨ 核心特性

- 🚀 **高性能架构** - 懒加载设计，单表支持亿级数据，响应速度极快
- 🔌 **强大插件系统** - AOP插件机制，零性能损耗，轻松扩展功能
- 🎨 **灵活模板引擎** - 简洁的模板标签，懂HTML即可快速开发
- 📱 **响应式后台** - 基于Layui的现代化管理界面，支持多设备访问
- 🔍 **SEO友好** - 内置多种SEO设置，自由配置URL规则
- 🎯 **自定义模型** - 支持自定义内容模型和字段，灵活应对各种需求
- 💰 **完全开源** - MIT协议，免费商用，无需授权

## 🛠️ 技术栈

- **后端框架**: XiunoPHP
- **数据库**: MySQL 5.5+
- **前端框架**: Layui + LayuiMini
- **PHP版本**: 5.4+ (推荐 7.0+)
- **Web服务器**: Apache / Nginx / IIS

## 📦 系统要求

### 基础环境
- PHP 5.4 或更高版本（推荐 PHP 7.0+）
- MySQL 5.5 或更高版本（推荐 MySQL 5.7+）
- Apache / Nginx / IIS Web服务器

### PHP扩展要求
- PDO / MySQLi
- GD2 图形库
- cURL
- mbstring
- JSON

### 推荐配置
- PHP 7.4+
- MySQL 5.7+ / MariaDB 10.2+
- 内存 512MB+
- 磁盘空间 100MB+

## 🚀 快速开始

### 1. 下载安装

```bash
# 克隆项目
git clone https://github.com/Xwordsman/JisuCMS.git

# 或直接下载压缩包解压到网站根目录
```

### 2. 配置环境

将项目文件上传到Web服务器，确保以下目录可写：
- `runtime/cache/` - 运行缓存目录
- `runtime/log/` - 日志目录
- `upload/` - 上传文件目录
- `theme/` - 前台主题目录

### 3. 运行安装程序

访问 `http://yourdomain.com/install/` 开始安装：

1. 检查环境配置
2. 设置数据库信息
3. 配置管理员账号
4. 完成安装

### 4. 安全设置

安装完成后，请务必：
- 删除或重命名 `install` 目录
- 修改默认管理员密码
- 配置文件权限

### 5. 从旧版本升级（v1.2.0 → 主题目录改名）

> 自当前版本起，**前台主题目录由 `view/` 重命名为 `theme/`**，以更准确地表达"主题"语义。后台模板目录 `admin/view/` 与安装模板目录 `install/view/` 保持不变。

升级步骤：

1. 备份原 `view/` 目录
2. 将其整体重命名为 `theme/`（或新版本中已有的 `theme/` 与原 `view/` 内容合并）
3. 删除 `runtime/cache/_jisucms.php` 与 `runtime/cache/jisucms_view/`（如存在）
4. 后台 → 工具 → 清理缓存

常量与函数变更：

| 旧 | 新 | 说明 |
|---|---|---|
| `VIEW_PATH`（前台） | `THEME_PATH` | 仍保留 `VIEW_PATH` 作为前台别名，旧插件无需修改 |
| `VIEW_PATH`（后台） | `VIEW_PATH` | 不变，仍指向 `admin/view/` |
| `view_tpl_exists()` | `theme_tpl_exists()` | 旧函数名仍保留为别名 |
| `runtime/cache/jisucms_view/` | `runtime/cache/jisucms_theme/` | 前台模板编译缓存子目录 |

> 注：如果你的插件硬编码了 `'view/'` 子串拼接路径（而不是用 `VIEW_PATH` 常量），请改成 `'theme/'`。

## 📚 功能特性

### 内容管理
- ✅ 多模型内容管理（文章、图片、视频等）
- ✅ 分类管理（无限级分类）
- ✅ 标签系统
- ✅ 评论管理
- ✅ 附件管理
- ✅ 内容推荐/置顶/审核

### 用户系统
- ✅ 用户注册/登录
- ✅ 用户组权限管理
- ✅ 用户资料管理
- ✅ 积分系统

### 系统功能
- ✅ 插件扩展机制
- ✅ 主题模板系统
- ✅ 多语言支持（中文/英文）
- ✅ 伪静态URL
- ✅ 缓存管理
- ✅ 数据库备份/恢复
- ✅ 系统日志

### SEO优化
- ✅ 自定义URL规则
- ✅ TDK（标题、描述、关键词）设置
- ✅ 站点地图生成
- ✅ 友情链接管理
- ✅ Robots.txt配置

## 🎨 模板开发

极速CMS使用简洁的模板标签，开发门槛低：

```html
<!-- 文章列表示例 -->
{list:$list $v}
<article>
    <h2><a href="{$v[url]}">{$v[title]}</a></h2>
    <div class="meta">
        <span>作者：{$v[username]}</span>
        <span>时间：{$v[dateline]}</span>
    </div>
    <div class="content">{$v[intro]}</div>
</article>
{/list}
```

更多模板标签请参考：[模板开发文档](https://www.jisucms.com/docs/template)

## 🔌 插件开发

极速CMS采用AOP（面向切面编程）插件机制，开发简单：

```php
<?php
// 插件钩子示例
// hook: index_control_index_before.php

// 在首页控制器执行前运行
$message = '欢迎访问极速CMS！';
```

更多插件开发请参考：[插件开发文档](https://www.jisucms.com/docs/plugin)

## 📖 文档与支持

- 📘 [使用文档](https://www.jisucms.com/docs)
- 🎓 [视频教程](https://www.jisucms.com/video)
- 💬 [社区论坛](https://www.jisucms.com/forum)
- 🐛 [问题反馈](https://github.com/Xwordsman/JisuCMS/issues)
- 📧 联系邮箱：support@jisucms.com

## 🗂️ 目录结构

```
jisucms/
├── admin/              # 后台管理
│   ├── control/        # 后台控制器
│   ├── view/           # 后台视图
│   └── index.php       # 后台入口
├── jisucms/            # 系统核心
│   ├── block/          # 区块文件
│   ├── config/         # 配置文件
│   ├── control/        # 前台控制器
│   ├── lang/           # 语言包
│   ├── model/          # 数据模型
│   ├── plugin/         # 插件目录
│   └── xiunophp/       # 框架核心
├── install/            # 安装程序
├── runtime/            # 运行时目录
│   ├── cache/          # 运行缓存
│   └── log/            # 系统日志
├── static/             # 静态资源
│   ├── css/            # 样式文件
│   ├── js/             # 脚本文件
│   └── images/         # 图片资源
├── theme/              # 前台主题（v1.2.x 起由 view/ 重命名为 theme/）
│   └── default/        # 默认主题
├── upload/             # 上传文件
├── index.php           # 前台入口
├── robots.txt          # 搜索引擎协议
└── README.md           # 说明文档
```

## 🔧 配置说明

### 伪静态配置

**Apache (.htaccess)**
```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

**Nginx**
```nginx
location / {
    if (!-e $request_filename) {
        rewrite ^(.*)$ /index.php/$1 last;
    }
}
```

### 数据库配置

编辑 `jisucms/config/config.inc.php`：

```php
'db' => array(
    'type' => 'mysql',
    'master' => array(
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'password' => 'your_password',
        'name' => 'jisucms',
        'charset' => 'utf8mb4',
        'tablepre' => 'jisu_',
    ),
),
```

## 🤝 参与贡献

我们欢迎所有形式的贡献，包括但不限于：

1. 🐛 提交Bug报告
2. 💡 提出新功能建议
3. 📝 改进文档
4. 🔧 提交代码修复
5. 🎨 设计主题模板
6. 🔌 开发插件扩展

### 贡献流程

1. Fork 本仓库
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 提交 Pull Request

## 📜 开源协议

本项目采用 [MIT License](LICENSE) 开源协议。

您可以自由地：
- ✅ 商业使用
- ✅ 修改源代码
- ✅ 分发
- ✅ 私人使用

唯一要求：
- 📄 保留版权声明和许可声明

## 🙏 开源致谢

本项目在开发过程中参考并使用了以下开源项目和技术：

**项目基础：**
- LeCMS - MIT License - Copyright (c) 2023 dadadezhou

**技术框架：**
- XiunoPHP - 轻量级PHP框架
- Layui - 经典模块化前端框架
- LayuiMini - 后台管理模板

**极速CMS：**
- Copyright © 2026 极速CMS (JisuCMS)
- 开源协议：MIT License

感谢开源社区的无私贡献！

## 📞 联系我们

- 🌐 官方网站：[https://www.jisucms.com](https://www.jisucms.com)
- 📧 电子邮箱：support@jisucms.com
- 💬 QQ交流群：[待建立]
- 🐦 官方微博：[@极速CMS](https://weibo.com/jisucms)
- 📱 微信公众号：极速CMS

## ⭐ Star History

如果这个项目对您有帮助，请给我们一个 Star ⭐️

[![Star History Chart](https://api.star-history.com/svg?repos=yourusername/jisucms&type=Date)](https://star-history.com/#Xwordsman/jisucms&Date)

---

<p align="center">
  Made with ❤️ by JisuCMS Team
</p>

<p align="center">
  Copyright © 2026 极速CMS. All rights reserved.
</p>
