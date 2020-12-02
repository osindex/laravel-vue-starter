import Vue from 'vue'
export default {
  data() {
    return {
      drawerShow: false,
    }
  },
  methods: {
    handleClose(done) {
      this.$confirm('确认关闭？')
        .then(_ => {
          done()
        })
        .catch(_ => {})
    },
    handleClick(item) {
      console.log(item)
    },
    arrSize(res) {
      return _.size(res)
    },
    arrSum(res, name) {
      return _.sumBy(res, function(o) { return o[name] })
    },
    drawerClose() {
      this.drawerShow = false
      this.fetchData()
    }
  },
  watch: {
  },
  computed: {
  }
}
