# 极速CMS 目录结构说明

本文档详细说明了极速CMS的目录结构和各个文件的作用。

---

## 📁 根目录结构

```
jisucms/
├── admin/              # 后台管理目录
├── install/            # 安装程序目录
├── jisucms/            # 核心程序目录
├── log/                # 日志文件目录
├── runcache/           # 运行缓存目录
├── static/             # 静态资源目录
├── upload/             # 上传文件目录
├── view/               # 前台模板目录
├── index.php           # 前台入口文件
├── README.md           # 项目说明文档
├── README.en.md        # 英文说明文档
├── DIRECTORY.md        # 目录结构说明（本文件）
├── CHANGELOG.md        # 更新日志
└── LICENSE             # 开源协议
```

---

## 🔧 核心目录详解

### 1. admin/ - 后台管理目录

**建议**: 为了安全，建议修改此文件夹名称

```
admin/
├── control/            # 后台控制器目录
│   ├── admin_control.class.php          # 管理员管理
│   ├── attach_control.class.php         # 附件管理
│   ├── category_control.class.php       # 分类管理
│   ├── cms_page_control.class.php       # 单页管理
│   ├── comment_control.class.php        # 评论管理
│   ├── content_control.class.php        # 内容管理
│   ├── db_control.class.php             # 数据库管理
│   ├── flags_control.class.php          # 属性管理
│   ├── index_control.class.php          # 后台首页
│   ├── models_control.class.php         # 模型管理
│   ├── my_control.class.php             # 个人中心
│   ├── navigate_control.class.php       # 导航管理
│   ├── plugin_control.class.php         # 插件管理
│   ├── setting_control.class.php        # 系统设置
│   ├── tag_control.class.php            # 标签管理
│   ├── theme_control.class.php          # 主题管理
│   ├── tool_control.class.php           # 工具管理
│   ├── user_control.class.php           # 用户管理
│   └── user_group_control.class.php     # 用户组管理
├── view/               # 后台视图目录
│   └── default/        # 默认后台主题
└── index.php           # 后台入口文件
```

**访问地址**: `http://你的域名/admin/`

---

### 2. install/ - 安装程序目录

**重要**: 安装完成后，请务必删除此目录！

```
install/
├── css/                # 安装程序样式
├── data/               # 数据库SQL文件
│   ├── mysql.sql       # 数据库结构
│   └── mysql_data.sql  # 初始数据
├── lang/               # 安装程序语言包
│   ├── zh-cn.php       # 简体中文
│   └── en.php          # 英文
├── view/               # 安装程序视图
├── config.sample.php   # 配置文件模板
├── plugin.sample.php   # 插件配置模板
├── route.sample.php    # 路由配置模板
├── function.php        # 安装函数
├── index.php           # 安装入口
├── mysql.install.php   # MySQL安装类
├── mysqli.install.php  # MySQLi安装类
└── pdo_mysql.install.php # PDO MySQL安装类
```

**访问地址**: `http://你的域名/install/`

---

### 3. jisucms/ - 核心程序目录

这是系统的核心目录，包含所有核心功能代码。

```
jisucms/
├── block/              # 模板标签文件目录
│   ├── block_list.lib.php              # 内容列表标签
│   ├── block_category.lib.php          # 分类标签
│   ├── block_comment.lib.php           # 评论标签
│   ├── block_navigate.lib.php          # 导航标签
│   ├── block_tag*.lib.php              # 标签相关
│   └── ...                             # 更多标签
├── config/             # 配置文件目录（安装后生成）
│   ├── conf.php        # 主配置文件
│   ├── plugin.php      # 插件配置
│   └── route.php       # 路由配置
├── control/            # 前台控制器目录
│   ├── index_control.class.php         # 首页控制器
│   ├── cate_control.class.php          # 分类控制器
│   ├── show_control.class.php          # 内容页控制器
│   ├── search_control.class.php        # 搜索控制器
│   ├── tag_control.class.php           # 标签控制器
│   ├── comment_control.class.php       # 评论控制器
│   ├── my_control.class.php            # 用户中心控制器
│   └── ...                             # 更多控制器
├── lang/               # 语言包目录
│   ├── zh-cn.php       # 简体中文（前台）
│   └── zh-cn_admin.php # 简体中文（后台）
├── model/              # 数据模型目录
│   ├── cms_category_model.class.php    # 分类模型
│   ├── cms_content_model.class.php     # 内容模型
│   ├── cms_comment_model.class.php     # 评论模型
│   ├── cms_tag_model.class.php         # 标签模型
│   ├── user_model.class.php            # 用户模型
│   └── ...                             # 更多模型
├── plugin/             # 插件目录
│   ├── links/          # 友情链接插件
│   ├── editor_um/      # 富文本编辑器插件
│   ├── sitemaps/       # 网站地图插件
│   ├── spider/         # 蜘蛛统计插件
│   ├── database/       # 数据库管理插件
│   └── ...             # 更多插件
└── xiunophp/           # XiunoPHP框架目录
    ├── lib/            # 框架核心库
    ├── tpl/            # 框架模板
    └── xiunophp.php    # 框架入口
```

---

### 4. view/ - 前台模板目录

```
view/
└── default/            # 默认主题
    ├── style/          # 样式文件
    ├── script/         # 脚本文件
    ├── img/            # 图片文件
    ├── user/           # 用户中心模板
    ├── info.ini        # 主题配置文件
    └── *.htm           # 模板文件（见下方详细说明）
```

---

## 📄 模板文件说明

### 公共模板

| 文件名 | 说明 |
|--------|------|
| `inc-header.htm` | 共用头部模板 |
| `inc-footer.htm` | 共用底部模板 |
| `inc-about.htm` | 关于页面模板 |

### 主要页面模板

| 文件名 | 说明 | 用途 |
|--------|------|------|
| `index.htm` | 首页模板 | 网站首页 |
| `article_index.htm` | 文章频道页模板 | 文章频道首页 |
| `article_list.htm` | 文章列表页模板 | 分类文章列表 |
| `article_show.htm` | 文章内容页模板 | 文章详情页 |
| `page_show.htm` | 单页分类模板 | 单页内容（如关于我们） |
| `search.htm` | 搜索结果页模板 | 搜索结果展示 |
| `404.htm` | 404错误页模板 | 页面不存在提示 |
| `close_website.htm` | 关闭站点提示模板 | 网站维护提示（v1.0.0+） |

### 标签相关模板

| 文件名 | 说明 |
|--------|------|
| `tag_list.htm` | 标签内容列表分页模板 |
| `tag_top.htm` | 热门标签模板 |
| `tag_all.htm` | 全部标签分页模板 |

### 评论模板

| 文件名 | 说明 |
|--------|------|
| `comment.htm` | 评论页模板（后台-评论管理-点击查看） |

### 其他模板

| 文件名 | 说明 | 版本 |
|--------|------|------|
| `flags.htm` | 属性内容分页模板 | v1.0.0+ |
| `space.htm` | 用户信息和用户内容分页模板 | v1.0.0+ |

---

## 👤 用户中心模板 (user/ 目录)

| 文件名 | 说明 |
|--------|------|
| `user/login.htm` | 登录页模板 |
| `user/register.htm` | 注册页模板 |
| `user/forget_password.htm` | 忘记密码模板 |
| `user/reset_password.htm` | 重置密码模板 |
| `user/my_index.htm` | 用户中心首页模板 |
| `user/my_password.htm` | 修改密码模板 |
| `user/my_profile.htm` | 修改用户信息模板 |
| `user/my_contents.htm` | 用户已发布内容模板 |
| `user/my_comments.htm` | 用户已发布评论模板 |
| `user/inc-menu.htm` | 用户中心菜单模板 |
| `user/user_all.htm` | 用户分页模板（v1.0.0+） |

---

## 📦 其他目录

### log/ - 日志目录
存储系统运行日志，用于调试和错误追踪。

### runcache/ - 运行缓存目录
存储系统运行时生成的缓存文件，可定期清理。

### static/ - 静态资源目录
```
static/
├── css/                # 样式文件
├── js/                 # JavaScript文件
├── img/                # 图片文件
├── layui/              # Layui UI框架
└── ...                 # 其他静态资源
```

### upload/ - 上传文件目录
存储用户上传的图片和附件，需要设置为可写权限。

```
upload/
├── image/              # 图片文件
├── file/               # 附件文件
└── ...                 # 其他上传文件
```

---

## 🔒 权限设置

以下目录需要设置为可写权限（777 或 755）：

- `jisucms/config/` - 配置文件目录
- `upload/` - 上传文件目录
- `log/` - 日志目录
- `runcache/` - 运行缓存目录

**Linux/Unix 设置命令**:
```bash
chmod -R 755 jisucms/config/
chmod -R 755 upload/
chmod -R 755 log/
chmod -R 755 runcache/
```

---

## 📝 注意事项

1. **安全建议**
   - 安装完成后删除 `install/` 目录
   - 修改 `admin/` 目录名称
   - 定期备份 `upload/` 和数据库

2. **性能优化**
   - 定期清理 `runcache/` 缓存
   - 定期清理 `log/` 日志文件
   - 使用CDN加速 `static/` 静态资源

3. **开发建议**
   - 不要直接修改核心文件
   - 使用插件扩展功能
   - 使用主题自定义外观
   - 遵循框架规范开发

---

## 🔗 相关文档

- [README.md](README.md) - 项目说明
- [CHANGELOG.md](CHANGELOG.md) - 更新日志
- [官方文档](https://www.jisucms.com/docs) - 完整文档
- [模板开发手册](https://www.jisucms.com/template) - 模板开发
- [插件开发指南](https://www.jisucms.com/plugin) - 插件开发

---

**文档版本**: v1.0.0  
**更新日期**: 2026-04-23  
**维护者**: JisuCMS Team
