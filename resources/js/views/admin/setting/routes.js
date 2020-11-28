export default [
  {
    name: 'setting',
    path: 'setting',
    meta: {
      provider: 'admin',
      title: 'setting',
      cache: true,
      permission: 'setting.index'
    },
    component: resolve => void (require(['./index.vue'], resolve))
  }
]
