export default [
  {
    name: 'categoryIndex',
    path: 'content/category',
    meta: {
      provider: 'admin',
      title: 'category',
      cache: true,
      permission: 'category'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]