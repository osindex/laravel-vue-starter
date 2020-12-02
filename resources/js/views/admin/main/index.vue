<template>
  <el-container style="height:100%">
    <nav-bar :is-collapse="isCollapse"></nav-bar>
    <el-container direction="vertical">
      <mojito-header :is-collapse="isCollapse"  v-on:menu="changeMenuStatus"></mojito-header>
      <tags-view></tags-view>
      <el-main>
        <keep-alive :include="cacheTags">
          <router-view/>
        </keep-alive>
      </el-main>
      <div v-for="(item,index) in dialogs" :key="index">
              <el-dialog
                top="5vh"
                :fullscreen="item.fullscreen"
                :title="item.title"
                :visible.sync="!!item&&item.visible"
                :append-to-body="false"
                :before-close="handleClose"
              >
                <component :is="item.id" v-if="!!item&&item.visible" v-bind="item.bind" @closeDialog="item.closeDialog(index)" />
              </el-dialog>
            </div>
    </el-container>
  </el-container>
</template>

<script>
  import Vue from 'vue'
  import { MojitoHeader, NavBar, TagsView } from '../../../components/Layout'
  import { mapActions } from 'vuex'
  import { routeByName } from '@/libs/util'
  import generalFunc from '@/mixins/generalFunc'
  export default {
    data() {
      return {
        isCollapse: false,
        dialogs: []
      }
    },
    mixins: [generalFunc],
    components: {
      TagsView,
      MojitoHeader,
      NavBar
    },
    methods: {
      ...mapActions([
        'loadPermissions'
      ]),
      changeMenuStatus(isCollapse) {
        this.isCollapse = isCollapse
      }
    },
    beforeRouteUpdate(to, from, next) {
      console.log('jump being intercepted by main index')
      // 具体用法查看minxins/proxy.js
      if (to.name === 'proxy') {
        const id = 'dialog' + Math.floor(Math.random() * 1000000000000000 + 1)
        const route = routeByName(to.params.name)
        Vue.component(id, route.component)
        // 拦截dialog路由 根据name实例化组件`
        this.dialogs.push({
          id: id,
          visible: true,
          dWidth: to.meta.width,
          fullscreen: to.params.fullscreen || false,
          // 绑定的组件参数
          bind: to.params,
          title: to.params.title || to.meta.title,
          closeDialog: (i) => {
            Vue.set(this.dialogs[i], 'visible', false)
            this.dialogs.splice(i, 1)
            // this.closeEnd()
          }
        })
        return false
      }
      next()
    },
    created() {
      this.loadPermissions()
    },
    computed: {
      cacheTags() {
        return this.$store.getters.cacheTags
      }
    }
  }
</script>