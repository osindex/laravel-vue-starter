export default [
  {
    name: 'msgBoxIndex',
    path: 'proxy/msgBox',
    meta: {
      provider: 'admin',
      title: 'msgBox',
      cache: true,
      permission: 'msgBox.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]