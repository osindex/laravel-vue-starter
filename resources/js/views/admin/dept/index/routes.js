export default [
  {
    name: 'indexIndex',
    path: 'dept/index',
    meta: {
      provider: 'admin',
      title: 'index',
      cache: true,
      permission: 'index.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]