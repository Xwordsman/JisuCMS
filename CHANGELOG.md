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

## [1.5.0] - 2026-05-06

### 新增
1. **插件 Hook 系统支持按作用域分类的子目录**
   - 文件：`jisucms/xiunophp/lib/core.class.php` `process_hook()`
   - 在原有 2 个查找位置（插件根、`hook/`）的基础上，新增 6 个分类子目录：
     - `hook_admin/` — 后台相关 hook
     - `hook_control/` — 前台控制器 hook
     - `hook_model/` — 模型 hook
     - `hook_block/` — 区块（block）hook
     - `hook_theme/` — 主题/前台模板 hook
     - `hook_lang/` — 语言相关 hook
   - 完全向后兼容：旧有"平铺在插件根"或放在"`hook/`"下的写法继续工作
   - 多目录同时命中同名文件时，按"插件根 → hook → hook_admin → hook_control → hook_model → hook_block → hook_theme → hook_lang"顺序合并执行
   - 性能开销：每次 hook 调用每个启用插件多 5~6 次 `is_file()` 检查，可忽略
   - 升级须知：升级后需删除 `runtime/cache/_jisucms.php`（框架打包缓存），以便新逻辑生效；或后台 → 工具 → 清理缓存
2. **恢复后台"URL 后缀（`url_suffix`）"配置项**
   - 之前 `admin/control/setting_control.class.php` 的 GET 与 POST 处理被注释，导致后台无法修改该项，只能手改 `jisucms/config/config.inc.php`
   - 现已恢复完整流程：界面输入框、POST 接收、写回 `config.inc.php`
   - 模板 `admin/view/default/setting_other.htm` 在"后台布局"下方新增"URL 后缀"输入框，附 tips
   - 语言包新增 `url_suffix_tips` 键（zh-cn / en）
   - 写回正则由 `'(.)*'` 收紧为 `'[^']*'`，更安全

### 变更
1. **系统配置字段重命名（更简洁、更国际化）**
   - 利用品牌重构窗口期，去除多余的 `web` 前缀，统一为通用字段名：
     - `webmail` → `email`
     - `webqq` → `qq`
     - `webweixin` → `wechat`（去拼音化）
     - `webtel` → `phone`（更标准）
   - 涉及 6 个文件：
     - `install/index.php` — kv 表初始化默认值
     - `admin/control/setting_control.class.php` — 表单读写（GET 构造 + POST 持久化）
     - `admin/view/default/setting_index.htm` — 后台基本设置页
     - `jisucms/lang/zh-cn_admin.php`、`jisucms/lang/en_admin.php` — 中英语言键（英文 `Tel` 顺带改 `Phone`）
     - `theme/default/inc-footer.htm` — 前台默认主题底部联系信息
   - 此为**破坏性重命名**：因品牌重构后无历史用户/插件/主题，不再保留旧键兼容
3. **`block_data_total` 数据统计区块：内容数 / 标签数也支持大数缩写**
   - 文件：`jisucms/block/block_data_total.lib.php`
   - 之前仅 `views`（浏览量）做了 `> 100W → 100W+`、`> 10W → 10W+` 的缩写
   - 现在 `content`（内容数）、`tag`（标签数）也使用相同格式化
   - 抽取 `block_data_total_format()` 辅助函数，消除原 `views` 在两处分支的重复代码（共 4 处统一为函数调用）
   - `comment`（评论数）、`category`（分类数）保持原值显示，因为这两类数量极少超过 10 万
   - 注意：格式化后字段在大数据时为字符串 `"100W+"`，模板中如直接输出无影响；如需做加法等数值运算请用其他字段
4. **上传扩展名白名单：默认值扩充（极简方案）**
   - 文件：`install/index.php`（仅对**新装站点**生效）
   - 图片白名单：`jpg,jpeg,gif,png,webp` → `jpg,jpeg,gif,png,webp,bmp,heic,heif`
     - 新增 `bmp`（Windows 截图）、`heic`/`heif`（iPhone 默认拍照格式）
   - 附件白名单：`zip,gz,rar,iso,xls,xlsx,csv,doc,docx,ppt,wps,txt,pdf` → `zip,gz,rar,7z,tar,iso,xls,xlsx,csv,doc,docx,ppt,pptx,wps,txt,md,pdf,mp3,mp4`
     - 新增压缩：`7z`、`tar`
     - 新增文档：`pptx`（之前只有 `ppt`）、`md`（Markdown）
     - 新增媒体：`mp3`、`mp4`
   - **已装站点不会自动生效**，需在 后台 → 设置 → 上传设置 手动复制粘贴新清单
   - 安全考量：仍未默认包含 `svg`（XSS 风险）、可执行脚本类（php/asp/jsp/exe 等）
5. **数据库编码全面升级到 `utf8mb4`，全面支持 emoji**
   - 系统主表（14 张）已为 `utf8mb4`，本次修复以下遗漏点：
   - `install/index.php`：自动建库时 `$charset` 由 `utf8` 改为 `utf8mb4`
   - `install/config.sample.php`：从库示例 `'charset' => 'utf8'` 同步主库改为 `utf8mb4`
   - `plugin/le_links/install.php`：`links` 表建表 SQL 由 `utf8/utf8_general_ci` 升级到 `utf8mb4/utf8mb4_general_ci`
   - `jisucms/xiunophp/db/db_pdo_mysql.class.php`：通用 `create_table` 与 `connect` 默认字符集
   - `jisucms/xiunophp/db/db_mysqli.class.php`：`framework_maxid`、`framework_count`、`create_table`、`connect` 共 4 处
   - `jisucms/xiunophp/db/db_mysql.class.php`：同上 4 处（老 mysql_ 扩展，PHP 7+ 已无法使用，仅保持代码一致性）
   - 全部统一使用 `utf8mb4_general_ci` 排序规则，与现有系统主表保持一致

### 移除
1. **剔除"数据库操作"模块（数据字典）**
   - 后台菜单"工具管理 → 数据字典"移除
   - 删除文件：
     - `admin/control/db_control.class.php`
     - `admin/view/default/db_index.htm`
     - `admin/view/default/db_table_structure.htm`
   - 移除语言键（zh/en）：`db_dictionary`、`db_tips`、`optimize_table`、`repair_table`、`check_table`、`table_structure`、`db_table_*` 共 14 个
   - 后续将通过插件形式重新提供（暂未实现）
2. **剔除"网站地图"模块**
   - 后台菜单"设置 → 地图设置"移除
   - 删除文件：
     - `jisucms/control/sitemap_control.class.php`（前台路由 + 内嵌 baidusitemap 类）
     - `theme/default/sitemap.htm`（前台 HTML 地图模板）
     - `admin/view/default/setting_sitemap.htm`（后台配置模板）
   - 修改文件：
     - `admin/control/setting_control.class.php` 删除 `sitemap()` 方法（约 100 行）
     - `jisucms/control/parseurl_control.class.php` 移除硬编码 `sitemap.xml/html/txt` 路由识别（保留注释路标）
   - 移除语言键（zh/en）：`sitemap_setting`
   - 移除 `install/data/mysql_data.sql` 中 `link_keywords` 数组里的 `sitemap` 保留字（核心不再为已移除的功能预留资源；未来若插件重新启用 sitemap 路由，由插件 `install.php` 自行注册即可）
   - 后续将通过插件形式重新提供（暂未实现）

### 规划（已评估，留作未来插件）

> 以下功能经评估，决定不放入核心，留给后续插件实现。统一设计哲学：核心精简、运维/SEO 类功能通过插件提供。

1. **数据库工具插件**（原核心"数据字典"已剔除，详见 `### 移除`）
   - 表列表、优化/修复/检查、查看表结构等
2. **网站地图插件**（原核心 sitemap 已剔除，详见 `### 移除`）
   - 前台 `/sitemap.xml/.html/.txt` 路由 + 后台地图配置
   - 插件 `install.php` 自行注册 `sitemap` 保留字到 `link_keywords`
3. **Cron 任务插件**（免登录清缓存）
   - 新增前台路由 `/index.php?cron-XXX-token-YYY`，token 校验通过则执行
   - 至少包含：清缓存（dbcache + filecache）
   - 可扩展：定时重新统计、定时备份、定时发邮件摘要等
   - 后台 UI：token 展示与重置、IP 白名单、调用日志
   - 插件 `install.php` 自行注册 `cron` 保留字到 `link_keywords`

### 修复
- 本次未涉及

## [1.4.0] - 2026-05-06

### 变更
- **重要变更**：插件目录由 `jisucms/plugin/` 上提到项目根目录 `plugin/`
  - 与 `theme/`、`upload/` 保持同一层级，整体结构更清晰
  - `PLUGIN_PATH` 常量值由 `APP_PATH.'plugin/'` 改为 `ROOT_PATH.'plugin/'`
  - 框架内 50+ 处插件路径引用全部走 `PLUGIN_PATH` 常量，自动适配
- 安装程序写权限检查项 `jisucms/plugin` 改为 `plugin`
- 后台插件管理页面 `admin/view/default/plugin_index.htm` 中 3 处图片 URL 由 `../jisucms/plugin/` 改为 `../plugin/`

### 兼容性
- 插件内部代码若通过 `PLUGIN_PATH` 常量访问路径，**无需任何修改**
- 仅当插件硬编码了字符串 `jisucms/plugin/` 才需改为 `plugin/`（较罕见）
- 插件配置文件位置不变，仍位于 `jisucms/config/plugin.inc.php`

### 升级须知
- 物理移动：`jisucms/plugin/` → `plugin/`
- 后台 → 工具 → 清理缓存
- 删除 `runtime/cache/_jisucms.php`（如存在）

### 技术细节
- 修改文件：
  - `jisucms/xiunophp/xiunophp.php` - `PLUGIN_PATH` 常量定义改为 `ROOT_PATH.'plugin/'`
  - `install/view/check_env.php` - 安装写权限检查目录更新
  - `admin/view/default/plugin_index.htm` - 后台插件页 3 处图片路径更新
- 物理变更：`jisucms/plugin/` 整体移动到 `plugin/`

## [1.3.0] - 2026-05-06

### 变更
- **重要变更**：前台主题目录由 `view/` 重命名为 `theme/`，语义更准确
  - 后台模板目录 `admin/view/` 与安装模板目录 `install/view/` 保持不变
  - 框架新增常量 `THEME_PATH`，前台代码统一使用 `THEME_PATH` 指向主题目录
  - 后台模板路径常量仍为 `VIEW_PATH`（指向 `admin/view/`）
- 新增函数 `theme_tpl_exists()`，替代原 `view_tpl_exists()`
- 前台模板编译缓存子目录 `runtime/cache/jisucms_view/` 改为 `jisucms_theme/`
- README 新增"从旧版本升级"小节，提供完整迁移指引

### 兼容性
- 前台保留 `VIEW_PATH` 作为 `THEME_PATH` 的别名，硬编码 `VIEW_PATH` 常量的旧插件无需修改即可继续工作
- 保留 `view_tpl_exists()` 函数作为 `theme_tpl_exists()` 的别名
- 安装/升级程序自动清理新旧两套缓存子目录（`_view`、`_theme`）

### 升级须知
- 物理重命名 `view/` → `theme/`，或将原 `view/` 内容合并到新版的 `theme/`
- 删除 `runtime/cache/_jisucms.php` 与 `runtime/cache/jisucms_view/`（如存在）
- 后台 → 工具 → 清理缓存
- 若插件硬编码了字符串 `'view/'` 拼接路径（而非使用 `VIEW_PATH` 常量），请改为 `'theme/'`

### 技术细节
- 修改文件：
  - `jisucms/xiunophp/xiunophp.php` - 新增 `THEME_PATH` 常量及 `VIEW_PATH` 兼容别名
  - `jisucms/xiunophp/lib/view.class.php` - 模板根路径与缓存子目录前后台分流
  - `jisucms/xiunophp/lib/base.func.php` - 新增 `theme_tpl_exists()`，保留 `view_tpl_exists()` 别名
  - `jisucms/xiunophp/tpl/exception.php`、`tpl/sys_trace.php` - 调试页路径前后台兼容
  - `jisucms/control/base_control.class.php` - 站点关闭模板检测改用 `THEME_PATH`
  - `jisucms/model/runtime_model.class.php` - `$cfg['tpl']` URL 段 `view/` → `theme/`
  - `admin/control/theme_control.class.php` - 主题管理 5 处路径更新
  - `install/view/check_env.php` - 安装写权限检查目录更新
  - `install/index.php` - 缓存清理兼容新旧子目录
- 物理变更：根目录 `view/` 重命名为 `theme/`

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

[Unreleased]: https://github.com/Xwordsman/JisuCMS/compare/v1.5.0...HEAD
[1.5.0]: https://github.com/Xwordsman/JisuCMS/compare/v1.4.0...v1.5.0
[1.4.0]: https://github.com/Xwordsman/JisuCMS/compare/v1.3.0...v1.4.0
[1.3.0]: https://github.com/Xwordsman/JisuCMS/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/Xwordsman/JisuCMS/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/Xwordsman/JisuCMS/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/Xwordsman/JisuCMS/releases/tag/v1.0.0
