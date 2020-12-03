export default {
  data() {
    return {
    }
  },
  methods: {
  	/**
  	 * 代理弹窗路由
  	 * @param  {String}  name       真实路由的name
  	 * @param  {Object}  params     真实路由对应的组件props(+弹窗的标题等外层属性)
     * proxyName|proxyOn|proxyFullscreen
  	 * @param  {Boolean} fullscreen 弹窗的全屏设置,单独处理
  	 * @return {Func}    跳转页面转弹窗
  	 */
    proxy: function(name, params = {}, on = {}, proxyDrag = false, fullscreen = false) {
      return this.$router.push({ name: 'proxy', params: { proxyName: name, proxyOn: on, proxyDrag: proxyDrag, proxyFullscreen: fullscreen, proxyBind: params }})
    }
    // this.proxy('msgBoxIndex', {...row,proxyTitle: '编辑'})
  }
}
