<template>
  <div style="margin-top: 15px;">
    <div v-for="(item,index) in payment_list" class="m-10">
      <el-input v-model="item.amount" :placeholder="placeholderText" class="w-500" @input="(amount)=>onlyAmount(amount,item)" @blur="autoAdd">
        <el-select slot="prepend" v-model="item.pay_way_id" class="w-input" placeholder="支付方式">
          <el-option v-for="(pay_m, i) in pay_type_list" :key="i" :label="pay_m.title" :value="pay_m.id" />
        </el-select>
        <!-- <el-button slot="append" icon="el-icon-circle-plus-outline" @click="handleAdd"></el-button> -->
      </el-input>
    </div>
  </div>
</template>
<script>
import http from '@/libs/http'
import { onlyAmount } from '@/libs/util'
export default {
  name: 'PayType',
  model: {
    prop: 'nowValue',
    event: 'change'
  },
  props: {
    nowValue: {
      type: [Array, Object],
      default: () => {
        return []
      }
    },
    needpay: {
      type: [String, Number],
      default: () => {
        return 0
      }
    },
    onlyOne: {
      type: [Boolean],
      default: false
    }
  },
  data() {
    return {
      optionValue: this.nowValue,
      pay_type_list: [],
      payment_list: [
        {
          pay_way_id: null,
          amount: null
        }
      ],
      paid: 0
    }
  },
  computed: {
    placeholderText() {
      var remain = parseFloat(this.needpay) - parseFloat(this.paid)
      return '还剩' + remain.toFixed(2) + '待支付'
    }
  },
  watch: {
    nowValue(now) {
      this.optionValue = now
    }
    // payment_list: {
    //   handler() {
    //     this.paid = _.sumBy(this.payment_list, 'amount') || 0
    //     if (this.paid > this.needpay) {
    //       this.payment_list[_.size(this.payment_list) - 1]['amount'] = 0
    //       this.$notify({
    //         title: '警告',
    //         message: '请勿超出支付！',
    //         type: 'warning'
    //       })
    //       return
    //     }
    //     // this.autoAdd()
    //   },
    //   deep: true
    // }
  },
  created() {
    this.getPayTypes()
  },
  methods: {
    getPayTypes() {
      http.get('/api/pay_type/option').then((res) => {
        this.pay_type_list = res.data
      })
    },
    // 金额未满，自动加行
    autoAdd() {
      this.paid = _.sumBy(this.payment_list, e => e.amount * 1) || 0
      console.log('this.onlyOne', this.onlyOne, this.paid)
      if (!this.onlyOne && this.paid < this.needpay) {
        var add = true
        this.payment_list.forEach(function(q) {
          if (q.amount == '' || q.amount == null) {
            add = false
          }
        })
        if (add) {
          this.payment_list.push({
            pay_way_id: null,
            amount: null
          })
        }
      } else if (this.paid == this.needpay) {
        this.$notify({
          title: '提示',
          message: '支付金额已经等于订单金额，请点击提交订单',
          type: 'success'
        })
      }
    },
    handleAdd() {
      if (this.needpay > this.paid) {
        this.payment_list.push({
          pay_way_id: null,
          amount: null
        })
      } else {
        this.$notify({
          title: '警告',
          message: '请勿超出支付！',
          type: 'warning'
        })
      }
    },
    getPaymentInfo() {
      // 验证是否均选择了支付方式|只返回有金额的
      var that = this
      var no_pay_way = false
      this.payment_list.forEach(function(o) {
        // 有金额但是没有选择支付方式的就要报错
        if (o.amount > 0 && !o.pay_way_id) {
          that.$notify({
            title: '警告',
            message: '请选择支付方式！',
            type: 'warning'
          })
          no_pay_way = true
        }
      })
      if (no_pay_way) {
        return false
      } else {
        var data = _.takeWhile(this.payment_list, function(o) { return o.amount > 0 })
        return data
      }
    },
    onlyAmount(e, item) {
      // item.amount = onlyAmount(e)
    }
  }
}
</script>
