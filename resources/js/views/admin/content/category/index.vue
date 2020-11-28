<template>
  <div>
      <Avue :is-controller="false" :value="avueController">
      <el-container>
        <el-main>
          <avue-crud
            ref="crud"
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
            @row-dblclick="handleRowDBLClick"
          >
            <template slot="user_id" slot-scope="{row}">
              <el-tag>{{row.user_type=='student' ? row.user.name : row.user.family_name}}</el-tag>
            </template>
            <template slot-scope="{row}" slot="user_studentSearch">
                <SearchStudent :nowValue.sync="row.user_student"/>
            </template>
          </avue-crud>
        </el-main>
      </el-container>
    </Avue>
  </div>
</template>

<script>
  import { hasPermission } from '@/libs/permission'
  import { tree } from '@/api/base'
  import Avue from '@/components/Form/Avue'
  import table from '@/mixins/table'
  import proxy from '@/mixins/proxy'

  export default {
    name: 'categoryIndex',
    components: {
      Avue
    },
    mixins: [table, proxy],
    data: () => ({
      module: '/api/category'
    }),
    methods: {
      fetchData() {
        this.getTable()
      },
      async getTable(module = null) {
        if (!module) {
          module = this.module
        }
        this.pagination.pageSize = 100
        const { data, meta } = await tree(module, this.sendGetParams({sort: '-ordering'}))
        this.dataTable = data
        // 不再分页
        // pageFormat(meta, this)
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
          labelWidth: 120,
          editBtn: true,
          searchLabelWidth: 120,
          tree: true,
          expandLevel: 3,
          column: [
            // {
            //   'prop': 'user_id',
            //   'label': '上报人员',
            //   'slot': true,
            //   'search': true,
            //   'searchslot': true,
            //   'span': 8,
            // },
            {
              'prop': 'title',
              'label': '名称',
              'span': 12,
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
              'span': 18,
              'display': true
            },
            {
              'prop': 'description',
              'label': '描述',
              'span': 12,
            },
            {
              prop: 'sequence',
              label: '排序',
              type: 'number',
              span: 12
            }
            
          ]
        }
      },
      updatePermission: function() {
        return hasPermission('category.update')
      },
      addPermission: function() {
        return hasPermission('category.store')
      },
      deletePermission: function() {
        return hasPermission('category.destroy')
      }
    },
    created() {
      this.fetchData()
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>