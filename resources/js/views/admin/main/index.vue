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
      <!-- 增加拖拽功能 有点麻烦 -->
      <div v-for="(item,index) in dialogs" :key="index">
              <el-dialog
                top="5vh"
                class="avue-dialog"
                :fullscreen="item.proxyFullscreen"
                :title="item.proxyTitle"
                :visible.sync="!!item&&item.proxyVisible"
                :append-to-body="false"
                :before-close="handleClose"
                v-dialogdrag
                v-if="item.proxyDrag"
              >
                <component :is="item.proxyId" v-if="!!item&&item.proxyVisible" v-bind="item.proxyBind" v-on="item.proxyOn" @closeDialog="item.closeDialog(index)" />
              </el-dialog>
              <el-dialog
                top="5vh"
                class="avue-dialog"
                center
                :fullscreen="item.proxyFullscreen"
                :title="item.proxyTitle"
                :visible.sync="!!item&&item.proxyVisible"
                :append-to-body="false"
                :before-close="handleClose"
                v-else
              >
                <component :is="item.proxyId" v-if="!!item&&item.proxyVisible" v-bind="item.proxyBind" v-on="item.proxyOn" @closeDialog="item.closeDialog(index)" />
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
      console.log('jump being intercepted by main index', to)
      // 具体用法查看minxins/proxy.js
      if (to.name === 'proxy') {
        const id = 'dialog' + Math.floor(Math.random() * 1000000000000000 + 1)
        const route = routeByName(to.params.proxyName)
        console.log(route,'rrrroute',to.params)
        Vue.component(id, route.component)
        // 拦截dialog路由 根据name实例化组件`
        this.dialogs.push({
          proxyId: id,
          proxyVisible: true,
          dWidth: to.meta.width,
          proxyFullscreen: to.params.proxyFullscreen || false,
          // 绑定的组件参数
          proxyBind: to.params.proxyBind,
          proxyOn: to.params.proxyOn,
          proxyDrag: to.params.proxyDrag,
          // proxyTitle 不是 单独属性，放到row一起展示
          proxyTitle: to.params.proxyTitle || this.$t(`meta.title.${route.meta.title}`),
          closeDialog: (i) => {
            // 实际上只是隐藏 而不是清除
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