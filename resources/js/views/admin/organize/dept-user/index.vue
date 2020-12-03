<template>
  <div>
    <user :showTree="showTree" :moduleProp.sync="moduleProp" :isController="false" :addBtn="false"/>
  </div>
</template>

<script>
  import { hasPermission } from '@/libs/permission'
  import user from '../../user'

  export default {
    name: 'deptUserIndex',
    components: {
      user
    },
    data: () => ({
      showTree: true,
      moduleProp: '/api/dept-user'
    }),
    methods: {
    },
    computed: {
    },
    created() {
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>