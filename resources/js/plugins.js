import lodash from 'lodash'
import dayjs from 'dayjs'
import 'dayjs/locale/zh-cn' // 按需加载
import Sortable from 'sortablejs'
import { hasPermission } from '@/libs/permission'

import alSelector from '@/components/Suite/Address/al-selector.vue'
import alCascader from '@/components/Suite/Address/al-cascader.vue'
import AvueFormDesign from 'avue-form-design'

// avue插件
import AvueUeditor from 'avue-plugin-ueditor'
// https://avuejs.com/doc/plugins/ueditor-plugins
import AvueMap from 'avue-plugin-map'
// https://avuejs.com/doc/plugins/map-plugins
// 转avue插件

import Address from '@/components/Select/Address'

import selectRole from '@/components/Select/Role'
import selectRoleMultiple from '@/components/Select/RoleMultiple'

export default {
  install(Vue) {
    window._ = lodash
    window.Sortable = Sortable
    dayjs.locale('zh-cn')
    Vue.prototype.$dayjs = dayjs
    Vue.prototype.$hasPermission = hasPermission
    Vue.use(AvueFormDesign)
    Vue.component(alSelector.name, alSelector)
    Vue.component(alCascader.name, alCascader)

    Vue.component(AvueUeditor.name, AvueUeditor)
    Vue.component(AvueMap.name, AvueMap)

    // 以下是非avue组件转avue组件用 (额外前缀)
    Vue.component('avue' + Address.name, Address)
    Vue.component('avue' + selectRole.name, selectRole)
    Vue.component('avue' + selectRoleMultiple.name, selectRoleMultiple)
  }
}
