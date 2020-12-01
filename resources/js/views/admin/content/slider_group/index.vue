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
            <template slot="sliderForm" slot-scope="scope">
              <avue-crud :option="sliderOption" :data="sliderData"></avue-crud>
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
  import proxy from '@/mixins/proxy'

  export default {
    name: 'slider_groupIndex',
    components: {
      Avue
    },
    mixins: [table, proxy],
    data: () => ({
      module: '/api/slider_group',
      urlProp: {
        with: 'slider'
      },
      sliderData: [],
      sliderPagination: {
        pageSizes: [10, 20, 30, 50],
        currentPage: 1,
        total: 0,
        pageSize: 10
      }
    }),
    methods: {
      fetchData() {
        this.getTable()
      },
      // nodeClick(data) {
      //   console.log((data))
      //   this.queryParams.category_id = data.id
      //   this.pagination.currentPage = 1
      //   this.getTable();
      // }
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
          viewBtn: true,
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
            },
            {
              labelWidth:0,
              label: '',
              prop: 'slider',
              span: 24,
              hide: true,
              formslot: true,
            }
            
          ]
        }
      },
      sliderOption() {
        return {
                  ...this.avueController,
                  page: this.sliderPagination,
                  column: [
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
                      'prop': 'url',
                      'label': '跳转链接',
                      'span': 12,
                    },
                    {
                      prop: 'sequence',
                      label: '排序',
                      type: 'number',
                      span: 12
                    },
                    {
                      'prop': 'description',
                      'label': '描述',
                      'span': 24,
                    }
                  ]
                }
      },
      updatePermission: function() {
        return hasPermission('slider_group.update')
      },
      addPermission: function() {
        return hasPermission('slider_group.store')
      },
      deletePermission: function() {
        return hasPermission('slider_group.destroy')
      }
    },
    created() {
      this.fetchData()
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>