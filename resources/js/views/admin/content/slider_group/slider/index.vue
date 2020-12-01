<template>
  <div>
    slider
  </div>
</template>

<script>
  import { hasPermission } from '@/libs/permission'

  export default {
    name: 'sliderIndex',
    components: {
    },
    data: () => ({
    }),
    methods: {
    },
    computed: {
      updatePermission: function() {
        return hasPermission('slider.update')
      },
      addPermission: function() {
        return hasPermission('slider.store')
      },
      deletePermission: function() {
        return hasPermission('slider.destroy')
      }
    },
    created() {
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>