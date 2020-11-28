<template>
  <div style="margin-top: 15px;">
    <avue-search v-model="objsearch" :option="optionSearch" @change="handleSearch">
      <template slot="scale" slot-scope="scope">
        <!--         <el-autocomplete
          v-model="objsearch.scale"
          :fetch-suggestions="scaleCall"
          placeholder="请输入等级"
        /> -->
        <el-input-number
          v-model="objsearch.scale"
          placeholder="请输入等级"
        />
      </template>
    </avue-search>
    <el-divider />
    <el-card>
      <el-form ref="form" :model="form" label-width="120px">
        <el-form-item label="目标课程">
          <el-select v-model="form.courseid" clearable style="width: 100%" @change="fetchDataDetail">
            <el-option v-for="item in data" :key="item.id" :label="`${item.title}，限制人数：${item.limit_lis_num}`" :value="item.id" />
          </el-select>
        </el-form-item>
        <el-form-item v-if="type==='detail'" label="目标课课次">
          <el-select v-model="form.detailid" clearable style="width: 100%">
            <el-option v-for="item in dataDetail" :key="item.id" :label="`第${item.num}次课，已有：${item.should_man}人，时间：${item.start_at}`" :value="item.id" />
          </el-select>
        </el-form-item>
        <el-form-item label="备注">
          <el-input v-model="form.remark" type="textarea" />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="$emit('sync',form)">完成</el-button>
          <el-button type="ghost" class="f-r" @click="fetchData">搜索</el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
</template>
<script>
import { index } from '@/api/base'
import { parseFilter, pageFormat } from '@/libs/util'
import { isSuper,isMultCampusAdmin } from '@/libs/permission'
import { mapGetters } from 'vuex'
export default {
  name: 'ChangeForm',
  props: {
    course: {
      type: Object,
      default: () => {
        return {}
      }
    },
    origin: {
      type: Object,
      default: () => {
        return {}
      }
    },
    type: {
      type: String,
      default: () => {
        return 'detail'
        // reg / detail
      }
    }
  },
  data() {
    return {
      // objsearch: this.course,
      // 这里必须设置好格式 否则报错
      objsearch: {
        scale: null,
        plan_id: null,
        classtype_id: null,
        QueryGrade: [],
        subject_id: null
      },
      form: {},
      data: [],
      dataDetail: [],
      pagination: {
        currentPage: 1,
        pageSize: 10
      }
    }
  },
  computed: {
    ...mapGetters([
      'campusList'
    ]), 
    optionSearch() {
      const option = {
        card: true,
        column: [
          {
            label: '季度',
            prop: 'plan_id',
            multiple: false,
            value: 1,
            dicUrl: `/api/plan/option`,
            props: {
              label: 'title',
              value: 'id'
            }
          },
          {
            label: '班型',
            multiple: false,
            prop: 'classtype_id',
            dicUrl: `/api/class_type/option`,
            props: {
              label: 'title',
              value: 'id'
            }
          }, {
            label: '年级',
            prop: 'QueryGrade',
            multiple: true,
            dicUrl: `/api/grade/option`,
            props: {
              label: 'title',
              value: 'id'
            }
          }, {
            label: '科目',
            multiple: false,
            prop: 'subject_id',
            dicUrl: `/api/subject/option`,
            props: {
              label: 'title',
              value: 'id'
            }
          },
          {
            label: '等级',
            prop: 'scale',
            slot: true
          }
        ]
      }
      if (isMultCampusAdmin || isSuper) {
        option.column.unshift(
          {
            label: '校区',
            prop: 'campus_id',
            multiple: false,
            value: 1,
            dicData: this.campusList,
            props: {
              label: 'title',
              value: 'id'
            }
          }
        )
      }
      return option
    }
  },
  watch: {
    origin: {
      handler(value) {
        this.initQuery()
      },
      deep: true
    }
  },
  mounted() {
    this.initQuery()
  },
  created() {
  },
  methods: {
    initQuery() {
      // 初始化查询
      this.objsearch = {
        campus_id: this.course.campus_id,
        scale: this.course.scale,
        plan_id: this.course.plan_id,
        classtype_id: this.course.classtype_id,
        QueryGrade: this.course.grade_id,
        subject_id: this.course.subject_id
      },
      // 还要加入排除的ID
      this.objsearch.id = { operation: 'notin', value: [this.course.id] }
      this.fetchData()
    },
    scaleCall(queryString, callback) {
      var results = [
        { 'value': '0' },
        { 'value': '1' },
        { 'value': '2' },
        { 'value': '3' },
        { 'value': '4' },
        { 'value': '5' }
      ]
      callback(results)
    },
    handleSearch(effect) {
      // this.objsearch
      // dont do anything
    },
    fetchData() {
      // console.log(this.objsearch)
      const query = { withCount: 'reg', page: this.pagination.currentPage, pageSize: this.pagination.pageSize, filter: parseFilter(this.objsearch) }
      const { data, meta } = index('/api/course', query).then(res => {
        this.data = res.data
        pageFormat(res.meta, this)
      })
      // this.$notify({
      //   title: '警告',
      //   message: '请勿超出支付！',
      //   type: 'warning'
      // })
    },
    fetchDataDetail(id) {
      if (this.type === 'detail' && id) {
        console.log(this.origin)
        const query = { filter: { course_id: id, state: 0, num: { operation: '>=', value: this.origin.num }}}
        const { data, meta } = index('/api/course_detail/option', query).then(res => {
          this.dataDetail = res.data
        })
      }
    }
  }
}
</script>
