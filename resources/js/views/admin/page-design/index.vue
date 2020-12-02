<template>
  <avue-form-design
    :options="options"
    :aside-left-width="lwidth"
    :aside-right-width="rwidth"
    storage
    @submit="handleSubmit"
  />
</template>

<script>
import { hasPermission } from '@/libs/permission'

export default {
  name: 'PageDesign',
  data() {
    return {
      lwidth: '270px',
      rwidth: '380px',
      options: {
      }
    }
  },
  computed: {
    updatePermission: function() {
      return hasPermission('page-design.update')
    },
    addPermission: function() {
      return hasPermission('page-design.store')
    },
    deletePermission: function() {
      return hasPermission('page-design.destroy')
    }
  },
  beforeDestroy() {
    // const wm = document.getElementById(this.wm.CONTAINERID)
    // wm.parentNode.removeChild(wm)
    // 删除不了
  },
  created() {
    // this.$nextTick(() => {
    //   console.log('111')
    // })
  //   this.wm = this.watermark({
  //     text:config.admin.appName.fullName,
  //     fontFamily: 'microsoft yahei',
  //     color: "#999",
  //     fontSize: 16,
  //     opacity: 100,
  //     bottom: 10,
  //     right: 10,
  //     ratio: 1
  // })
  },
  methods: {
    handleSubmit(e) {
      console.log(e)
    }
  }
}
</script>
<style>
  #drawer .avue-comment__avatar {
    display: none !important;
  }
</style>
<style rel="stylesheet/scss" lang="scss" scoped>
.fr {
  position: absolute;
  right: 2em;
  bottom: 5em;
}
.waterfall-container{
  width: 100%
}
.action {
  padding: 3px 0;margin-left: 5px;
}
.image {
  width: 100%
}
</style>
