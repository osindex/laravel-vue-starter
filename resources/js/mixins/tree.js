import { index, add, edit, del } from '@/api/base'
import notify from '@/libs/notify'
import { parseFilter } from '@/libs/table'

export default {
  data() {
    return {
      treeModule: '',
      treeModel: {},
      treeData: [],
      queryTreeParams: {},
      urlTreeProp: []
    }
  },
  methods: {
    mustTreeParams() {
      // 强制条件 如
      // this.queryTreeParams.abd = 1
    },
    sendGetTreeParams(other = {}) {
      this.mustTreeParams()
      let query = parseFilter(this.queryTreeParams, false)
      return { ...other, ...this.urlTreeProp, filter: query }
    },
    async getTree(module = null) {
      if (!module) {
        module = this.treeModule + '/tree'
      }
      const { data, meta } = await index(module, this.sendGetTreeParams())
      this.treeData = data
    },
    handleDelTree(data, node, done) {
      this.$confirm(`${this.$t('areyou')}${this.$t('delete')}: ${row.name} ID:${row.id}`, this.$t('notice'), {
        confirmButtonText: this.$t('confirm'),
        cancelButtonText: this.$t('cancel'),
        type: 'warning'
      }).then(res => {
        del(this.treeModule, row.id).then(response => {
          if (response.status === 204) {
            this.treeData.splice(index, 1)
            notify.deleteSuccess(this)
            done()
          }
        })
      })
        .catch(function(err) {})
    },
    handleUpdateTree(data, node, done) {
      edit(this.treeModule, data.id, data).then(response => {
        notify.editSuccess(this)
        done()
      })
    },
    handleSaveTree(data, node, done) {
      // console.log(data, node, typeof node)
      let saveData = this.treeModel
      if (node.hasOwnProperty('data')) {
        saveData.parent_id = node.data.id
      }
      add(this.treeModule, saveData).then(response => {
        if (response.status === 201) {
          this.getTree()
          done()
          notify.createSuccess(this)
        } else {
          console.log('error...')
        }
      })
      done()
    },
    nodeClick(data) {
          this.$message.success(JSON.stringify(data))
          this.getTable();
    }
  }
}
