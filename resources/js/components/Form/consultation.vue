<template>
  <div class="m-5">
    <el-row>
      <el-col :lg="12">
        <avue-form :option="option" v-model="form" @submit="handleSubmit"></avue-form>
      </el-col>
      <el-col :lg="12">
        <div>
          <el-timeline :reverse="true">
            <el-timeline-item
              v-for="(item, index) in changeLog"
              :key="index"
              :timestamp="item.created_at"
              placement="top">
              <el-card>
                <h4>{{item.consultation_change.name +'-'+ item.consultation_change.displayname}}</h4>
                <p>操作员：{{item.admin.name +'-'+ item.admin.displayname}}</p>
                <p>修改备注：{{item.remark}}</p>
              </el-card>
            </el-timeline-item>
          </el-timeline>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { index,add } from '@/api/base'
import http from '@/libs/http'
import { parseFilter } from '@/libs/util'
  export default {
    name: 'ConsultationSelect',
    model: {
      prop: 'oldValue',
      event: 'change'
    },
    props: {
      'oldValue': '',
      'studentInfo':''
    },
    data() {
      return {
        form:{
          foreign_id: parseInt(this.oldValue),
          student_id:this.studentInfo.id,
          type: '切换销售',
          remark: '',
        },
        consultationList: [],
        reverse: true,
        changeLog: []
      }
    },
  computed: {
      option () {
          return {
            labelWidth: 120,
            emptyBtn: false,
            menuPosition: 'left',//没有用？？
            // submitBtn: true,
            column: [{
              'type': 'select',
              'label': '所属销售',
              'span': 24,
              'prop': 'foreign_id',
              'dicData': this.consultationList,
              'props': {
                label: 'name',
                value: 'id'
              },
              'required': true,
            },{
              'span': 24,
              label: '原因',
              prop: 'remark',
              type: 'textarea',
              minRows: 3,
            }]
          }
        },
    },
    created() {
      this.getConsultations()
    },
    mounted() {
      this.getChangeLog()
    },
    watch: {
    },
    methods: {
      getChangeLog() {
        http.get(`/api/student_log/option?expand=admin,consultationChange&filter=${parseFilter({ student_id: this.studentInfo.id,type: '切换销售' }, true)}`).then((res) => {
          this.changeLog = res.data
        })

      },
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
      change(){
        this.$emit("change",this.nowValue)
      },
      async getConsultations() {
        await index('/api/user/option', { filter: { campus_id: this.$store.getters.admin.campus_id,'roles.id': 6, 'addSelectOption': 1 }}).then(res => {
          this.consultationList = res.data
        })
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
