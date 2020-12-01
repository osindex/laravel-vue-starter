export default [
  {
    name: 'slider_groupIndex',
    path: 'content/slider_group',
    meta: {
      provider: 'admin',
      title: 'slider_group',
      cache: true,
      permission: 'slider_group.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]