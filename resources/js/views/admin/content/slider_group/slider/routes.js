export default [
  {
    name: 'sliderIndex',
    path: 'content/slider',
    meta: {
      provider: 'admin',
      title: 'slider',
      cache: true,
      permission: 'slider.index'
    },
    component: resolve => void(require(['./index.vue'], resolve))
  }
]