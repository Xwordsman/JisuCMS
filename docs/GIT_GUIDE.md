# Git 版本控制完整指南

**文档版本**: v1.0  
**更新日期**: 2026-04-23  
**适用项目**: 极速CMS (JisuCMS)

---

## 📋 目录

1. [Git 简介](#git-简介)
2. [为什么使用 Git](#为什么使用-git)
3. [安装 Git](#安装-git)
4. [Git 基础概念](#git-基础概念)
5. [初始化项目](#初始化项目)
6. [基础命令](#基础命令)
7. [分支管理](#分支管理)
8. [远程仓库](#远程仓库)
9. [工作流程](#工作流程)
10. [常见场景](#常见场景)
11. [最佳实践](#最佳实践)
12. [故障排除](#故障排除)
13. [学习资源](#学习资源)

---

## 🎯 Git 简介

Git 是一个**分布式版本控制系统**，由 Linux 之父 Linus Torvalds 于 2005 年创建。它是目前世界上最流行的版本控制系统，被数百万开发者使用。

### 什么是版本控制？

版本控制是一种记录文件内容变化，以便将来查阅特定版本修订情况的系统。

**传统方法（手动复制）**:
```
jisucms_v1.0/
jisucms_v1.0_backup/
jisucms_v1.0_final/
jisucms_v1.0_final_final/
jisucms_v1.1/
...
```

**Git 方法**:
```
jisucms/
├── .git/           # Git 仓库（包含所有历史）
└── [项目文件]      # 当前工作目录
```

---

## 💡 为什么使用 Git

### 对比：手动复制 vs Git

| 特性 | 手动复制 | Git 版本控制 |
|------|---------|-------------|
| **磁盘占用** | 每个版本几百MB | 只存储变更，节省90%+ |
| **变更追踪** | 不知道改了什么 | 精确到每一行 |
| **回滚能力** | 手动复制回去 | 一条命令瞬间回滚 |
| **协作能力** | 几乎不可能 | 多人同时开发 |
| **分支开发** | 不支持 | 完美支持 |
| **历史记录** | 文件夹名称 | 完整的提交历史 |
| **冲突解决** | 手动对比 | 自动检测和合并 |
| **备份安全** | 本地单点 | 分布式多备份 |

### Git 的核心优势

1. **节省空间** - 只存储文件的变更，不是完整副本
2. **完整历史** - 记录每一次修改的详细信息
3. **轻松回滚** - 可以回到任何历史版本
4. **分支开发** - 可以同时开发多个功能
5. **团队协作** - 支持多人协作开发
6. **离线工作** - 不需要网络也能提交
7. **行业标准** - 全球最流行的版本控制系统

---

## 🔧 安装 Git

### Windows 系统

#### 方法1: 官方安装包（推荐）

1. 访问 Git 官网: https://git-scm.com/download/win
2. 下载最新版本的安装包
3. 运行安装程序，使用默认设置即可
4. 安装完成后，右键菜单会出现 "Git Bash Here"

#### 方法2: 使用包管理器

```powershell
# 使用 Chocolatey
choco install git

# 使用 Scoop
scoop install git

# 使用 Winget
winget install Git.Git
```

### 验证安装

打开命令行（CMD 或 PowerShell 或 Git Bash），输入：

```bash
git --version
```

应该显示类似：`git version 2.43.0`

### 初始配置

安装完成后，需要配置用户信息：

```bash
# 配置用户名
git config --global user.name "Xwordsman"

# 配置邮箱
git config --global user.email "your.email@example.com"

# 配置默认编辑器（可选）
git config --global core.editor "notepad"

# 配置默认分支名称
git config --global init.defaultBranch main

# 查看配置
git config --list
```

---

## 📚 Git 基础概念

### 1. 三个区域

```
工作区 (Working Directory)
    ↓ git add
暂存区 (Staging Area / Index)
    ↓ git commit
本地仓库 (Local Repository)
    ↓ git push
远程仓库 (Remote Repository)
```

**工作区**: 你实际编辑文件的地方  
**暂存区**: 临时存放即将提交的修改  
**本地仓库**: 本地的 Git 数据库  
**远程仓库**: GitHub/Gitee 等托管平台

### 2. 文件状态

```
未跟踪 (Untracked)
    ↓ git add
已暂存 (Staged)
    ↓ git commit
已提交 (Committed)
    ↓ 修改文件
已修改 (Modified)
    ↓ git add
已暂存 (Staged)
```

### 3. 分支概念

```
main (主分支)
├── commit 1
├── commit 2
├── commit 3
└── commit 4

develop (开发分支)
├── commit 1
├── commit 2
├── commit 3
├── commit 4
└── commit 5

feature/new-feature (功能分支)
├── commit 1
├── commit 2
└── commit 3
```

---

## 🚀 初始化项目

### 场景1: 为现有项目添加 Git

```bash
# 1. 进入项目目录
cd d:/AI/Kaifa/XiunoPHP/JisuCMS/lecms3.0.3-master

# 2. 初始化 Git 仓库
git init

# 3. 创建 .gitignore 文件（见下方）

# 4. 添加所有文件到暂存区
git add .

# 5. 创建第一个提交
git commit -m "chore: 初始化项目 - JisuCMS v1.0.0"

# 6. 创建主分支（如果需要）
git branch -M main
```

### 场景2: 克隆远程仓库

```bash
# 从 GitHub 克隆
git clone https://github.com/username/jisucms.git

# 从 Gitee 克隆
git clone https://gitee.com/username/jisucms.git

# 克隆到指定目录
git clone https://github.com/username/jisucms.git my-project
```

---

## 📝 基础命令

### 查看状态

```bash
# 查看当前状态
git status

# 查看简洁状态
git status -s

# 查看差异
git diff              # 工作区 vs 暂存区
git diff --staged     # 暂存区 vs 仓库
git diff HEAD         # 工作区 vs 仓库
```

### 添加文件

```bash
# 添加单个文件
git add index.php

# 添加多个文件
git add index.php README.md

# 添加整个目录
git add admin/

# 添加所有修改的文件
git add .

# 添加所有 PHP 文件
git add *.php

# 交互式添加
git add -i
```

### 提交更改

```bash
# 提交暂存区的文件
git commit -m "feat: 添加用户登录功能"

# 添加并提交（跳过 git add）
git commit -am "fix: 修复登录bug"

# 修改最后一次提交
git commit --amend

# 修改最后一次提交信息
git commit --amend -m "新的提交信息"
```

### 查看历史

```bash
# 查看提交历史
git log

# 查看简洁历史
git log --oneline

# 查看图形化历史
git log --graph --oneline --all

# 查看最近 5 条
git log -5

# 查看某个文件的历史
git log index.php

# 查看某个作者的提交
git log --author="Xwordsman"

# 查看某个时间段的提交
git log --since="2026-04-01" --until="2026-04-23"
```

### 撤销操作

```bash
# 撤销工作区的修改（危险！）
git checkout -- index.php

# 撤销暂存区的文件
git reset HEAD index.php

# 回退到上一个版本
git reset --soft HEAD~1    # 保留修改
git reset --mixed HEAD~1   # 保留工作区修改
git reset --hard HEAD~1    # 丢弃所有修改（危险！）

# 回退到指定版本
git reset --hard abc123

# 撤销某次提交（创建新提交）
git revert abc123
```

---

## 🌿 分支管理

### 查看分支

```bash
# 查看本地分支
git branch

# 查看所有分支（包括远程）
git branch -a

# 查看远程分支
git branch -r

# 查看分支详细信息
git branch -v
```

### 创建分支

```bash
# 创建新分支
git branch feature/user-login

# 创建并切换到新分支
git checkout -b feature/user-login

# 或使用新命令
git switch -c feature/user-login

# 从指定提交创建分支
git branch feature/new-feature abc123
```

### 切换分支

```bash
# 切换分支
git checkout develop

# 或使用新命令
git switch develop

# 切换到上一个分支
git checkout -

# 切换并创建分支
git checkout -b feature/new-feature
```

### 合并分支

```bash
# 合并指定分支到当前分支
git merge feature/user-login

# 不使用快进合并（保留分支历史）
git merge --no-ff feature/user-login

# 压缩合并（所有提交合并为一个）
git merge --squash feature/user-login
```

### 删除分支

```bash
# 删除已合并的分支
git branch -d feature/user-login

# 强制删除分支
git branch -D feature/user-login

# 删除远程分支
git push origin --delete feature/user-login
```

### 变基（Rebase）

```bash
# 将当前分支变基到 main
git rebase main

# 交互式变基（整理提交历史）
git rebase -i HEAD~3

# 继续变基
git rebase --continue

# 中止变基
git rebase --abort
```

---

## 🌐 远程仓库

### 查看远程仓库

```bash
# 查看远程仓库
git remote

# 查看远程仓库详细信息
git remote -v

# 查看远程仓库详情
git remote show origin
```

### 添加远程仓库

```bash
# 添加远程仓库
git remote add origin https://github.com/username/jisucms.git

# 添加多个远程仓库
git remote add github https://github.com/username/jisucms.git
git remote add gitee https://gitee.com/username/jisucms.git
```

### 推送到远程

```bash
# 推送到远程仓库
git push origin main

# 首次推送并设置上游分支
git push -u origin main

# 推送所有分支
git push origin --all

# 推送标签
git push origin --tags

# 强制推送（危险！）
git push -f origin main
```

### 从远程拉取

```bash
# 拉取远程更新
git pull origin main

# 拉取但不合并
git fetch origin

# 拉取所有远程分支
git fetch --all

# 拉取并变基
git pull --rebase origin main
```

### 克隆仓库

```bash
# 克隆仓库
git clone https://github.com/username/jisucms.git

# 克隆指定分支
git clone -b develop https://github.com/username/jisucms.git

# 浅克隆（只克隆最近的提交）
git clone --depth 1 https://github.com/username/jisucms.git
```

---

## 🔄 工作流程

### Git Flow 工作流（推荐）

```
main (生产环境)
├── v1.0.0 (标签)
├── v1.1.0 (标签)
└── v1.2.0 (标签)

develop (开发环境)
├── 日常开发
└── 功能集成

feature/* (功能分支)
├── feature/user-login
├── feature/payment
└── feature/api

release/* (发布分支)
└── release/v1.1.0

hotfix/* (紧急修复)
└── hotfix/critical-bug
```

### 开发新功能流程

```bash
# 1. 从 develop 创建功能分支
git checkout develop
git pull origin develop
git checkout -b feature/user-profile

# 2. 开发功能
# ... 编辑文件 ...

# 3. 提交代码
git add .
git commit -m "feat: 添加用户资料编辑功能"

# 4. 推送到远程
git push origin feature/user-profile

# 5. 功能完成后，合并到 develop
git checkout develop
git merge --no-ff feature/user-profile

# 6. 推送 develop
git push origin develop

# 7. 删除功能分支
git branch -d feature/user-profile
git push origin --delete feature/user-profile
```

### 发布新版本流程

```bash
# 1. 从 develop 创建发布分支
git checkout develop
git checkout -b release/v1.1.0

# 2. 更新版本号
# 编辑 install/config.sample.php
# 'version' => '1.1.0',
# 'release' => '20260501',

# 3. 提交版本号更新
git add install/config.sample.php
git commit -m "chore: 更新版本号到 v1.1.0"

# 4. 合并到 main
git checkout main
git merge --no-ff release/v1.1.0

# 5. 打标签
git tag -a v1.1.0 -m "Release v1.1.0

新功能:
- 用户资料编辑
- 支付功能
- API接口

Bug修复:
- 修复登录问题
- 修复分页错误"

# 6. 合并回 develop
git checkout develop
git merge --no-ff release/v1.1.0

# 7. 推送所有内容
git push origin main develop --tags

# 8. 删除发布分支
git branch -d release/v1.1.0
```

### 紧急修复流程

```bash
# 1. 从 main 创建 hotfix 分支
git checkout main
git checkout -b hotfix/security-fix

# 2. 修复 bug
# ... 编辑文件 ...

# 3. 提交修复
git add .
git commit -m "fix: 修复严重安全漏洞"

# 4. 合并到 main
git checkout main
git merge --no-ff hotfix/security-fix

# 5. 打标签
git tag -a v1.0.1 -m "Hotfix v1.0.1 - 修复安全漏洞"

# 6. 合并到 develop
git checkout develop
git merge --no-ff hotfix/security-fix

# 7. 推送
git push origin main develop --tags

# 8. 删除 hotfix 分支
git branch -d hotfix/security-fix
```

---

## 🎯 常见场景

### 场景1: 查看某个文件的修改历史

```bash
# 查看文件的提交历史
git log -- index.php

# 查看文件的详细修改
git log -p -- index.php

# 查看文件的每一行是谁修改的
git blame index.php

# 查看文件在某个版本的内容
git show abc123:index.php
```

### 场景2: 暂存当前工作

```bash
# 暂存当前修改
git stash

# 暂存并添加说明
git stash save "临时保存：正在开发的功能"

# 查看暂存列表
git stash list

# 恢复最近的暂存
git stash pop

# 恢复指定的暂存
git stash apply stash@{0}

# 删除暂存
git stash drop stash@{0}

# 清空所有暂存
git stash clear
```

### 场景3: 撤销已推送的提交

```bash
# 方法1: 使用 revert（推荐）
git revert abc123
git push origin main

# 方法2: 使用 reset（危险！）
git reset --hard HEAD~1
git push -f origin main
```

### 场景4: 合并冲突解决

```bash
# 1. 尝试合并
git merge feature/new-feature

# 2. 如果有冲突，Git 会提示
# CONFLICT (content): Merge conflict in index.php

# 3. 查看冲突文件
git status

# 4. 手动编辑冲突文件
# <<<<<<< HEAD
# 当前分支的内容
# =======
# 要合并分支的内容
# >>>>>>> feature/new-feature

# 5. 解决冲突后，标记为已解决
git add index.php

# 6. 完成合并
git commit -m "merge: 合并 feature/new-feature"
```

### 场景5: 修改提交历史

```bash
# 修改最后一次提交
git commit --amend

# 合并最近 3 次提交
git rebase -i HEAD~3

# 在交互界面中：
# pick abc123 第一次提交
# squash def456 第二次提交
# squash ghi789 第三次提交
```

### 场景6: 查找引入 bug 的提交

```bash
# 使用二分查找
git bisect start
git bisect bad                 # 当前版本有 bug
git bisect good v1.0.0         # v1.0.0 没有 bug

# Git 会自动切换到中间版本
# 测试后标记
git bisect good   # 如果没有 bug
git bisect bad    # 如果有 bug

# 重复直到找到引入 bug 的提交
git bisect reset  # 结束查找
```

---

## ✅ 最佳实践

### 1. 提交信息规范

使用 **Conventional Commits** 规范：

```
<类型>(<范围>): <简短描述>

<详细描述>

<页脚>
```

**类型**:
- `feat`: 新功能
- `fix`: 修复 bug
- `docs`: 文档更新
- `style`: 代码格式（不影响功能）
- `refactor`: 重构代码
- `perf`: 性能优化
- `test`: 测试相关
- `chore`: 构建/工具相关
- `revert`: 回退提交

**示例**:
```bash
git commit -m "feat(user): 添加用户登录功能"
git commit -m "fix(admin): 修复后台分页错误"
git commit -m "docs: 更新 README 安装说明"
git commit -m "refactor(database): 重构数据库查询逻辑"
git commit -m "perf(cache): 优化缓存机制"
```

### 2. 提交频率

- ✅ **经常提交** - 每完成一个小功能就提交
- ✅ **原子提交** - 每次提交只做一件事
- ✅ **有意义的提交** - 提交信息清晰明确
- ❌ **避免大提交** - 不要一次提交几百个文件

### 3. 分支命名

```bash
# 功能分支
feature/user-login
feature/payment-gateway
feature/api-v2

# 修复分支
fix/login-error
fix/pagination-bug

# 发布分支
release/v1.1.0
release/v2.0.0

# 紧急修复分支
hotfix/security-patch
hotfix/critical-bug
```

### 4. .gitignore 配置

创建 `.gitignore` 文件，忽略不需要版本控制的文件：

```gitignore
# 配置文件（包含敏感信息）
jisucms/config/conf.php
jisucms/config/plugin.php
jisucms/config/route.php

# 上传文件
upload/*
!upload/.gitkeep

# 日志文件
log/*
!log/.gitkeep

# 缓存文件
runcache/*
!runcache/.gitkeep

# IDE 配置
.vscode/
.idea/
*.sublime-*

# 系统文件
.DS_Store
Thumbs.db
desktop.ini

# 临时文件
*.tmp
*.bak
*.swp
*~

# 依赖
vendor/
node_modules/

# 环境配置
.env
.env.local
```

### 5. 保护主分支

```bash
# 在 GitHub/Gitee 上设置分支保护规则：
# 1. 不允许直接推送到 main
# 2. 必须通过 Pull Request 合并
# 3. 必须通过代码审查
# 4. 必须通过 CI 测试
```

### 6. 定期同步

```bash
# 每天开始工作前
git checkout develop
git pull origin develop

# 每天结束工作后
git push origin develop
```

### 7. 使用标签

```bash
# 为每个发布版本打标签
git tag -a v1.0.0 -m "Release v1.0.0"
git push origin v1.0.0

# 查看所有标签
git tag

# 查看标签详情
git show v1.0.0

# 检出标签
git checkout v1.0.0
```

---

## 🔧 故障排除

### 问题1: 提交了敏感信息

```bash
# 从历史中删除文件
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch jisucms/config/conf.php" \
  --prune-empty --tag-name-filter cat -- --all

# 或使用 BFG Repo-Cleaner（更快）
bfg --delete-files conf.php
git reflog expire --expire=now --all
git gc --prune=now --aggressive

# 强制推送
git push origin --force --all
```

### 问题2: 合并冲突

```bash
# 查看冲突文件
git status

# 使用工具解决冲突
git mergetool

# 或手动编辑文件后
git add <冲突文件>
git commit

# 如果想放弃合并
git merge --abort
```

### 问题3: 误删除分支

```bash
# 查看所有操作记录
git reflog

# 恢复分支
git checkout -b recovered-branch abc123
```

### 问题4: 推送被拒绝

```bash
# 先拉取远程更新
git pull origin main

# 如果有冲突，解决后再推送
git push origin main

# 如果确定要覆盖远程（危险！）
git push -f origin main
```

### 问题5: 撤销 git add

```bash
# 撤销所有暂存
git reset HEAD

# 撤销指定文件
git reset HEAD index.php
```

### 问题6: 修改最后一次提交

```bash
# 修改提交信息
git commit --amend -m "新的提交信息"

# 添加遗漏的文件
git add forgotten-file.php
git commit --amend --no-edit
```

---

## 📚 学习资源

### 官方文档

- **Git 官方网站**: https://git-scm.com/
- **Git 官方文档**: https://git-scm.com/doc
- **Git Book（中文）**: https://git-scm.com/book/zh/v2

### 在线教程

- **廖雪峰 Git 教程**: https://www.liaoxuefeng.com/wiki/896043488029600
- **GitHub 指南**: https://guides.github.com/
- **Gitee 帮助**: https://gitee.com/help

### 可视化工具

- **GitKraken**: https://www.gitkraken.com/
- **SourceTree**: https://www.sourcetreeapp.com/
- **GitHub Desktop**: https://desktop.github.com/
- **TortoiseGit**: https://tortoisegit.org/

### 练习平台

- **Learn Git Branching**: https://learngitbranching.js.org/?locale=zh_CN
- **Git 游戏**: https://ohmygit.org/

### 速查表

- **Git 速查表**: https://training.github.com/downloads/zh_CN/github-git-cheat-sheet/

---

## 🎯 快速参考

### 常用命令速查

```bash
# 初始化
git init
git clone <url>

# 状态和差异
git status
git diff
git log

# 添加和提交
git add .
git commit -m "message"

# 分支
git branch
git checkout -b <branch>
git merge <branch>

# 远程
git remote add origin <url>
git push origin <branch>
git pull origin <branch>

# 撤销
git reset HEAD <file>
git checkout -- <file>
git revert <commit>

# 暂存
git stash
git stash pop

# 标签
git tag v1.0.0
git push origin --tags
```

---

## 📞 获取帮助

### 命令行帮助

```bash
# 查看命令帮助
git help <command>
git <command> --help

# 例如
git help commit
git commit --help
```

### 社区支持

- **Stack Overflow**: https://stackoverflow.com/questions/tagged/git
- **GitHub Community**: https://github.community/
- **Gitee 社区**: https://gitee.com/explore

---

## 🎉 下一步

现在您已经了解了 Git 的基础知识，建议：

1. ✅ **初始化项目** - 为 JisuCMS 创建 Git 仓库
2. ✅ **创建 .gitignore** - 忽略不需要的文件
3. ✅ **首次提交** - 提交当前代码作为 v1.0.0
4. ✅ **创建远程仓库** - 在 GitHub 或 Gitee 上创建仓库
5. ✅ **推送代码** - 将本地代码推送到远程
6. ✅ **建立分支策略** - 创建 develop 分支
7. ✅ **开始开发** - 使用 Git 进行日常开发

---

**文档维护**: JisuCMS Team  
**最后更新**: 2026-04-23  
**版本**: v1.0

