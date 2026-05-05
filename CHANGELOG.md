# 更新日志

所有重要的项目变更都将记录在此文件中。

本项目遵循 [语义化版本](https://semver.org/lang/zh-CN/) 规范。

## [Unreleased]

### 新增
- 待发布的新功能

### 变更
- 待发布的功能变更

### 修复
- 待发布的问题修复

## [1.2.0] - 2026-05-04

### 变更
- **重要变更**：版本号获取方式统一优化
  - 彻底迁移到新版本号系统，所有代码统一使用 `JISUCMS_VERSION` 常量
  - 废弃旧的 `C('version')` 获取方式，改为直接使用版本常量
  - 修改了错误页面、异常页面、插件安装检查中的版本号获取方式
  - 提升了版本号获取的性能和一致性

### 修复
- 修复插件安装时版本检查失败的问题（`C('version')` 返回 null）
- 修复错误页面和异常页面无法正确显示版本号的问题

### 技术细节
- 修改文件：
  - `jisucms/xiunophp/tpl/sys_error.php` - 错误页面版本号显示
  - `jisucms/xiunophp/tpl/exception.php` - 异常页面版本号显示
  - `admin/control/plugin_control.class.php` - 插件安装版本检查
- 新增文档：`docs/版本号系统迁移说明.md` - 详细的迁移说明和使用规范

### 开发者注意事项
- 如果你的插件或主题中使用了 `C('version')`，请改为使用 `JISUCMS_VERSION` 常量
- 模板中使用 `{php}echo JISUCMS_VERSION;{/php}` 显示版本号
- PHP代码中直接使用 `JISUCMS_VERSION` 常量获取版本号

## [1.1.0] - 2026-05-04

### 新增
- 新增单独的搜索页面（非搜索结果页），模板中可使用 `{$search_url}` 链接
- 新增用户自定义函数钩子 `misc_func.php`，插件可实现该钩子调用自定义函数
- 单页分类新增评论功能，可直接实现留言板功能（参考 `page_message.htm` 模板）

### 变更
- 升级 Layui 到 2.8.15 版本（LayuiMini 二开版本）
- URL生成函数迁移到 `urls_model.class.php`（不含分类URL、内容URL、标签URL、评论URL）
- **重要变更**：版本号管理方式优化
  - 版本号现在统一定义在 `jisucms/config/version.inc.php` 文件中
  - 使用常量：`JISUCMS_VERSION`、`JISUCMS_RELEASE`、`JISUCMS_VERSION_NAME`、`JISUCMS_BUILD`
  - 三个入口文件（`index.php`、`admin/index.php`、`install/index.php`）自动加载版本信息
  - 用户升级时覆盖文件即可自动更新版本号，无需手动修改配置
- **破坏性变更**：修改了分类、内容、标签的 URL 函数传递参数，涉及该函数的插件需要更新（如：分类筛选、推送、地图等插件）

### 修复
- 修复多个小功能问题和 Bug

### 注意事项
- 如果使用了分类筛选、推送、地图等插件，升级后需要更新这些插件以适配新的 URL 函数参数
- 自定义函数写法可参考 `jisucms/xiunophp/lib/misc.func.php` 中的说明
- 版本号统一在 `jisucms/config/version.inc.php` 中管理，升级时会自动更新

## [1.0.0] - 2026-05-04

### 新增
- 初始版本发布
- 完成品牌重构（JisuCMS）
- 安装系统优化
- 后台界面调整
- 版本控制系统
- 自动化发布脚本

### 技术栈
- 后端框架：XiunoPHP
- 前端框架：Layui 2.8.15 + LayuiMini
- 数据库：MySQL 5.5+
- PHP版本：5.4+（推荐 7.0+）

[Unreleased]: https://github.com/Xwordsman/JisuCMS/compare/v1.2.0...HEAD
[1.2.0]: https://github.com/Xwordsman/JisuCMS/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/Xwordsman/JisuCMS/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/Xwordsman/JisuCMS/releases/tag/v1.0.0
