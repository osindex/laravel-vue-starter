export default [
  {
    name: 'userIndex',
    path: 'dept/user',
    meta: {
      provider: 'admin',
      title: 'user',
      cache: true,
      permission: 'user.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]