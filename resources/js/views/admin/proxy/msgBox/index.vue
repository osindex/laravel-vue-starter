<template>
  <div>
    msgBox
  </div>
</template>

<script>
  import { hasPermission } from '@/libs/permission'

  export default {
    name: 'msgBoxIndex',
    components: {
    },
    data: () => ({
    }),
    methods: {
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
    created() {
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>