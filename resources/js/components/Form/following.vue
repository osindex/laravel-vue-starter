<template>
  <div class="m-5">
    <el-row>
      <el-col :lg="12">
        <el-form label-width="150px">
            <el-form-item label="意向等级:">
                <div class="m-10">
                    <el-rate
                      v-model="form.intention"
                      :texts="texts"
                      :max="3"
                      show-text>
                    </el-rate>
                </div>
            </el-form-item>
            <el-form-item label="消费能力:">
                <div class="m-10">
                    <el-rate
                      v-model="form.consume"
                      :texts="texts"
                      :max="3"
                      show-text>
                    </el-rate>
                </div>
            </el-form-item>
            <el-form-item label="咨询学科:">
                <el-select v-model="form.subject" multiple placeholder="请选择">
                    <el-option
                      v-for="item in subjectList"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="跟进备注:">
                <el-input
                v-model="form.remark"
                type="textarea"
                placeholder="请输入 跟进备注"
                :rows="3"/>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="handleSubmit">保存</el-button>
            </el-form-item>
        </el-form>
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
                <h4>{{item.remark}}</h4>
                <p>操作员：{{item.admin.name +'-'+ item.admin.displayname}}</p>
              </el-card>
            </el-timeline-item>
          </el-timeline>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { index,add,option,one } from '@/api/base'
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
        texts:["低","中","高"],
        form:{
          foreign_id: parseInt(this.oldValue),
          student_id:this.studentInfo.id,
          type: '跟进日志',
          remark: '',
          intention: 1,
          consume:1,
          subject: []
        },
        consultationList: [],
        reverse: true,
        changeLog: [],
        subjectList: [],
      }
    },
  computed: {
      // option () {
      //     return {
      //       labelWidth: 120,
      //       emptyBtn: false,
      //       menuPosition: 'left',//没有用？？
      //       // submitBtn: true,
      //       column: [{
      //         'span': 24,
      //         label: '本次跟进备注',
      //         prop: 'remark',
      //         type: 'textarea',
      //         minRows: 3,
      //       }]
      //     }
      //   },
    },
    created() {
      this.getConsultations()
    },
    mounted() {
      this.getChangeLog()
      this.getSubject()
      this.getStudentInfo()
    },
    watch: {
    },
    methods: {
      getSubject() {
        option('/api/subject').then((res) => {
          this.subjectList = res.data
        })
      },
      getChangeLog() {
        http.get(`/api/student_log/option?expand=admin,consultationChange&filter=${parseFilter({ student_id: this.studentInfo.id,type: '跟进日志' }, true)}`).then((res) => {
          this.changeLog = res.data
        })

      },
      getStudentInfo() {
          one('/api/student',this.studentInfo.id,'expand=studentFollowing,followCourse').then((res) => {
             console.log(res,'----')
              this.form.intention = res.data.student_following.intention
              this.form.consume = res.data.student_following.consume
              this.form.subject = _.map(res.data.follow_course,'id')
              console.log(res,'----',this.form.subject,res.data)
          })
      },
      handleSubmit(form,done){
        this.$confirm('提交后将无法修改，确认提交跟进日志？')
        .then(_ => {
            var data = this.form
            data.remark =  data.remark ?  data.remark : '无备注'
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
