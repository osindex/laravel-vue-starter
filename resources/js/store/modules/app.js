import { getAdminMe } from '../../api/adminUser'
import { Message } from 'element-ui'

const state = {
  local: '',
  admin: {},
  breadcrumb: []
}

const getters = {
  breadcrumb: state => state.breadcrumb,
  admin: state => state.admin
}
const mutations = {
  SET_BREADCRUMB (state, breadcrumb) {
    let title = []
    state.breadcrumb = breadcrumb.filter( item => {
      if (title.indexOf(item.meta.title) >= 0) {
        return false;
      }
      title.push(item.meta.title)
      return item.meta.title
    })
  },
  SET_ADMIN(state, admin) {
    state.admin = admin
  }
}

const actions = {
  getMe({ getters, state, commit }) {
    // 如果没有才获取数据
    if (!getters.admin.hasOwnProperty('id')) {
      getAdminMe().then(response => {
        // console.log(response.data)
        commit('SET_ADMIN', response.data)
        // if (response.data.is_lock) {
        //   setTimeout(function() {
        //     commit('SET_PERMISSIONS', [])
        //     commit('SET_MENU', [])
        //     Message.error({
        //       showClose: true,
        //       message: '此账号被停用，请联系管理员',
        //       duration: 0
        //     })
        //   }, 1500)
        // }
        return Promise.resolve(response.data)
      })
    } else {
      return Promise.reject('数据已存在')
    }
  }
}

export default {
  state,
  getters,
  mutations,
  actions
}