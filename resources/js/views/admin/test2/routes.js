export default [
  {
    name: 'test2Index',
    path: 'test2',
    meta: {
      provider: 'admin',
      title: 'test2',
      cache: true,
      permission: 'test2.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]