# LeCMS 品牌重塑需求文档

## 项目概述

**项目名称**: LeCMS 品牌重塑为 JisuCMS（极速CMS）  
**项目类型**: 品牌替换  
**优先级**: 高  
**版本**: 1.0  

## 新品牌信息

| 项目 | 原品牌 | 新品牌 |
|------|--------|--------|
| 中文名称 | LeCMS | 极速CMS |
| 英文名称 | LeCMS / LECMS | JisuCMS |
| 官方网址 | https://www.lecms.cc | https://www.jisucms.com |
| 作者 | 大大的周 (dadadezhou) | Xwordsman |
| 作者邮箱 | zhoudada97@foxmail.com | (待提供) |
| QQ交流群 | 797599080 | (待提供) |

## 需求背景

基于 MIT 开源协议，经原作者授权，将 LeCMS 系统完整重塑为 JisuCMS 品牌，包括但不限于：
- 代码中的品牌标识
- 配置文件中的默认值
- 文档和注释
- 模板和视图文件
- 静态资源引用

## 核心需求

### 1. 代码层面修改

#### 1.1 核心目录名称
- **需求**: 将核心目录从 `lecms` 重命名为 `jisucms`
- **影响范围**: 
  - 目录结构
  - 入口文件配置
  - 所有引用路径
- **文件清单**:
  - `index.php` - 前台入口文件
  - `admin/index.php` - 后台入口文件
  - `robots.txt` - 搜索引擎配置

#### 1.2 作者信息替换
- **需求**: 替换所有文件头部的作者信息
- **原信息**:
  ```php
  /**
   * Author: dadadezhou <zhoudada97@foxmail.com>
   * Date: YYYY-MM-DD
   * Time: HH:MM
   * Description: ...
   */
  ```
- **新信息**:
  ```php
  /**
   * Author: Xwordsman
   * Original: Based on LeCMS by dadadezhou
   * Date: YYYY-MM-DD
   * Time: HH:MM
   * Description: ...
   */
  ```
- **影响文件数量**: 约 50+ 个 PHP 文件

#### 1.3 代码注释中的品牌标识
- **需求**: 替换代码注释中的 `lecms`、`LeCMS`、`LECMS` 等标识
- **示例位置**:
  - `lecms/xiunophp/lib/view.class.php` - 第 90 行注释
  - `lecms/xiunophp/db/*.class.php` - 数据库类注释
  - `lecms/xiunophp/ext/*.class.php` - 扩展类注释

#### 1.4 配置文件修改

##### 1.4.1 Cookie 前缀
- **文件**: `install/config.sample.php`
- **原值**: `'cookie_pre' => 'le_'`
- **新值**: `'cookie_pre' => 'jisu_'`

##### 1.4.2 缓存前缀
- **文件**: `install/config.sample.php`
- **原值**: `'pre' => 'le_'`
- **新值**: `'pre' => 'jisu_'`

##### 1.4.3 伪静态配置键名
- **文件**: `install/config.sample.php`
- **原值**: `'lecms_parseurl' => 0`
- **新值**: `'jisucms_parseurl' => 0`

##### 1.4.4 数据库名称
- **文件**: `install/config.sample.php`
- **原值**: `'name' => 'lecms'`
- **新值**: `'name' => 'jisucms'`

#### 1.5 运行时缓存文件名
- **文件**: `lecms/xiunophp/xiunophp.php`
- **原值**: `$runfile = RUNTIME_PATH.'_lecms.php'`
- **新值**: `$runfile = RUNTIME_PATH.'_jisucms.php'`

### 2. 模板和视图层面修改

#### 2.1 前台模板修改

##### 2.1.1 模板信息文件
- **文件**: `view/default/info.ini`
- **修改项**:
  - `author=大大的周` → `author=Xwordsman`
  - `authorurl=https://www.lecms.cc` → `authorurl=https://www.jisucms.com`

##### 2.1.2 首页幻灯片
- **文件**: `view/default/index.htm`
- **修改内容**:
  - 幻灯片链接: `https://www.lecms.cc` → `https://www.jisucms.com`
  - 幻灯片标题: `LECMS 幻灯片一/二/三` → `极速CMS 幻灯片一/二/三`
  - 关于我们标题: `LECMS` → `极速CMS`
  - 免责声明: `lecms主程序为免费提供使用...` → `极速CMS主程序为免费提供使用...`

##### 2.1.3 页面头部
- **文件**: `view/default/inc-header.htm`
- **修改项**:
  - Meta 生成器: `<meta name="generator" content="LECMS" />` → `<meta name="generator" content="JisuCMS" />`

##### 2.1.4 页面底部
- **文件**: `view/default/inc-footer.htm`
- **修改内容**:
  - 关于我们文本: 所有 `lecms` → `极速CMS`
  - 友情链接:
    - `lecms教程` → `极速CMS教程`
    - `lecms模板` → `极速CMS模板`
    - `lecms动态` → `极速CMS动态`
  - 版权信息: `Powered by LECMS` → `Powered by JisuCMS`
  - 链接地址: `https://www.lecms.cc` → `https://www.jisucms.com`

##### 2.1.5 关于我们页面
- **文件**: `view/default/inc-about.htm`
- **修改项**:
  - 标题: `LECMS` → `极速CMS`
  - 内容: `lecms主程序为免费提供使用...` → `极速CMS主程序为免费提供使用...`

#### 2.2 后台模板修改

##### 2.2.1 后台首页
- **文件**: `admin/view/default/my_index.htm`
- **修改项**:
  - 论坛链接: `<a target="_blank" href="https://www.lecms.cc">lecms</a>` → `<a target="_blank" href="https://www.jisucms.com">极速CMS</a>`

##### 2.2.2 链接设置页面
- **文件**: `admin/view/default/setting_link.htm`
- **修改项**:
  - 帮助链接: `https://www.lecms.cc/index.php?thread-844.htm` → `https://www.jisucms.com/help/link-settings`

#### 2.3 安装程序模板
- **文件**: `install/view/lang.php`
- **修改项**:
  - 页面标题: `LECMS <?php echo $version; ?> 选择语言` → `极速CMS <?php echo $version; ?> 选择语言`

### 3. 文档层面修改

#### 3.1 README 文件

##### 3.1.1 中文 README
- **文件**: `README.md`
- **修改内容**:
  - 标题: `# LECMS` → `# 极速CMS (JisuCMS)`
  - 介绍: `LECMS网站管理系统` → `极速CMS网站管理系统`
  - 相关链接部分:
    - 交流论坛: `www.lecms.cc` → `www.jisucms.com`
    - QQ群: 保留或更新
    - 插件地址: 更新为新域名
    - 模板地址: 更新为新域名
    - 开发手册: 更新为新域名
  - 程序特性标题: `Lecms程序特性` → `极速CMS程序特性`

##### 3.1.2 英文 README
- **文件**: `README.en.md`
- **修改内容**:
  - 标题: `# LECMS` → `# JisuCMS`
  - 描述: `LECMS网站管理系统` → `JisuCMS Website Management System`

#### 3.2 目录说明文件
- **文件**: `目录说明.txt`
- **修改项**:
  - 标题: `LECMS` → `极速CMS`
  - 目录说明: `|--lecms 程序核心文件目录` → `|--jisucms 程序核心文件目录`

#### 3.3 版本说明文件
- **文件**: `新版本说明.txt`
- **修改项**:
  - 所有 `lecms` 引用 → `jisucms`

#### 3.4 robots.txt
- **文件**: `robots.txt`
- **修改项**:
  - `Disallow: /lecms/` → `Disallow: /jisucms/`

### 4. 插件层面修改

#### 4.1 编辑器插件
- **文件**: `lecms/plugin/editor_um/conf.php`
- **修改项**:
  - `'author' => '大大的周'` → `'author' => 'Xwordsman'`
  - `'authorurl' => 'https://www.lecms.cc'` → `'authorurl' => 'https://www.jisucms.com'`

#### 4.2 友情链接插件
- **文件**: `lecms/plugin/le_links/conf.php`
- **修改项**:
  - `'author' => '大大的周'` → `'author' => 'Xwordsman'`
  - `'authorurl' => 'https://www.lecms.cc'` → `'authorurl' => 'https://www.jisucms.com'`

### 5. 语言包修改

#### 5.1 前台语言包
- **文件**: 
  - `lecms/lang/zh-cn.php`
  - `lecms/lang/en.php`
- **修改项**: 检查是否有品牌相关的语言项（当前未发现）

#### 5.2 后台语言包
- **文件**:
  - `lecms/lang/zh-cn_admin.php`
  - `lecms/lang/en_admin.php`
- **修改项**: 检查是否有品牌相关的语言项

#### 5.3 安装程序语言包
- **文件**:
  - `install/lang/zh-cn.php`
  - `install/lang/en.php`
- **修改项**: 检查是否有品牌相关的语言项

### 6. 特殊代码标记

#### 6.1 Hashids 类
- **文件**: `lecms/xiunophp/ext/Hashids.class.php`
- **修改项**:
  - 第 75 行: `private $_seps = 'dadadezhou';` → `private $_seps = 'xwordsman';`
  - 注意: 这会影响已生成的 Hash ID，需要评估影响

#### 6.2 数据库导出类
- **文件**: `lecms/xiunophp/ext/Database.class.php`
- **修改项**:
  - 第 85 行: `$sql .= "-- Author: dadadezhou \n";` → `$sql .= "-- Author: Xwordsman \n";`

## 非功能性需求

### 1. 兼容性要求
- 修改后的系统必须保持与原 LeCMS 相同的功能
- 数据库结构不变
- API 接口不变
- 插件机制不变

### 2. 性能要求
- 品牌替换不应影响系统性能
- 缓存机制正常工作

### 3. 安全性要求
- Cookie 前缀修改后，原有 Cookie 将失效（用户需重新登录）
- 确保所有配置文件的安全性

## 实施建议

### 阶段一：准备工作
1. 完整备份当前系统
2. 准备新品牌的完整信息（邮箱、QQ群等）
3. 准备新的 Logo 和图标资源

### 阶段二：核心修改
1. 重命名核心目录 `lecms` → `jisucms`
2. 修改所有入口文件和配置文件
3. 批量替换作者信息

### 阶段三：模板和文档
1. 修改所有模板文件
2. 更新文档文件
3. 修改插件配置

### 阶段四：测试验证
1. 功能测试
2. 兼容性测试
3. 性能测试

### 阶段五：发布准备
1. 更新版本号
2. 编写迁移指南
3. 准备发布说明

## 风险评估

### 高风险项
1. **核心目录重命名**: 可能影响已安装的系统升级
2. **Cookie 前缀修改**: 会导致所有用户需要重新登录
3. **Hashids 分隔符修改**: 会影响已生成的短链接

### 中风险项
1. **缓存前缀修改**: 需要清空所有缓存
2. **配置键名修改**: 需要更新配置文件

### 低风险项
1. 作者信息替换
2. 文档修改
3. 模板文本替换

## 验收标准

### 功能验收
- [ ] 前台页面正常访问
- [ ] 后台管理正常使用
- [ ] 用户登录注册功能正常
- [ ] 内容发布功能正常
- [ ] 插件功能正常
- [ ] 主题切换功能正常

### 品牌验收
- [ ] 所有页面不再出现 "LeCMS" 字样
- [ ] 所有链接指向新域名
- [ ] 作者信息已更新
- [ ] 版权信息已更新

### 文档验收
- [ ] README 文件已更新
- [ ] 安装文档已更新
- [ ] 帮助文档已更新

## 附录

### A. 文件修改清单

#### PHP 文件（约 50+ 个）
- 所有包含作者信息的 PHP 文件
- 入口文件: `index.php`, `admin/index.php`
- 配置文件: `install/config.sample.php`
- 核心框架文件: `lecms/xiunophp/**/*.php`

#### 模板文件（约 10+ 个）
- `view/default/*.htm`
- `admin/view/default/*.htm`
- `install/view/*.php`

#### 配置文件（约 5 个）
- `view/default/info.ini`
- `lecms/plugin/*/conf.php`

#### 文档文件（约 5 个）
- `README.md`
- `README.en.md`
- `目录说明.txt`
- `新版本说明.txt`
- `robots.txt`

### B. 搜索替换规则

| 原文本 | 新文本 | 区分大小写 | 全词匹配 |
|--------|--------|-----------|---------|
| lecms | jisucms | 否 | 是 |
| LeCMS | JisuCMS | 是 | 是 |
| LECMS | 极速CMS | 是 | 是 |
| www.lecms.cc | www.jisucms.com | 否 | 否 |
| dadadezhou | Xwordsman | 否 | 是 |
| zhoudada97@foxmail.com | (新邮箱) | 否 | 否 |
| 大大的周 | Xwordsman | 是 | 是 |
| le_ | jisu_ | 是 | 否 |

### C. 需要用户提供的信息

1. **新作者邮箱**: _______________
2. **新 QQ 交流群**: _______________
3. **新域名备案信息**: _______________
4. **新 Logo 文件**: _______________
5. **新 Favicon 文件**: _______________

---

**文档版本**: 1.0  
**创建日期**: 2024-XX-XX  
**最后更新**: 2024-XX-XX  
**文档状态**: 待审核
