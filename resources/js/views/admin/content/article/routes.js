export default [
  {
    name: 'articleIndex',
    path: 'content/article',
    meta: {
      provider: 'admin',
      title: 'article',
      cache: true,
      permission: 'article.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]