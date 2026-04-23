# 极速CMS (JisuCMS)

<p align="center">
  <strong>轻量级、高性能的PHP内容管理系统</strong>
</p>

<p align="center">
  <a href="#主要特性">特性</a> •
  <a href="#快速开始">快速开始</a> •
  <a href="#系统要求">系统要求</a> •
  <a href="#文档">文档</a> •
  <a href="#社区">社区</a>
</p>

---

## 📋 项目信息

- **当前版本**: v1.0.0
- **发布日期**: 2026-04-23
- **开源协议**: MIT License
- **官方网站**: [www.jisucms.com](https://www.jisucms.com)
- **技术架构**: PHP & MySQL
- **核心框架**: XiunoPHP

---

## 💡 项目介绍

极速CMS（JisuCMS）是一款基于 XiunoPHP 框架开发的轻量级、高性能内容管理系统。采用 PHP & MySQL 架构，专为千万级大数据网站设计，具有出色的性能表现和灵活的扩展能力。

### 为什么选择极速CMS？

- 🚀 **极致性能** - 单表支持亿级数据，懒加载设计，速度惊人
- 🔌 **强大插件** - AOP插件机制，零性能损耗，轻松扩展功能
- 🎨 **简洁易用** - 只做核心功能，其他通过插件实现
- 📱 **响应式后台** - 支持电脑、平板、手机等各类设备
- 🔍 **SEO友好** - 灵活的URL设置，助力搜索引擎收录
- 💰 **完全免费** - MIT协议，商用无需授权

---

## 🎯 主要特性

### 核心功能

#### 1. 高性能架构
- 懒加载机制，按需加载资源
- 分布式服务器设计
- 单表支持亿级数据量
- 强大的缓存技术

#### 2. 灵活的插件系统
- AOP（面向切面）插件机制
- 零性能损耗
- 强大的HOOK功能
- 轻松实现功能扩展

#### 3. 便捷的模板系统
- 高效简洁的模板标签
- 只需懂HTML和CSS即可开发
- 建站成本低、周期短
- 支持自定义主题

#### 4. 响应式管理后台
- 基于 Layui + LayuiMini 开发
- 完美适配各类设备
- 简洁美观的界面设计
- 良好的用户体验

#### 5. 强大的SEO功能
- 内置多种SEO设置
- 灵活的URL路径配置
- 支持伪静态
- 自定义SEO规则

#### 6. 自定义内容模型
- 支持自定义模型（插件）
- 自定义字段扩展
- 适合不同业务场景
- 千万级数据分表存储

---

## 🚀 快速开始

### 系统要求

| 环境 | 最低要求 | 推荐配置 |
|------|---------|---------|
| PHP | 5.5+ | 7.0+ |
| MySQL | 5.0+ | 5.7+ |
| Web服务器 | Apache/Nginx | Nginx |
| PHP扩展 | mysql/mysqli/pdo_mysql | mysqli |

### 安装步骤

1. **下载源码**
   ```bash
   git clone https://github.com/你的用户名/jisucms.git
   cd jisucms
   ```

2. **配置Web服务器**
   - 将网站根目录指向项目目录
   - 确保 `jisucms/config/` 目录可写
   - 确保 `upload/` 目录可写

3. **运行安装程序**
   - 访问 `http://你的域名/install/`
   - 按照安装向导完成配置
   - 设置数据库信息和管理员账号

4. **完成安装**
   - 删除 `install/` 目录（重要！）
   - 访问后台：`http://你的域名/admin/`
   - 开始使用极速CMS

### 伪静态配置

#### Nginx
```nginx
location / {
    if (!-e $request_filename) {
        rewrite ^(.*)$ /index.php?$1 last;
    }
}
```

#### Apache
在网站根目录创建 `.htaccess` 文件：
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?$1 [QSA,PT,L]
</IfModule>
```

---

## 📚 文档

### 项目文档

- 📖 [English Documentation](README.en.md) - 英文文档
- 📁 [目录结构说明](DIRECTORY.md) - 详细的目录和文件说明
- 📝 [更新日志](CHANGELOG.md) - 版本更新记录

### 官方资源

- 📖 [使用文档](https://www.jisucms.com/docs)
- 🎨 [模板开发手册](https://www.jisucms.com/template)
- 🔌 [插件开发指南](https://www.jisucms.com/plugin)
- 💬 [常见问题](https://www.jisucms.com/faq)

### 目录结构

```
jisucms/
├── admin/              # 后台管理目录
│   ├── control/        # 后台控制器
│   └── view/           # 后台视图
├── install/            # 安装程序（安装后删除）
├── jisucms/            # 核心程序目录
│   ├── block/          # 模板标签
│   ├── config/         # 配置文件
│   ├── control/        # 前台控制器
│   ├── lang/           # 语言包
│   ├── model/          # 数据模型
│   ├── plugin/         # 插件目录
│   └── xiunophp/       # XiunoPHP框架
├── static/             # 静态资源
├── upload/             # 上传文件目录
├── view/               # 前台主题目录
│   └── default/        # 默认主题
├── index.php           # 入口文件
└── README.md           # 说明文档
```

---

## 🌟 核心优势

### 性能表现

- ⚡ **极速响应** - 优化的代码结构，毫秒级响应
- 📊 **大数据支持** - 单表亿级数据无压力
- 🔄 **智能缓存** - 多级缓存机制，减少数据库查询
- 🚀 **高并发** - 支持分布式部署，轻松应对高并发

### 开发体验

- 🎯 **简单易用** - 清晰的代码结构，易于理解和维护
- 🔧 **灵活扩展** - 强大的插件和钩子系统
- 📝 **规范代码** - 遵循PSR规范，代码整洁规范
- 🛠️ **二次开发** - 完善的文档，便于二次开发

### 安全可靠

- 🔒 **安全防护** - 内置XSS、SQL注入等安全防护
- 🔑 **权限管理** - 完善的用户权限体系
- 📋 **数据备份** - 支持数据库备份和恢复
- 🔐 **加密存储** - 敏感数据加密存储

---

## 🎨 主题与插件

### 官方资源

- 🎨 [主题市场](https://www.jisucms.com/themes) - 精美的主题模板
- 🔌 [插件中心](https://www.jisucms.com/plugins) - 丰富的功能插件
- 📦 [扩展开发](https://www.jisucms.com/dev) - 开发文档和工具

### 内置插件

- 📝 **富文本编辑器** - 基于UEditor Mini
- 🔗 **友情链接** - 链接管理插件
- 🗺️ **网站地图** - 自动生成sitemap
- 🕷️ **蜘蛛统计** - 搜索引擎爬虫统计
- 💾 **数据库管理** - 数据库备份恢复

---

## 👥 社区

### 加入我们

- 🌐 **官方网站**: [www.jisucms.com](https://www.jisucms.com)
- 💬 **QQ交流群**: 待定（欢迎加入）
- 📧 **问题反馈**: [GitHub Issues](https://github.com/你的用户名/jisucms/issues)
- 📖 **开发文档**: [www.jisucms.com/docs](https://www.jisucms.com/docs)

### 参与贡献

我们欢迎所有形式的贡献，包括但不限于：

1. 🐛 **报告Bug** - 提交Issue描述问题
2. 💡 **功能建议** - 分享你的想法和建议
3. 📝 **完善文档** - 帮助改进文档
4. 💻 **提交代码** - Fork项目并提交Pull Request

#### 贡献步骤

```bash
# 1. Fork 本仓库
# 2. 创建特性分支
git checkout -b feature/AmazingFeature

# 3. 提交更改
git commit -m 'Add some AmazingFeature'

# 4. 推送到分支
git push origin feature/AmazingFeature

# 5. 提交 Pull Request
```

---

## 🙏 特别感谢

极速CMS 的诞生离不开以下优秀的开源项目：

- **[XiunoPHP](https://github.com/xiuno/xiunophp)** - 轻量级PHP框架
- **[Layui](https://layui.dev/)** - 经典模块化前端UI框架
- **[LayuiMini](http://layuimini.99php.cn/)** - 基于Layui的后台管理模板
- **[LeCMS](https://www.lecms.cc)** - 原始项目，为极速CMS提供了基础

感谢所有为开源社区做出贡献的开发者！

---

## 📄 开源协议

本项目采用 [MIT License](LICENSE) 开源协议。

这意味着您可以：

- ✅ 商业使用
- ✅ 修改源代码
- ✅ 分发
- ✅ 私人使用

唯一的要求是：

- 📋 保留版权声明和许可声明

---

## 📮 联系方式

- **官方网站**: [www.jisucms.com](https://www.jisucms.com)
- **技术支持**: 通过官网获取
- **商务合作**: 通过官网联系

---

## 🗺️ 发展路线

### v1.0.0 (当前版本)
- ✅ 完整的品牌重塑
- ✅ 核心功能稳定
- ✅ 基础插件支持
- ✅ 响应式后台

### v1.1.0 (计划中)
- 🔄 性能优化
- 🔄 插件市场
- 🔄 主题市场
- 🔄 在线更新

### v1.2.0 (规划中)
- 📅 API接口
- 📅 移动端优化
- 📅 多语言支持
- 📅 更多插件

### v2.0.0 (远期规划)
- 🎯 架构升级
- 🎯 前后端分离
- 🎯 微服务支持
- 🎯 云原生部署

---

<p align="center">
  <strong>如果这个项目对您有帮助，请给我们一个 ⭐ Star！</strong>
</p>

<p align="center">
  Made with ❤️ by JisuCMS Team
</p>

<p align="center">
  Copyright © 2026 <a href="https://www.jisucms.com">JisuCMS</a>
</p>
