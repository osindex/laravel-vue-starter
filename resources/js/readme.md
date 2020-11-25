# 前端速记手册

## 模块化数据
```
import { mapActions } from 'vuex'
watch: {
  'dataTable': {
    handler(newValue) {
      this.setSubjectList(newValue)
    },
    deep: true
  }
},
methods: {
  ...mapActions(['setSubjectList'])
}
```

## 快速Modal
```
<Dialog label="标题" ref="dialog">
 ...
</Dialog>

import Dialog from "@/components/layout/Dialog"

this.$refs.dialog.dialogVisibleFunc()

```

## hack记录
```
<template slot="menuRight">
	<el-tooltip class="item" effect="dark" content="重置搜索" placement="top-start">
   		<el-button type="primary" @click="searchReset" icon="el-icon-search" circle size="small"></el-button>
   	</el-tooltip>
</template>

searchResetBtn: false, // 搜索重置嵌套报错 改用menuRight
```