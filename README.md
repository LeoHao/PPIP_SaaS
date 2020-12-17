###### 细节决定成败

## 提交规范
所有修改先要开新分支,然后合并到main
不同模块改动commit需拆开,不允许合并提交

- 同一问题多次修改合并提交:
```
git merge --no-commit --squash
```

- commit message 格式 :
```
{type}({修改功能名称}): {commit简单描述}

{commit详细描述}
```

### 主要type
- feat:     增加新功能
- fix:      修复bug

### 特殊type
- docs:     只改动了文档相关的内容
- style:    不影响代码含义的改动，例如去掉空格、改变缩进、增删分号
- build:    构造工具的或者外部依赖的改动，例如webpack，npm
- refactor: 代码重构时使用
### 暂不使用type
- test:     添加测试或者修改现有测试
- perf:     提高性能的改动
- ci:       与CI（持续集成服务）有关的改动
- chore:    不修改src或者test的其余修改，例如构建过程或辅助工具的变动
