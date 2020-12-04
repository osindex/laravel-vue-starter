<template>
  <div>
      <el-button-group v-if="openid">
        <el-button size="mini" type="success" icon="icon adminicon weixin">已绑定</el-button>
        <el-tooltip effect="dark" content="重新绑定" placement="top-start">
          <el-button size="mini" plain @click="bindWxBtn" icon="icon adminicon weixin"></el-button>
        </el-tooltip>
      </el-button-group>
      <el-button size="mini" type="primary" icon="el-icon-arrow-right" v-else @click="bindWxBtn">绑定微信</el-button>
  </div>
</template>

<script>
import { index,add } from '@/api/base'
import { parseFilter, openWindow } from '@/libs/util'
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
        bindWindow: '',
        bindUrl: '',
        count: 0,
      }
    },
    computed: {
    },
    created() {
        window.addEventListener("message", this.getwindowMessage, true);
    },
    destroyed() {
      window.removeEventListener("message", this.getwindowMessage, true);
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
        const url = '/msg.html'
        // const url = 'http://www.baidu.com'
        const title = 'TestName'
        this.bindWindow = openWindow(url, title)
        // 
      },
      getwindowMessage(event) {
        if(event.source === this.bindWindow){
          const data = event.data
          ++this.count
          this.bindWindow.postMessage('主动告知');
          console.log(this.count, 'countLog')
          if (this.count > 3) {
            this.bindWindow.close()
            this.count = 0          
          }
        }
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
