<template>
  <div>
    {{user.name}}
    <el-button @click="clickEdit">编辑</el-button>
  </div>
</template>

<script>
  import { hasPermission } from '@/libs/permission'

  export default {
    name: 'msgBoxIndex',
    components: {
    },
    props: {
      user: {
        type: Object,
        default: {

        }
      }
    },
    data: () => ({
    }),
    methods: {
      clickEdit() {
        console.log('xyz')
        this.$emit('callFunc','xyz')
      }
    },
    computed: {
      updatePermission: function() {
        return hasPermission('msgBox.update')
      },
      addPermission: function() {
        return hasPermission('msgBox.store')
      },
      deletePermission: function() {
        return hasPermission('msgBox.destroy')
      }
    },
    mounted() {
      console.log(this.user,'mmm')
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>