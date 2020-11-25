export default [
  {
    name: 'testIndex',
    path: 'test',
    meta: {
      provider: 'admin',
      title: 'test',
      cache: true,
      permission: 'test.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]