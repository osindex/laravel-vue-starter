<template>
  <div>
      <el-button-group v-if="openid">
        <el-button size="mini" type="success" icon="icon adminicon weixin">已绑定</el-button>
        <el-tooltip effect="dark" content="重新绑定" placement="top-start">
          <el-button size="mini" plain @click="bindWxBtn" icon="icon adminicon weixin"></el-button>
        </el-tooltip>
      </el-button-group>
      <el-button size="mini" type="primary" icon="el-icon-arrow-right" v-else @click="bindWxBtn">绑定微信></i></el-button>
  </div>
</template>

<script>
import { index,add } from '@/api/base'
import { parseFilter } from '@/libs/util'
  export default {
    name: 'BindWechat',
    model: {
      prop: 'openid',
      event: 'change'
    },
    props: {
      openid: '',
      id: '',
      type: ''
    },
    data() {
      return {
        bindUrl: ''
      }
    },
    computed: {
    },
    created() {

    },
    mounted() {
    },
    watch: {
    },
    methods: {
      handleSubmit(form,done){
        this.$confirm('确认修改销售？')
        .then(_ => {
          add('/api/student_log',this.form).then((res) =>{
            if (res.status == 201) {
              this.$emit('drawerClose')
            }
          })
          done()
        })
        .catch(_ => {
          done()
        })
      },
      bindWxBtn() {

      },
      change(){
        this.$emit("change",this.nowValue)
      }
    }
  }
</script>
<style type="text/css">
  .consultationChangeLog {
    height: 100%;
    overflow: auto;
  }
</style>
