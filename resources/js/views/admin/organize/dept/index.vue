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
    name: 'deptIndex',
    components: {
      Avue
    },
    mixins: [table, proxy],
    data: () => ({
      module: '/api/dept'
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
            {
              'prop': 'name',
              'label': '名称',
              'span': 12,
              'display': true,
              search: true
            },
            {
              'prop': 'parent_id',
              'label': '上级部门',
              'search': true,
              type:'select',
              props: {
                  label: 'name',
                  value: 'id'
              },
              dicUrl:'/api/dept/option',
              'span': 8,
              search: true
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
        return hasPermission('dept.update')
      },
      addPermission: function() {
        return hasPermission('dept.store')
      },
      deletePermission: function() {
        return hasPermission('dept.destroy')
      }
    },
    created() {
      this.fetchData()
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>