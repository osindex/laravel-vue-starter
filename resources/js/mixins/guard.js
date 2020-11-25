import config from '../config'

export default {
  data() {
    return {
    }
  },
  methods: {
  },
  watch: {
  },
  computed: {
    showGuard(){
      return config.guardNames.length > 1
    },
    defaultGuard(){
      const guard = config.guardNames.find(e=>e.default)
      return guard.value || 'admin'
    }
  }
}