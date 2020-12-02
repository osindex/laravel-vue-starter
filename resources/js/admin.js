import Vue from 'vue'
import ElementUI from 'element-ui'
import i18n from './lang'

import 'default-passive-events'
import 'element-ui/lib/theme-chalk/index.css'
import './assets/ali-icon/iconfont.css'
import './assets/ali-icon/ali.css'
import './assets/css/init.scss'
import App from './Admin.vue';

import router from './router'
import store from './store'
import config from './config'

Vue.use(ElementUI, {
  i18n: (key, value) => i18n.t(key, value)
})

import http from '@/libs/http'
window.axios = http

import Avue from '@smallwei/avue'
import '@smallwei/avue/lib/index.css'

import globalPlugin from './plugins'
Vue.use(globalPlugin)
Vue.use(Avue, { i18n: (key, value) => i18n.t(key, value) })

Vue.prototype.$config = config
Vue.prototype.$uploadUrl = '/api/files/upload'
Vue.prototype.$provider = 'admin'
// 默认
i18n.locale = config[Vue.prototype.$provider].locale ? config[Vue.prototype.$provider].locale : 'zh'

/* eslint-disable no-new */
const app = new Vue({
  el: '#app',
  router,
  store,
  i18n,
  render: h => h(App)
})