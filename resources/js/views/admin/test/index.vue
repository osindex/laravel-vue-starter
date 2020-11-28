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
            @row-click="handleRowClick"
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
            <template slot="user_student" slot-scope="{row}">
              <el-tag>{{row.user.student.name}}</el-tag>
            </template>
            
            <template slot="regegionForm" slot-scope="{row}">
                <!-- <Address v-model="address" @update="addressChange"/> -->
                <al-selector
                  v-model="address"
                  @change="addressChange"
                  data-type="name"
                  searchable
                  init-data
                  level="2"
                />
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
  import proxy from '@/mixins/proxy'


  export default {
    name: 'testIndex',
    components: {
      Avue
    },
    mixins: [table, proxy],
    data: () => ({
        module: 'test',
    }),
    methods: {
    },
    computed: {

      optionTable() {
            return {
              ...this.avueController,
              // 头部控制器
              page: this.pagination,
              align: 'center',
              menuAlign: 'center',
              dialogFullscreen: true,
              // menuType: 'menu',
              labelWidth: 120,
              editBtn: false,
              searchLabelWidth: 120,
              column: [
                {
                  'prop': 'user_id',
                  'label': '上报人员',
                  'slot': true,
                  'search': true,
                  'searchslot': true,
                  'span': 8,
                },
                {
                  'prop': 'file',
                  'label': '报告',
                  'type': 'upload',  
                  'listType': 'picture-img',
                  'tip': '只能上传jpg/png类型，且不超过1000kb',
                  // 'propsHttp': {
                  //   res: 'data'
                  // },
                  'url': 'url',
                  'action': this.uploadUrl,
                  'span': 18,
                  'display': true
                },
                {
                  'prop': 'hospital',
                  'label': '检查医院',
                  'span': 12,
                  'display': true
                },
                {
                  'prop': 'hospital_address',
                  'label': '医院地址',
                  'span': 12,
                },
                {
                  'prop': 'check_date',
                  'label': '检查日期',
                  'type': 'date',
                  valueFormat: "yyyy-MM-dd",
                  format: "yyyy-MM-dd",
                  'span': 8
                },
                {
                  'prop': 'state',
                  'label': '报告状态',
                  'type': 'select',
                  'dicData': this.$config.checkNAState,
                  'span': 8,
                },
                // {
                //   'prop': 'check_step',
                //   'label': '审核步骤',
                //   'type': 'select',
                //   'dicData': this.$config.checkNAStep,
                //   'span': 8,
                // },
                // 子表控制步骤
                {
                  'type': 'radio',
                  'labelWidth': 160,
                  'label': '是否有效',
                  'dicData': [
                    {
                      'label': '是',
                      'value': 1
                    },
                    {
                      'label': '否',
                      'value': 0
                    }
                  ],
                  'span': 8,
                  'display': true,
                  'prop': 'is_allow',
                  'value': 1,
                  'required': true
                }
              ]
            }
          },
      updatePermission: function() {
        return hasPermission('test.update')
      },
      addPermission: function() {
        return hasPermission('test.store')
      },
      deletePermission: function() {
        return hasPermission('test.destroy')
      }
    },
    created() {
    }
  }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
</style>