<template>
  <div>
    <Avue :is-controller="isController" :value="avueController">
      <el-container>
        <el-aside width="240px" v-if="showTree">
          <avue-tree v-model="treeModel" :option="treeOption" :data="treeData" @update="handleUpdateTree" @save="handleSaveTree" @del="handleDelTree" @node-click="nodeClick" />
        </el-aside>
        <el-main>
          <avue-crud ref="crud" v-model="obj" :data="dataTable" :option="optionTable" :page="pagination" :table-loading="loading" @selection-change="selectionChange" @date-change="dateChange" @search-reset="searchReset" @search-change="searchChange" @refresh-change="refreshChange" @sort-change="sortChange" @row-update="handleUpdate" @row-save="handleSave" @row-del="handleDel" @size-change="sizeChange" @current-change="currentChange" @row-dblclick="handleRowDBLClick">
            <template slot="openid" slot-scope="{row}">
              <bind-wechat 
              :openid="row.openid"
              :id="row.id"
              type="users"
               />
            </template>
            <template slot-scope="{row}" slot="user_studentSearch">
              <SearchStudent :nowValue.sync="row.user_student" />
            </template>
            <template slot-scope="{row,type,size}" slot="menu">
              <el-button @click="msgDialog(row)" icon="el-icon-chat-round" :size="size" :type="type">发送消息</el-button>
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
import BindWechat from '@/components/Form/BindWechat'

export default {
  name: 'userIndex',
  mixins: [table, tree, proxy],
  components: {
    Avue,BindWechat
  },
  props: {
    isController: {
      type: Boolean,
      default: () => {
        return true
      }
    },
    editBtn: {
      type: Boolean,
      default: () => {
        return false
      }
    },
    addBtn: {
      type: Boolean,
      default: () => {
        return true
      }
    },
    viewBtn: {
      type: Boolean,
      default: () => {
        return true
      }
    },
    delBtn: {
      type: Boolean,
      default: () => {
        return false
      }
    },
    menuBtn: {
      type: Boolean,
      default: () => {
        return true
      }
    },
    showTree: {
      type: Boolean,
      default: () => {
        return false
      }
    },
    treeModuleProp: {
      type: String,
      default: () => {
        return '/api/dept'
      }
    },
    moduleProp: {
      type: String,
      default: () => {
        return '/api/user'
      }
    },
  },
  watch: {
    treeModuleProp(newUrl) {
      this.treeModule = newUrl
    },
    moduleProp(newUrl) {
      console.log(newUrl, 'moooo')
      this.module = newUrl
    }
  },
  mounted() {
    this.urlTreeProp.appendTop = true
    this.fetchUserData()
  },
  data() {
    return {
      treeModule: this.treeModuleProp,
      module: this.moduleProp
    }
  },
  methods: {
    fetchUserData() {
      this.getTree()
      this.getTable()
    },
    nodeClick(data) {
      this.urlProp.deptHas = data.id
      this.pagination.currentPage = 1
      this.getTable();
    },
    msgDialog(row) {
      this.proxy('msgBoxIndex', {proxyTitle: row.name + '消息管理', user: row }, {
        callFunc: (x) => {
          console.log(x, 'x1')
          this.callFunc(x)
        }
      }, false)
    },
    callFunc(x) {
      console.log(x, 'x2')
    }
  },
  computed: {
    treeOption() {
      return {
        defaultExpandAll: false,
        addBtn: false,
        // addBtnIcon: 'el-icon-refresh',
        props: {
          labelText: "标题",
          label: "name",
          value: "id",
          children: "children"
        }
      }
    },
    optionTable() {
      let confirmPassword = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'))
        } else if (value !== this.obj.password) {
          callback(new Error('两次密码不一致'))
        } else {
          callback()
        }
      }
      return {
        ...this.avueController,
        // 头部控制器
        page: this.pagination,
        align: 'left',
        menuAlign: 'center',
        dialogFullscreen: true,
        // menuType: 'menu',
        labelWidth: 120,
        editBtn: this.editBtn,
        addBtn: this.addBtn,
        viewBtn: this.viewBtn,
        delBtn: this.delBtn,
        menu: this.menuBtn,
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
            'prop': 'name',
            'label': '姓名',
            'span': 12,
            'display': true
          },
          {
            'prop': 'username',
            'label': '用户名',
            'span': 12,
            'display': true
          },
          {
            'prop': 'email',
            'label': '邮箱',
            'overHidden': true,
            'span': 12,
            'display': true
          },
          {
            'prop': 'phone',
            'label': '电话',
            'span': 12,
            'display': true
          },
          {
            'prop': 'password',
            'label': '密码',
            'span': 12,
            'viewDisplay': false,
            'hide': true,
            'type': 'password',
            rules: [
              { required: true,
                message: `请输入 ${this.$t('password')}`,
               },
              { min: 8, max: 32,
                message: `密码长度 8-32位`,
               }
            ]
          },
          {
            'prop': 'password_confirmation',
            'label': '确认密码',
            'span': 12,
            'viewDisplay': false,
            'hide': true,
            'type': 'password',
            rules: [
                { required: true,
                  message: `请输入 ${this.$t('confirmPassword')}`,
                 },
                { validator: confirmPassword },
                { min: 8, max: 32,
                  message: `密码长度 8-32位`,
                 }
            ]
          },
          {
            'prop': 'openid',
            'label': '绑定微信',
            'span': 12,
            'slot': true,
            'minWidth': '160px',
            'display': false,
          },
        ],
      }
    },
    updatePermission: function() {
      return hasPermission('user.update')
    },
    addPermission: function() {
      return hasPermission('user.store')
    },
    deletePermission: function() {
      return hasPermission('user.destroy')
    }
  }
}

</script>
<style rel="stylesheet/scss" lang="scss" scoped>
</style>
