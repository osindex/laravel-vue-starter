export default [
  {
    name: 'deptUser',
    path: 'organize/dept-user',
    meta: {
      provider: 'admin',
      title: 'deptUser',
      cache: true,
      permission: 'dept-user.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]