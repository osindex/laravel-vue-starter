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

  export default {
    name: 'testIndex',
    components: {
    },
    data: () => ({
    }),
    methods: {
    },
    computed: {
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