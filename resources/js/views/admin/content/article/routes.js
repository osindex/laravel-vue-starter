export default [
  {
    name: 'articleIndex',
    path: 'content/article',
    meta: {
      provider: 'admin',
      title: 'article',
      cache: true,
      permission: 'article'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]