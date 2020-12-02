export default [
  {
    name: 'pageDesign',
    path: 'page-design',
    meta: {
      provider: 'admin',
      title: 'pageDesign',
      cache: true,
      permission: 'page-design.index'
    },
    component: resolve => void (require(['./index.vue'], resolve))
  }
]
