<template>
  <div>
    <!-- <el-radio-group v-model="labelPosition" size="small">
      <el-radio-button label="left">左对齐</el-radio-button>
      <el-radio-button label="right">右对齐</el-radio-button>
      <el-radio-button label="top">顶部对齐</el-radio-button>
    </el-radio-group> -->
    <div style="margin: 20px;" />
    <el-form ref="form" :label-position="labelPosition" label-width="80px" :model="form">
      <el-form-item :label="$t('siteName')">
        <el-input v-model="form.site_name" />
      </el-form-item>
      <el-form-item :label="$t('logo')">
        <el-upload
          accept="image/*"
          class="uploader"
          :action="$uploadUrl"
          :headers="headers"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :before-upload="beforeAvatarUpload"
        >
          <img v-if="form.logo" :src="form.logo" class="preview">
          <i v-else class="el-icon-plus avatar-uploader-icon" />
        </el-upload>

      </el-form-item>
      <el-form-item :label="$t('company')">
        <el-input v-model="form.company" />
      </el-form-item>
      <el-form-item :label="$t('icp')">
        <el-input v-model="form.icp" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="submitForm('form')">{{ $t('save') }}</el-button>
        <el-button @click="resetForm('form')">{{ $t('reset') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { index, add } from '@/api/base'
import { hasPermission } from '@/libs/permission'
import { getToken } from '@/libs/auth'
import { editSuccess } from '@/libs/tableDataHandle'
// 会转入基础包 不依赖avue
export default {
  name: 'Setting',
  components: {
  },
  data() {
    return {
      headers: null,
      labelPosition: 'right',
      form: {
        site_name: this.$config.admin.appName.fullName,
        logo: '',
        company: this.$config.admin.appName.abbrName,
        icp: ''
      }
    }
  },
  computed: {
    updatePermission: function() {
      return hasPermission('setting.update')
    },
    addPermission: function() {
      return hasPermission('setting.store')
    },
    deletePermission: function() {
      return hasPermission('setting.destroy')
    }
  },
  created() {
    this.fetch()
    getToken(this.$provider).then(token => {
      this.headers = { Authorization: `Bearer ${token.token}` }
    })
  },
  methods: {
    fetch() {
      index('/api/setting_get/base?context=base').then(res => {
        if (res.data) {
          this.form = res.data
        }
      })
    },
    handleAvatarSuccess(res, file) {
      this.form.logo = res.data.url
    },
    beforeAvatarUpload(file) {
      const isPic = file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/gif'
      const isLt2M = file.size / 1024 / 1024 < 2

      if (!isPic) {
        this.$message.error('上传图片只能是 JPG/PNG/GIF 格式!')
      }
      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 2MB!')
      }
      return isPic && isLt2M
    },
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          console.log(this.form)
          add('/api/setting_set?context=base', {base: this.form}).then(res => {
            editSuccess(this)
          })
        } else {
          console.log('error submit!!')
          return false
        }
      })
    },
    resetForm(formName) {
      this.$refs[formName].resetFields()
    }
  }
}
</script>

<style lang="scss">
.uploader {
  .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    &:hover {
      border-color: #409EFF;
    }
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 150px;
    height: 150px;
    line-height: 150px;
    text-align: center;
  }
  .preview {
    width: 150px;
    display: block;
  }
}
</style>
