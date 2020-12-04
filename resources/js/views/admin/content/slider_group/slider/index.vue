<template>
  <div>
    <Avue :is-controller="false" :value="avueController">
      <el-container>
        <el-main>
          <avue-crud ref="crud"
          v-model="obj"
          :data="dataTable"
          :option="optionTable"
          :page="pagination"
          :table-loading="loading"
          @selection-change="selectionChange"
          @date-change="dateChange"
          @search-reset="searchReset"
          @search-change="searchChange"
          @refresh-change="refreshChange"
          @sort-change="sortChange"
          @row-update="handleUpdate"
          @row-save="handleSave"
          @row-del="handleDel"
          @size-change="sizeChange"
          @current-change="currentChange"
          @row-dblclick="handleRowDBLClick">
          </avue-crud>
        </el-main>
      </el-container>
    </Avue>
  </div>
</template>
<script>
import { hasPermission } from '@/libs/permission'
import Avue from '@/components/Form/Avue'
import table from '@/mixins/table'
import proxy from '@/mixins/proxy'

export default {
  name: 'sliderIndex',
  components: {
    Avue
  },
  props: {
    groupId: {
      type: Number,
      default: () => 0,
    },
    data: {
      type: null,
      default: () => []
    }
  },
  mixins: [table, proxy],
  data() {
    return {
      module: '/api/slider',
      // obj: {
      //   published_at: this.$dayjs().format()
      // }
    // urlProp: {
    //   with: 'slider'
    // }
    }
  },
  methods: {
    fetchData() {
      this.getTable()
    },
    getTableAfter(){
      // 不论什么改变 调整原数据
      this.$emit('dataChange', this.dataTable)
    }
  },
  computed: {
    optionTable() {
      return {
        ...this.avueController,
        // 头部控制器
        page: this.pagination,
        align: 'left',
        menuAlign: 'center',
        dialogFullscreen: true,
        // menuType: 'menu',
        labelWidth: 100,
        editBtn: true,
        searchLabelWidth: 120,
        viewBtn: true,
        column: [
          {
            prop: 'group_id',
            value: this.groupId,
            display: false,
          },
          {
            'prop': 'title',
            'label': '名称',
            'span': 12,
            rules: [{
              required: true,
              message: "请输入名称",
              trigger: "blur"
            }],
            'display': true
          },
          {
            'prop': 'cover',
            'label': '封面',
            'type': 'upload',
            'listType': 'picture-img',
            'tip': '只能上传jpg/png类型，且不超过1000kb',
            // 'propsHttp': {
            //   res: 'data'
            // },
            'url': 'url',
            'action': this.$uploadUrl,
            'span': 24,
            'display': true
          },
          {
            'prop': 'url',
            'label': '跳转链接',
            'span': 8,
          },
          {
            prop: 'sequence',
            label: '排序',
            type: 'number',
            span: 4
          },
          {
            prop: 'published_at',
            label: '发布时间',
            type: 'datetime',
            valueFormat: 'yyyy-MM-dd HH:mm:ss',
            value: this.$dayjs().format('YYYY-MM-DD HH:mm:ss'),
            rules: [{
              required: true,
              message: "请选择时间",
              trigger: "blur"
            }],
            overHidden: true,
            span: 6
          },
          {
            prop: 'state',
            label: '状态',
            type: 'switch',
            value: 1,
            dicData: this.$config.stateList,
            span: 6
          },
          {
            'prop': 'description',
            'label': '描述',
            'type': 'textarea',
            'span': 24,
          }
        ]
      }
    },
    updatePermission: function() {
      return hasPermission('slider.update')
    },
    addPermission: function() {
      return hasPermission('slider.store')
    },
    deletePermission: function() {
      return hasPermission('slider.destroy')
    }
  },
  mounted() {
    if (this.data && this.data.length) {
      this.dataTable = this.data
    } else {
      this.fetchData()
    }
  }
}

</script>
<style rel="stylesheet/scss" lang="scss" scoped>
</style>
