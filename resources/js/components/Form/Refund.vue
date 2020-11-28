<template>
  <div style="height:100%;overflow:scroll">
    <el-row :gutter="20" class="m-10">
      <el-col :lg="12">
        <el-card class="card-top-color">
          <!-- <div v-for="(item,index) in suggestion.details" >
            <el-tag class="m-10 display-b h-a">
              <div>
                <span>{{item.title}}:</span>
                <p>均摊支付金额为<b class="c-red m-1"><avue-count-up :end="item.pay_amount" /></b>元</p>
                <p>总课次数量为<b class="c-red m-1"><avue-count-up :end="item.all_count" /></b>次</p>
                <p>未开课课次为<b class="c-red m-1"><avue-count-up :end="item.notuse_count" /></b>次</p>
                <p>课程待缴费用为<b class="c-red m-1"><avue-count-up :end="item.no_paid" /></b>元</p>
                <p>建议退费额为<b class="c-red m-1"><avue-count-up :end="item.refund_suggestion" /></b>元</p>
              </div>
            </el-tag>
          </div>   -->
          <el-tag class="m-10 display-b">订单缴费金额为<b class="c-red m-1"><avue-count-up :end="suggestion.ori_amount" /></b>元</el-tag>
          <el-tag class="m-10 display-b">剩余课程所需费用为<b class="c-red m-1"><avue-count-up :end="suggestion.still_amount" /></b>元</el-tag>
          <el-tag class="m-10 display-b">已经消费金额为<b class="c-red m-1"><avue-count-up :end="suggestion.already_amount" /></b>元</el-tag>
          <el-tag class="m-10 display-b">订单待支付金额为<b class="c-red m-1"><avue-count-up :end="suggestion.wait_pay" /></b>元</el-tag>
          <el-tag class="m-10 display-b">建议退费金额为<b class="c-red m-1"><avue-count-up :end="suggestion.refund_real" /></b>元</el-tag>
        </el-card>
      </el-col>
      <el-col :lg="12">
        <el-card class="card-top-color">
          <el-form label-position="right" label-width="80px" :model="discountInfo">
            <el-form-item label="退款金额">
              <el-input :disabled="checker" v-model.number="discountInfo.amount" :placeholder="'建议输入: '+suggestion.refund_real"></el-input>
            </el-form-item>
            <el-form-item label="退款原因">
              <el-input :disabled="checker" v-model="discountInfo.reason"></el-input>
            </el-form-item>
            <el-form-item label="退款备注">
              <el-input :disabled="checker" v-model="discountInfo.remark"></el-input>
            </el-form-item>
            <el-form-item v-if="checker" label="审核备注">
              <el-input v-model="discountInfo.check_remark"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" :disabled="discountInfo.state == 1 || suggestion.refund_real < 0" @click="submit">提交</el-button>
            </el-form-item>
          </el-form>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import http from '@/libs/http'
export default {
    props: {
      // 退课课程列表
      dropList: {
        type: Array|Object,
        default:() => {
          return []
        }
      },
      // 退费原始信息 和 dropList 理论上只会有一个有值
      refundInfo: {
        type: Array|Object,
        default:() => {
          return []
        }
      }
    },   
    components: {},
    data () {
        return {
          suggestion: {},
          discountInfo: {
            reason: '',
            amount:'',
            remark: '',
            check_remark: '',
          },
          checker: false,
        }
    },
    methods: {
      init() {
        var data = {}
        data.reg_ids = _.map(this.dropList, 'id')
        http.post('/api/order/refundCalc',data).then((res) => {
          this.suggestion = res
          if (this.suggestion.refund_real < 0) {
            this.$notify({
              message: '请前往缴费列表里对本订单至少补缴'+ (this.suggestion.refund_real * -1)+'元再来进行退课操作！',
              type: 'warning'
            })
            return
          }
        })
      },
      submit() {
        this.$confirm('确定提交?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          if (this.checker) {
            var data = {}
            data.amount = this.discountInfo.amount
            data.check_remark = this.discountInfo.check_remark
            http.post('/api/refund/check/'+this.discountInfo.id,data).then((res) => {
              if (res.status == 201) {
                // this.dropList = []
                this.$emit('closeDrawer')
                this.$notify({
                  message: '已提交退费信息！',
                  type: 'success',
                  duration: 10000
                })
                return false
              }
            })
          } else {
            var data = this.discountInfo
            data.reg_ids = _.map(this.dropList, 'id')
            http.post('/api/order/refund',data).then((res) => {
              if (res.status == 201) {
                // this.dropList = []
                this.$emit('closeDrawer')
                this.$notify({
                  message: '已提交退费信息！',
                  type: 'success',
                  duration: 10000
                })
                return false
              }
            })
          }
        }).catch((e) => {
          this.$message({
            type: 'info',
            message: '已取消'
          });          
        });
      }
    },
    computed: {
    },
    created() {
    },
    mounted () {
      if (!_.size(this.refundInfo) && _.size(this.dropList)) {
        this.init()
      } else {
        this.checker = true
        this.suggestion = this.refundInfo.ext.refundData
        this.discountInfo = this.refundInfo
      }
    },
    watch: {
      dropList: {
        handler() {
          this.init()
        },
        deep:true
      },
      discountInfo: {
        handler() {
          if (this.discountInfo.amount > this.suggestion.discount_all) {
            this.$notify({
              message: '请注意，输入金额已大于建议金额！',
              type: 'warning',
              duration: 4000
            })
          }
        },
        deep:true
      }
    }
};
</script>
<style lang="scss" rel="stylesheet/scss" scoped>

</style>
