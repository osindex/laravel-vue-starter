export default [
  {
    name: 'indexIndex',
    path: 'dept/index',
    meta: {
      provider: 'admin',
      title: 'deptIndex',
      cache: true,
      permission: 'dept.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]