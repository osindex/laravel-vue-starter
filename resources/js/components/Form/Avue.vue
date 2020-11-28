<template>
  <el-card>
    <el-row v-if="isController" slot="header" class="avue-controller avue-crud">
      <el-col :span="4">{{showif}}斑马纹: <el-switch v-model="value.stripe" /></el-col>
      <el-col :span="4">{{showif}}多选框: <el-switch v-model="value.selection" /></el-col>
      <el-col :span="4">{{showif}}边框: <el-switch v-model="value.border" /></el-col>
      <el-col :span="4">{{showif}}索引: <el-switch v-model="value.index" /></el-col>
      <el-col :span="3">{{showif}}表头: <el-switch v-model="value.showHeader" /></el-col>
      <el-col :span="5">文本大小:
        <el-radio-group v-model="value.size" size="mini">
          <el-radio-button label="medium">默认</el-radio-button>
          <el-radio-button label="small">较小</el-radio-button>
          <el-radio-button label="mini">最小</el-radio-button>
        </el-radio-group>
      </el-col>
    </el-row>
    <slot />
  </el-card>
</template>
<script>
export default {
  name: 'Avue',
  model: {
    prop: 'value',
    event: 'change'
  },
  props: {
    isController: {
      type: Boolean,
      default: false
    },
    value: {
      type: Object,
      default: () => {
        return {
          border: false,
          stripe: false,
          showHeader: true,
          index: false,
          selection: false,
          size: ''
        }
      }
    }
  },
  data() {
    return {
      showif: ''
      // showif: '显示'
    }
  },
  computed: {
  },
  watch: {
    value: (e) => {
      console.log(e)
    }
  },
  created() {
  }
}
</script>
