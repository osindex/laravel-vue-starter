<template>
  <div>
    test2
  </div>
</template>

<script>
  import { hasPermission } from '@/libs/permission'

  export default {
    name: 'test2Index',
    components: {
    },
    data: () => ({
    }),
    methods: {
    },
    computed: {
      updatePermission: function() {
        return hasPermission('test2.update')
      },
      addPermission: function() {
        return hasPermission('test2.store')
      },
      deletePermission: function() {
        return hasPermission('test2.destroy')
      }
    },
    created() {
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>