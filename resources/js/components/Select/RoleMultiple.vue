<template>
  <el-select v-model="optionValue" multiple clearable placeholder="选择角色">
    <el-option v-for="item in list" :key="item.id" :label="item.description || item.name" :value="item.id" />
  </el-select>
</template>
<script>
import { getRoleAll } from '@/api/role'
export default {
  name: 'RoleSelectMultiple',
  props: {
    nowValue: {
      type: Array,
      default: () => {
        return []
      }
    },
  },
  data() {
    return {
      optionValue: this.nowValue,
      list: {}
    }
  },
  computed: {
  },
  created() {
    //尽量不要在这里拉去数据
  },
  methods: {
    getList() {
      getRoleAll().then((res) => {
        this.list = res.data
      })
    },
  },
  mounted() {
    this.getList()
  },
  watch: {
    optionValue() {
      this.$emit('dataChange',this.optionValue)
    }
  }
}
</script>
