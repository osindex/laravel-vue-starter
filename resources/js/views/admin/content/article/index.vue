<template>
  <div>
      <Avue :is-controller="false" :value="avueController">
      <el-container>
        <el-aside width="240px" v-if="showTree">
          <avue-tree
            v-model="treeModel"
            :option="treeOption"
            :data="treeData"
            @update="handleUpdateTree"
            @save="handleSaveTree"
            @del="handleDelTree"
            @node-click="nodeClick"
          />
        </el-aside>
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
  import Avue from '@/components/Form/Avue'
  import table from '@/mixins/table'
  import tree from '@/mixins/tree'
  import proxy from '@/mixins/proxy'

  export default {
    name: 'articleIndex',
    components: {
      Avue
    },
    mixins: [table, tree, proxy],
    data: () => ({
      showTree: true,
      treeModule: '/api/category',
      module: '/api/article'
    }),
    methods: {
      fetchData() {
        this.getTree()
        this.getTable()
      },
      nodeClick(data) {
        console.log((data))
        this.queryParams.category_id = data.id
        this.pagination.currentPage = 1
        this.getTable();
      }
    },
    computed: {
      treeOption() {
          return {
            defaultExpandAll: false,
            addBtn: false,
            props: {
              labelText: "标题",
              label: "title",
              value: "id",
              children: "children"
            }
          }
      },
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
        return hasPermission('article.update')
      },
      addPermission: function() {
        return hasPermission('article.store')
      },
      deletePermission: function() {
        return hasPermission('article.destroy')
      }
    },
    created() {
      this.fetchData()
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>