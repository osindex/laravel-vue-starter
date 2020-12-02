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
            <template slot="sliderForm" slot-scope="{row}">
              <slider :groupId.sync="row.id" :data.sync="row.slider" @dataChange="data=>syncSliderRow(row, data)"></slider>
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
  // import proxy from '@/mixins/proxy'
  import slider from './slider'

  export default {
    name: 'slider_groupIndex',
    components: {
      Avue, slider
    },
    mixins: [table],
    data: () => ({
      module: '/api/slider_group',
      urlProp: {
        expand: 'slider'
      }
    }),
    methods: {
      fetchData() {
        this.getTable()
      },
      syncSliderRow(row, data) {
        this.dataTable[row.$index].slider = data
        // row.slider = data 无效
      }
      // nodeClick(data) {
      //   console.log((data))
      //   this.queryParams.category_id = data.id
      //   this.pagination.currentPage = 1
      //   this.getTable();
      // }
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
              viewDisplay: false,
              // 'display': true
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
              viewDisplay: false,
              // 'display': true
            },
            {
              'prop': 'description',
              'label': '描述',
              viewDisplay: false,
              'span': 12,
            },
            {
              prop: 'sequence',
              label: '排序',
              type: 'number',
              viewDisplay: false,
              span: 12
            },
            {
              labelWidth:0,
              label: '',
              prop: 'slider',
              span: 24,
              hide: true,
              addDisplay: false,
              editDisplay: false,
              formslot: true,
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