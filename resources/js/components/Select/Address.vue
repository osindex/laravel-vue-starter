<template>
  <div style="display: flex">
    <div class="inline">
      <al-selector
        v-model="addArr"
        @change="change"
        :size="anyData('size','default')"
        :disabled="anyData('disabled',false)"
        data-type="name"
        searchable
        init-data
        level="2"
      />
    </div>
  </div>
</template>
<script>
export default {
  name: 'Address',
  model: {
    data: 'optionValue',
    event: 'update'
  },
  props: {
    nowValue: {
      type: Object,
      default: () => {
        return {
          province: '四川省',
          city: '成都市',
        }
      }
      // type: Array,
      // default: () => {
      //   return ['四川省', '成都市']
      // }
    },
    any: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {
      label: '',
      optionValue: this.nowValue,
      addArr: [this.nowValue.province, this.nowValue.city, this.nowValue.area]
    }
  },
  watch: {
    optionValue: {
      handler(newValue, oldValue) {
        this.$emit('update:nowValue', newValue)
      },
      immediate: true,
      deep: true
    },
    nowValue(newValue) {
      this.addArr = [newValue.province, newValue.city, newValue.area]
    },
    addArr(newValue) {
      this.optionValue.province = newValue[0] || ''
      this.optionValue.city = newValue[1] || ''
      this.optionValue.area = newValue[2] || ''
    }
  },
  mounted() {},
  methods: {
    anyData(key, defaultValue = null) {
      return this.any.hasOwnProperty(key) ? this.any[key] : defaultValue
    },
    change(e) {
      this.$emit('change', e)
    }
  }
}
</script>
<style lang="scss" scoped>
.inline {
  display: inline-block;
  margin-right: 1px;
}
</style>
