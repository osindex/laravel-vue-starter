import { index, add, edit, del } from '@/api/base'
import { parseFilter, parseFilterExtend, pageFormat, dateChange } from '@/libs/table'
import notify from '@/libs/notify'
import generalFunc from '@/mixins/generalFunc'

export default {
  mixins: [generalFunc],
  data() {
    return {
      cloneSearch: true,
      // 默认true 跟随改变 以免引起联动问题 有问题的页面修改 cloneSearch false
      isControl: false,
      avueController: {
        border: false,
        stripe: false,
        showHeader: true,
        index: false,
        selection: false,
        size: 'mini',
      },
      listSelectedItems: [],
      obj: {},
      option: {
        title: '表格的标题',
        page: true,
        align: 'center',
        menuAlign: 'center',
        // menuType:'icon' | 'text',
        dateBtn: true,
        dateDefault: true,
        column: [
          {
            label: '名称',
            prop: 'name'
          },
          {
            label: '日期',
            prop: 'created_at',
            type: 'datetime',
            format: 'yyyy-MM-dd hh:mm:ss',
            valueFormat: 'yyyy-MM-dd hh:mm:ss'
          }
        ]
      },
      loading: false,
      dataTable: [],
      pagination: {
        pageSizes: [10, 20, 30, 50],
        currentPage: 1,
        total: 0,
        pageSize: 10
      },
      queryParams: {},
      dontSearch: [],
      urlProp: []
    }
  },
  methods: {
    fetchData() {
      // 具体逻辑各自处理
    },
    // 清空筛选里面不允许清空的条件
    mustParams() {
    },
    buttonSize(size) {
      return size === 'medium' ? 'small' : size
    },
    sendGetParams(other = {}) {
      this.mustParams()
      let query = parseFilter(this.queryParams, false, this.dontSearch, this.cloneSearch)
      // 新定义 避免搜索污染
      // console.log(this.queryParams,2)
      return { ...other, ...this.urlProp, page: this.pagination.currentPage, pageSize: this.pagination.pageSize, filter: query }
    },
    selectionChange(list) {
      this.listSelectedItems = list
    },
    sortableChange(sort) {
      console.log(sort, 'sortableChange')
    },
    dateChange(date) {
      // 也可以用 字段的more date方法
      dateChange(date, 'created_at', this)
      this.currentChange(1)
    },
    // 模块化操作
    sortChange(list) {
      console.log(list, 'sortChange')
    },
    sizeChange(val) {
      this.pagination.currentPage = 1
      this.pagination.pageSize = Number(val)
      this.getTable()
    },
    currentChange(val) {
      this.pagination.currentPage = val
      this.getTable()
    },
    searchChange(params = {}, done = ()=>{}) {
      this.queryParams = params
      this.getTable()
      done()
    },
    searchReset() {
      // 可自定义
      this.queryParams = {}
      this.currentChange(1)
    },
    // 2019-12-17 新增筛选逻辑
    filterChange(result) {
      // console.log(this.$refs.crud.$refs.dialogFilter.list)
      this.queryParams = parseFilterExtend(this.$refs.crud.$refs.dialogFilter.list)
      this.getTable()
    },
    async getTable(module = null) {
      if (!module) {
        module = this.module
      }
      const { data, meta } = await index(module, this.sendGetParams())
      this.dataTable = data
      // console.log(data,'dddd')
      this.getTableAfter()
      pageFormat(meta, this)
      // index(module, this.sendGetParams()).then(res=>{
      //   this.dataTable = res.data
      //   pageFormat(res.meta, this)
      // })
    },
    handleRowClick(row, event, column) {
      this.$refs.crud.rowEdit(row, row.$index)
    },
    async handleDelOk(ids) {
      let id = [ids]
      if (typeof (ids) === 'number') {
        for (let i = 0; i < this.dataTable.length; i++) {
          if (this.dataTable[i].id == ids) {
            this.dataTable.splice(i, 1)
          }
        }
      } else if (typeof (ids) === 'string') {
        id = ids.split(',')
        for (let i = 0; i < this.dataTable.length; i++) {
          for (let k = 0; k < id.length; k++) {
            if (this.dataTable[i].id == id[k]) {
              this.dataTable.splice(i, 1)
            }
          }
        }
      }
      del(`${this.module}/${ids}`).then(res => {})
      this.$message.success(id.length + '项 删除完毕')
      if (this.pagination) {
        this.pagination.total -= id.length
      }
      // const getListRes = await this.getList()
      // !getListRes.dataTable.length && this.goPrevPage()
    },
    toggleSelection() {
      const selectedIndex = this.dataTable.filter(item => this.listSelectedItems.indexOf(item) === -1)
      // selectedIndex.forEach(e=>{
      //   console.log(e)
      // })
      this.$refs.crud.toggleSelection(selectedIndex.length ? selectedIndex : '')
      // 未知原因 不生效
    },
    refreshChange() {
      this.getTable()
    },

    handleAdd() {
      this.$refs.crud.rowAdd()
    },
    handleDel(row, index) {
      row.title = row.title || ''
      this.$confirm(`${this.$t('areyou')}${this.$t('delete')}: ${row.title} ID:${row.id}`, this.$t('notice'), {
        confirmButtonText: this.$t('confirm'),
        cancelButtonText: this.$t('cancel'),
        type: 'warning'
      }).then(res => {
        console.log(row, index)
        del(this.module, row.id).then(response => {
          if (response.status === 204) {
            this.dataTable.splice(index, 1)
            this.changeAfter('batchDelete', row)
            notify.deleteSuccess(this)
          }
        })
      })
        .catch(function(err) {})
    },
    handleDelSelected() {
      if (this.listSelectedItems.length > 0) {
        this.$prompt(`${this.$t('input')} 'all' ${this.$t('done')}`, this.$t('notice'), {
          confirmButtonText: this.$t('confirm'),
          cancelButtonText: this.$t('cancel'),
          // inputPattern: /[\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/,
          inputPattern: /^all$/,
          inputErrorMessage: this.$t('error')
        }).then(({ input }) => {
          deleteData(this.listSelectedItems.map(e => e.id).join(','), this.uri).then(response => {
            if (response.status === 204) {
              // this.listSelectedItems.forEach(e => {
              //     this.dataTable.splice(e.$index, 1)
              // })
              // 重新获取数据更准确
              this.getTable()
              this.$notify({
                showClose: true,
                message: this.$t('delbatch'),
                type: 'success'
              })
            }
          })
        }).catch(() => {
          // cancel
        })
      } else {
        this.$notify({
          showClose: true,
          message: this.$t('plsselect'),
          type: 'warning'
        })
      }
    },
    handleUpdate(row, index, done, loading) {
      edit(this.module, row.id, row).then(response => {
        this.changeAfter('update', row)
        this.getTable()
        done()
        notify.editSuccess(this)
      }).catch(er => {
        setTimeout(() => {
          loading()
        }, 2000)
      })
    },
    handleSave(row, done, loading) {
      add(this.module, row).then(
        response => {
          if (response.status === 201) {
            this.changeAfter('save', row)
            this.getTable()
            done()
            notify.createSuccess(this)
          } else {
            setTimeout(() => {
              done()
            }, 3000)
          }
        }).catch(er => {
        setTimeout(() => {
          loading()
        }, 2000)
      })
    },
    handleRowDBLClick(row, event) {
      this.$refs.crud.rowEdit(row, row.$index)
    },
    changeAfter(type, row){
      console.log('changeAfter: ' + type)
    },
    getTableAfter() {
      // 加载数据之后
    }
  },
  watch: {
    // 如果路由有变化，会再次执行该方法
    '$route': 'fetchData'
  }
}
