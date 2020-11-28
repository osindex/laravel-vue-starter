import Vue from'vue'
import Vuex from 'vuex'
import app from './modules/app'
import tag from './modules/tag'
import menu from './modules/menu'
import permission from './modules/permission'
import login from './modules/login'
import plugin from './plugin'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    app,
    menu,
    permission,
    login,
    tag
  },
  plugins: [plugin,
	  createPersistedState({reducer(val) {
	     return {
	        // login: val.token
	     }
	  }})
  ]
})

export default store