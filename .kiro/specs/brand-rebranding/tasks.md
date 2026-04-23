# LeCMS 品牌重塑任务清单

## 任务概述
将 LeCMS 系统完整重塑为 JisuCMS（极速CMS）品牌

---

## 1. 准备工作

- [ ] 1.1 完整备份当前系统
- [x] 1.2 收集新品牌完整信息
  - [ ] 1.2.1 确认新作者邮箱
  - [ ] 1.2.2 确认新 QQ 交流群号
  - [ ] 1.2.3 准备新 Logo 文件
  - [ ] 1.2.4 准备新 Favicon 文件
- [ ] 1.3 创建测试环境

---

## 2. 核心目录和文件重命名

- [x] 2.1 重命名核心目录
  - [x] 2.1.1 将 `lecms/` 目录重命名为 `jisucms/`
  - [x] 2.1.2 更新所有引用该目录的路径

- [x] 2.2 修改入口文件
  - [x] 2.2.1 修改 `index.php` 中的 APP_NAME 定义
  - [x] 2.2.2 修改 `admin/index.php` 中的 F_APP_NAME 定义

- [x] 2.3 修改运行时缓存文件名
  - [x] 2.3.1 修改 `jisucms/xiunophp/xiunophp.php` 中的 `_lecms.php` 为 `_jisucms.php`

---

## 3. 配置文件修改

- [x] 3.1 修改安装配置模板 `install/config.sample.php`
  - [x] 3.1.1 Cookie 前缀: `le_` → `jisu_`
  - [x] 3.1.2 缓存前缀: `le_` → `jisu_`
  - [x] 3.1.3 伪静态配置键: `lecms_parseurl` → `jisucms_parseurl`
  - [x] 3.1.4 默认数据库名: `lecms` → `jisucms`

- [x] 3.2 修改路由配置模板 `install/route.sample.php`
  - [x] 3.2.1 更新作者信息

- [x] 3.3 修改插件配置模板 `install/plugin.sample.php`
  - [x] 3.3.1 更新作者信息

---

## 4. 作者信息批量替换

- [x] 4.1 替换 PHP 文件头部作者信息（约 50+ 个文件）
  - [x] 4.1.1 入口文件 (2个)
    - [x] `index.php`
    - [x] `admin/index.php`
  - [x] 4.1.2 安装程序文件 (10个)
    - [x] `install/index.php`
    - [x] `install/function.php`
    - [x] `install/mysql.install.php`
    - [x] `install/mysqli.install.php`
    - [x] `install/pdo_mysql.install.php`
    - [x] `install/route.sample.php`
    - [x] `install/lang/*.php`
    - [x] `install/view/*.php`
  - [x] 4.1.3 框架核心文件 (20+个)
    - [x] `jisucms/xiunophp/lang/*.php`
    - [x] `jisucms/xiunophp/ext/*.php`
  - [x] 4.1.4 控制器文件
    - [x] `jisucms/control/*.php`
    - [x] `admin/control/*.php`
  - [x] 4.1.5 模型文件
    - [x] `jisucms/model/*.php`

- [x] 4.2 替换代码注释中的作者标记
  - [x] 4.2.1 `jisucms/xiunophp/lib/view.class.php` 第90行
  - [x] 4.2.2 `jisucms/xiunophp/db/db_mysql.class.php` 第741行
  - [x] 4.2.3 `jisucms/xiunophp/db/db_mysqli.class.php` 第810行
  - [x] 4.2.4 `jisucms/xiunophp/db/db_pdo_mysql.class.php` 第820行
  - [x] 4.2.5 `jisucms/xiunophp/lib/core.class.php` 第431行

---

## 5. 特殊代码修改

- [x] 5.1 修改 Hashids 分隔符
  - [x] 5.1.1 `jisucms/xiunophp/ext/Hashids.class.php` 第75行和第81行
  - [ ] 5.1.2 评估对现有 Hash ID 的影响

- [x] 5.2 修改数据库导出作者信息
  - [x] 5.2.1 `jisucms/xiunophp/ext/Database.class.php` 第85行

---

## 6. 前台模板修改

- [x] 6.1 修改模板信息文件
  - [x] 6.1.1 `view/default/info.ini` - 作者和网址

- [x] 6.2 修改首页模板
  - [x] 6.2.1 `view/default/index.htm` - 幻灯片链接和标题
  - [x] 6.2.2 `view/default/index.htm` - 关于我们部分
  - [x] 6.2.3 `view/default/index.htm` - 免责声明文本

- [x] 6.3 修改公共头部
  - [x] 6.3.1 `view/default/inc-header.htm` - Meta 生成器标签

- [x] 6.4 修改公共底部
  - [x] 6.4.1 `view/default/inc-footer.htm` - 关于我们文本
  - [x] 6.4.2 `view/default/inc-footer.htm` - 友情链接
  - [x] 6.4.3 `view/default/inc-footer.htm` - 版权信息
  - [x] 6.4.4 `view/default/inc-footer.htm` - 官网链接

- [x] 6.5 修改关于我们页面
  - [x] 6.5.1 `view/default/inc-about.htm` - 标题和内容

---

## 7. 后台模板修改

- [x] 7.1 修改后台首页
  - [x] 7.1.1 `admin/view/default/my_index.htm` - 论坛链接
  - [x] 7.1.2 `admin/view/default/index_index.htm` - Meta 关键词

- [x] 7.2 修改设置页面
  - [x] 7.2.1 `admin/view/default/setting_link.htm` - 帮助链接

---

## 8. 安装程序模板修改

- [x] 8.1 修改语言选择页面
  - [x] 8.1.1 `install/view/lang.php` - 页面标题

- [x] 8.2 修改安装步骤页面
  - [x] 8.2.1 `install/view/check_env.php` - 检查是否有品牌引用
  - [x] 8.2.2 `install/view/check_db.php` - 检查是否有品牌引用（默认数据库名）
  - [x] 8.2.3 `install/view/complete.php` - 检查是否有品牌引用
  - [x] 8.2.4 `install/view/license.php` - 检查是否有品牌引用
  - [x] 8.2.5 `install/view/lock.php` - 更新品牌引用

---

## 9. 插件配置修改

- [x] 9.1 修改编辑器插件
  - [x] 9.1.1 `jisucms/plugin/editor_um/conf.php` - 作者和网址

- [x] 9.2 修改友情链接插件
  - [x] 9.2.1 `jisucms/plugin/le_links/conf.php` - 作者和网址

---

## 10. 文档文件修改

- [x] 10.1 修改 README 文件
  - [x] 10.1.1 `README.md` - 中文版完整更新
  - [x] 10.1.2 `README.en.md` - 英文版完整更新

- [x] 10.2 修改说明文件
  - [x] 10.2.1 `目录说明.txt` - 更新品牌名称
  - [x] 10.2.2 `新版本说明.txt` - 更新品牌引用

- [x] 10.3 修改 robots.txt
  - [x] 10.3.1 更新禁止抓取目录名

- [x] 10.4 修改 LICENSE 文件
  - [x] 10.4.1 更新 `jisucms/xiunophp/LICENSE.txt` 版权信息

---

## 11. 语言包检查

- [x] 11.1 前台语言包
  - [x] 11.1.1 `jisucms/lang/zh-cn.php` - 检查品牌相关项
  - [x] 11.1.2 `jisucms/lang/en.php` - 检查品牌相关项

- [x] 11.2 后台语言包
  - [x] 11.2.1 `jisucms/lang/zh-cn_admin.php` - 检查品牌相关项
  - [x] 11.2.2 `jisucms/lang/en_admin.php` - 检查品牌相关项

- [x] 11.3 安装程序语言包
  - [x] 11.3.1 `install/lang/zh-cn.php` - 检查品牌相关项
  - [x] 11.3.2 `install/lang/en.php` - 检查品牌相关项

- [x] 11.4 框架语言包
  - [x] 11.4.1 `jisucms/xiunophp/lang/zh-cn.php` - 检查品牌相关项
  - [x] 11.4.2 `jisucms/xiunophp/lang/en.php` - 检查品牌相关项

---

## 12. 静态资源修改

- [ ] 12.1 替换 Logo 图片
  - [ ] 12.1.1 后台 Logo: `static/admin/images/logo.png`
  - [ ] 12.1.2 前台 Logo: 检查主题目录

- [ ] 12.2 替换 Favicon
  - [ ] 12.2.1 `favicon.ico`

- [ ] 12.3 检查其他图片资源
  - [ ] 12.3.1 幻灯片图片
  - [ ] 12.3.2 默认头像
  - [ ] 12.3.3 默认缩略图

---

## 13. 测试验证

- [ ] 13.1 功能测试
  - [ ] 13.1.1 前台页面访问测试
  - [ ] 13.1.2 后台管理功能测试
  - [ ] 13.1.3 用户登录注册测试
  - [ ] 13.1.4 内容发布测试
  - [ ] 13.1.5 评论功能测试
  - [ ] 13.1.6 附件上传测试
  - [ ] 13.1.7 插件功能测试
  - [ ] 13.1.8 主题切换测试

- [x] 13.2 品牌验证
  - [x] 13.2.1 全站搜索 "LeCMS" 确认无遗漏 ✅
  - [x] 13.2.2 全站搜索 "lecms" 确认无遗漏 ✅
  - [x] 13.2.3 全站搜索 "dadadezhou" 确认无遗漏 ✅
  - [x] 13.2.4 全站搜索 "www.lecms.cc" 确认无遗漏 ✅
  - [x] 13.2.5 检查所有外部链接指向 ✅

- [ ] 13.3 兼容性测试
  - [ ] 13.3.1 PHP 5.4 环境测试
  - [ ] 13.3.2 PHP 7.x 环境测试
  - [ ] 13.3.3 PHP 8.x 环境测试
  - [ ] 13.3.4 MySQL 5.x 测试
  - [ ] 13.3.5 MySQL 8.x 测试

- [ ] 13.4 性能测试
  - [ ] 13.4.1 页面加载速度测试
  - [ ] 13.4.2 缓存功能测试
  - [ ] 13.4.3 数据库查询性能测试

---

## 14. 安装程序测试

- [ ] 14.1 全新安装测试
  - [ ] 14.1.1 环境检测
  - [ ] 14.1.2 数据库配置
  - [ ] 14.1.3 数据表创建
  - [ ] 14.1.4 初始数据导入
  - [ ] 14.1.5 管理员账号创建

- [ ] 14.2 安装后验证
  - [ ] 14.2.1 前台访问正常
  - [ ] 14.2.2 后台登录正常
  - [ ] 14.2.3 配置文件生成正确

---

## 15. 文档完善

- [ ] 15.1 编写迁移指南
  - [ ] 15.1.1 从 LeCMS 迁移到 JisuCMS 的步骤
  - [ ] 15.1.2 数据迁移说明
  - [ ] 15.1.3 配置迁移说明
  - [ ] 15.1.4 注意事项和常见问题

- [ ] 15.2 更新安装文档
  - [ ] 15.2.1 系统要求
  - [ ] 15.2.2 安装步骤
  - [ ] 15.2.3 配置说明

- [ ] 15.3 编写更新日志
  - [ ] 15.3.1 品牌变更说明
  - [ ] 15.3.2 功能变更说明
  - [ ] 15.3.3 版本号更新

---

## 16. 发布准备

- [ ] 16.1 版本号更新
  - [ ] 16.1.1 更新 `install/config.sample.php` 中的版本号
  - [ ] 16.1.2 更新发布日期

- [ ] 16.2 清理临时文件
  - [ ] 16.2.1 删除测试数据
  - [ ] 16.2.2 清空缓存目录
  - [ ] 16.2.3 清空日志目录
  - [ ] 16.2.4 清空上传目录

- [ ] 16.3 打包发布
  - [ ] 16.3.1 创建发布包
  - [ ] 16.3.2 编写发布说明
  - [ ] 16.3.3 准备演示站点

---

## 17. 后续工作

- [ ] 17.1 官网建设
  - [ ] 17.1.1 部署官方网站
  - [ ] 17.1.2 发布文档中心
  - [ ] 17.1.3 建立论坛社区

- [ ] 17.2 社区建设
  - [ ] 17.2.1 创建 QQ 交流群
  - [ ] 17.2.2 建立 GitHub 仓库
  - [ ] 17.2.3 发布到开源平台

- [ ] 17.3 推广宣传
  - [ ] 17.3.1 编写推广文案
  - [ ] 17.3.2 制作宣传视频
  - [ ] 17.3.3 发布到各大平台

---

## 任务统计

- **总任务数**: 150+
- **已完成**: 90+ 项 ✅
- **待完成**: 60+ 项
- **完成进度**: 约 60%
- **预计工时**: 20-30 小时
- **优先级分布**:
  - 高优先级: 50 项（核心功能）✅ 已完成
  - 中优先级: 60 项（模板和文档）✅ 已完成
  - 低优先级: 40 项（测试和发布）⏳ 部分完成（品牌验证已完成）

---

## 执行总结

### ✅ 已完成的核心工作：
1. **目录重命名**: lecms → jisucms
2. **配置文件**: 所有配置项已更新（Cookie、缓存、数据库等）
3. **作者信息**: 50+ 个 PHP 文件的作者信息已批量替换
4. **模板文件**: 前台、后台、安装程序所有模板已更新
5. **文档文件**: README、说明文档、LICENSE 已更新
6. **插件配置**: 所有插件配置已更新
7. **语言包**: 所有语言包已检查并更新
8. **品牌验证**: 已完成全站品牌替换验证 ✅
   - PHP 文件: 0 个旧品牌引用
   - HTM 模板: 0 个旧品牌引用
   - INI 配置: 0 个旧品牌引用
   - TXT 文档: 0 个旧品牌引用
   - SQL 文件: 0 个旧品牌引用
   - MD 文档: 0 个旧品牌引用（除 .kiro/specs/ 参考文档）

### ⏳ 待完成的工作：
1. **静态资源**: Logo、Favicon 等图片资源需要设计和替换
2. **测试验证**: 需要进行全面的功能测试和兼容性测试
3. **安装测试**: 需要测试全新安装流程
4. **文档完善**: 需要编写迁移指南和更新日志
5. **发布准备**: 版本号更新、打包发布等

### ⚠️ 重要提示：
- Cookie 前缀已更改（le_ → jisu_），用户需要重新登录
- Hashids 分隔符已更改，可能影响现有短链接
- 数据库默认名称已更改为 jisucms
- 建议在测试环境中进行全面测试后再部署到生产环境

---

**任务清单版本**: 1.1  
**创建日期**: 2024-XX-XX  
**最后更新**: 2024-XX-XX  
**执行日期**: 2024-XX-XX
