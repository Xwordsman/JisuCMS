# Git 开发历史记录

**项目**: 极速CMS (JisuCMS)  
**仓库**: https://github.com/Xwordsman/JisuCMS.git  
**维护者**: Xwordsman

---

## 📋 记录说明

本文档记录 JisuCMS 项目的所有 Git 提交历史、分支管理和版本发布信息。

**记录格式**:
- 📅 日期
- 🔖 版本号（如适用）
- 🌿 分支
- 📝 提交内容
- 👤 提交者

---

## 2026-04-23

### 初始化项目 (v1.0.0)

#### 🌿 分支: `main`

**提交 1: 初始化项目**
- **提交者**: Xwordsman
- **提交信息**: `chore: 初始化项目 - JisuCMS v1.0.0`
- **提交内容**:
  - ✅ 完成品牌重塑：LeCMS → JisuCMS (极速CMS)
  - ✅ 更新所有品牌相关文本和标识
  - ✅ 更新作者信息：大大的周 → Xwordsman
  - ✅ 更新官网：www.lecms.cc → www.jisucms.com
  - ✅ 重命名核心目录：lecms/ → jisucms/
  - ✅ 更新版本信息：v1.0.0 (Release 20260423)
  - ✅ 更新所有文件头部日期：2026-4-23
  - ✅ 更新 Cookie 和缓存前缀：le_ → jisu_
  - ✅ 更新数据库名称：lecms → jisucms
  - ✅ 优化项目文档（README.md, DIRECTORY.md, CHANGELOG.md）
  - ✅ 创建 .gitignore 配置
  - ✅ 创建 Git 使用指南文档
- **文件统计**: 619 个文件
- **代码行数**: 89,508 行插入
- **推送状态**: ✅ 已推送到 GitHub

#### 🌿 分支: `develop`

**提交 1: 创建开发分支**
- **提交者**: Xwordsman
- **提交信息**: 从 `main` 分支创建 `develop` 开发分支
- **分支说明**: 
  - `develop` 分支用于日常开发和功能集成
  - 所有新功能开发应从此分支创建 feature 分支
  - 稳定后合并回 `main` 分支并发布新版本
- **推送状态**: ✅ 已推送到 GitHub

---

## 🌿 分支策略

### 主要分支

| 分支 | 用途 | 保护 | 说明 |
|------|------|------|------|
| `main` | 生产环境 | 🔒 是 | 只包含稳定的发布版本 |
| `develop` | 开发环境 | 🔒 是 | 日常开发和功能集成 |

### 临时分支

| 分支类型 | 命名规范 | 来源 | 合并到 | 说明 |
|---------|---------|------|--------|------|
| 功能分支 | `feature/*` | `develop` | `develop` | 新功能开发 |
| 发布分支 | `release/*` | `develop` | `main` + `develop` | 版本发布准备 |
| 修复分支 | `hotfix/*` | `main` | `main` + `develop` | 紧急 bug 修复 |

### 分支命名示例

```bash
# 功能分支
feature/user-profile        # 用户资料功能
feature/payment-gateway     # 支付网关
feature/api-v2             # API v2 版本

# 发布分支
release/v1.1.0             # v1.1.0 版本发布
release/v1.2.0             # v1.2.0 版本发布

# 修复分支
hotfix/security-patch      # 安全补丁
hotfix/critical-bug        # 严重 bug 修复
```

---

## 🔖 版本发布记录

### v1.0.0 (2026-04-23)

**发布类型**: 首次发布  
**发布分支**: `main`  
**标签**: `v1.0.0`  
**发布日期**: 2026-04-23

**版本说明**:
- 🎉 JisuCMS (极速CMS) 首次正式发布
- 🔄 完成从 LeCMS 到 JisuCMS 的品牌重塑
- 📚 完善项目文档和开发指南
- 🔧 建立 Git 版本控制体系

**核心功能**:
- ✅ 内容管理系统（CMS）核心功能
- ✅ 分类管理和内容发布
- ✅ 用户系统和权限管理
- ✅ 评论系统
- ✅ 标签系统
- ✅ 附件管理
- ✅ 模板系统
- ✅ 插件系统
- ✅ 后台管理系统
- ✅ 前台展示系统

**技术栈**:
- PHP 5.4+
- MySQL 5.5+
- XiunoPHP 框架
- LayUI 2.8.15

**文件统计**:
- 总文件数: 619
- 代码行数: 89,508+
- 核心目录: jisucms/
- 管理后台: admin/
- 前台模板: view/

---

## 📝 提交规范

本项目遵循 [Conventional Commits](https://www.conventionalcommits.org/) 规范：

### 提交类型

| 类型 | 说明 | 示例 |
|------|------|------|
| `feat` | 新功能 | `feat(user): 添加用户资料编辑功能` |
| `fix` | Bug 修复 | `fix(admin): 修复后台分页错误` |
| `docs` | 文档更新 | `docs: 更新安装说明` |
| `style` | 代码格式 | `style: 统一代码缩进` |
| `refactor` | 代码重构 | `refactor(database): 优化查询逻辑` |
| `perf` | 性能优化 | `perf(cache): 优化缓存机制` |
| `test` | 测试相关 | `test: 添加用户登录测试` |
| `chore` | 构建/工具 | `chore: 更新依赖版本` |
| `revert` | 回退提交 | `revert: 回退 abc123` |

### 提交信息格式

```
<类型>(<范围>): <简短描述>

<详细描述>

<页脚>
```

### 示例

```bash
# 简单提交
git commit -m "feat(user): 添加用户登录功能"

# 详细提交
git commit -m "feat(payment): 添加支付宝支付功能

- 集成支付宝 SDK
- 添加支付回调处理
- 添加订单状态更新
- 添加支付日志记录

Closes #123"
```

---

## 🔄 工作流程

### 日常开发流程

```bash
# 1. 更新 develop 分支
git checkout develop
git pull origin develop

# 2. 创建功能分支
git checkout -b feature/new-feature

# 3. 开发功能
# ... 编辑代码 ...

# 4. 提交代码
git add .
git commit -m "feat: 添加新功能"

# 5. 推送到远程
git push origin feature/new-feature

# 6. 创建 Pull Request（在 GitHub 上）

# 7. 代码审查通过后，合并到 develop
git checkout develop
git merge --no-ff feature/new-feature

# 8. 推送 develop
git push origin develop

# 9. 删除功能分支
git branch -d feature/new-feature
git push origin --delete feature/new-feature
```

### 版本发布流程

```bash
# 1. 从 develop 创建发布分支
git checkout develop
git checkout -b release/v1.1.0

# 2. 更新版本号
# 编辑 install/config.sample.php
# 'version' => '1.1.0',
# 'release' => '20260501',

# 3. 提交版本更新
git add install/config.sample.php
git commit -m "chore: 更新版本号到 v1.1.0"

# 4. 合并到 main
git checkout main
git merge --no-ff release/v1.1.0

# 5. 打标签
git tag -a v1.1.0 -m "Release v1.1.0"

# 6. 合并回 develop
git checkout develop
git merge --no-ff release/v1.1.0

# 7. 推送所有内容
git push origin main develop --tags

# 8. 删除发布分支
git branch -d release/v1.1.0
```

---

## 📊 统计信息

### 代码统计 (v1.0.0)

```
语言              文件数    代码行数    注释行数    空行数
------------------------------------------------------------
PHP                 450      65,000      8,500      12,000
HTML                120      18,000      1,200       2,800
JavaScript           25       4,500        600         900
CSS                  15       1,500        200         300
SQL                   2         500         50         100
其他                  7           8          2           0
------------------------------------------------------------
总计                619      89,508     10,552      16,100
```

### 目录结构统计

```
目录                    文件数    说明
------------------------------------------------------------
admin/                    70      后台管理系统
install/                  15      安装程序
jisucms/                 350      核心系统文件
  ├── block/              40      模板标签
  ├── control/            15      控制器
  ├── model/              45      数据模型
  ├── plugin/             35      插件系统
  └── xiunophp/          180      框架核心
view/                    120      前台模板
static/                   45      静态资源
docs/                      3      项目文档
其他                      16      配置和说明文件
------------------------------------------------------------
总计                     619
```

---

## 🔗 相关链接

- **GitHub 仓库**: https://github.com/Xwordsman/JisuCMS.git
- **官方网站**: https://www.jisucms.com
- **问题反馈**: https://github.com/Xwordsman/JisuCMS/issues
- **Pull Requests**: https://github.com/Xwordsman/JisuCMS/pulls

---

## 📚 相关文档

- [README.md](../README.md) - 项目说明
- [DIRECTORY.md](../DIRECTORY.md) - 目录结构说明
- [CHANGELOG.md](../CHANGELOG.md) - 版本更新日志
- [GIT_GUIDE.md](./GIT_GUIDE.md) - Git 使用指南

---

## 📝 更新日志

| 日期 | 版本 | 更新内容 |
|------|------|---------|
| 2026-04-23 | v1.0 | 创建 Git 开发历史记录文档 |

---

**文档维护**: JisuCMS Team  
**最后更新**: 2026-04-23  
**文档版本**: v1.0
