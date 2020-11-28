<template>
  <div id="login">
    <iframe src="/loginbg" frameborder="0" style="height: 100%;width: 100%;"></iframe>
    <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="100px" class="login">
      <h2>{{$t('login.title')}}</h2>
      <el-form-item :label="$t('username')" prop="username">
        <el-input placeholder="邮箱或用户名" v-model="ruleForm.username" auto-complete="off"></el-input>
      </el-form-item>
      <el-form-item :label="$t('password')" prop="password">
        <el-input type="password" v-model="ruleForm.password" auto-complete="off"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button class="loginBtn" type="primary" plain @click="submitForm('ruleForm')">{{$t('login.submit')}}</el-button>
        <el-button class="loginResetBtn" plain @click="resetForm('ruleForm')">{{$t('reset')}}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
  import { mapActions } from 'vuex'
  import { removeCache } from '@/libs/storage'

  export default {
    data() {
      return {
        ruleForm: {
          username: '',
          password: ''
        },
        rules: {
          username: [
            { required: true, trigger: 'blur' }
          ],
          password: [
            { required: true, trigger: 'blur' }
          ]
        },
      };
    },
    mounted() {
      removeCache('e401')
    },
    created() {

    },
    computed: {
    },
    methods: {
      ...mapActions([
        'loginHandle'
      ]),
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.loginHandle({
              ...this.ruleForm,
              provider: this.$provider
            }).then(result => {
              this.$router.push({
                name: 'adminMain'
              })
            })
          }
        });
      },
      resetForm(formName) {
        this.$refs[formName].resetFields();
      }
    }
  }
</script>
<style lang="scss">
  h2 {
    text-align: center;
    color: #D3D7F7;
  }
  #login {
    height:100%;
    background-image: url('/assets/login/img/bg.png');
    background-position: initial initial;
    background-repeat: initial initial;
  }
  .login 
  {
    box-shadow: -15px 15px 15px rgba(6, 17, 47, 0.7);
    opacity: 1;
    top: 20px;
    -webkit-transition-timing-function: cubic-bezier(0.68, -0.25, 0.265, 0.85);
    -webkit-transition-property: -webkit-transform,opacity,box-shadow,top,left;
            transition-property: transform,opacity,box-shadow,top,left;
    -webkit-transition-duration: .5s;
            transition-duration: .5s;
    -webkit-transform-origin: 161px 100%;
        -ms-transform-origin: 161px 100%;
            transform-origin: 161px 100%;
    -webkit-transform: rotateX(0deg);
            transform: rotateX(0deg);
    position: relative;
    width: 400px;
    /*border-top: 2px solid #D8312A;*/
    height: 300px;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    top: 0;
    bottom: 0;
    padding: 40px;
    background: #35394a;
    /* Old browsers */
    /* FF3.6+ */
    background: -webkit-gradient(linear, left bottom, right top, color-stop(0%, #35394a), color-stop(100%, rgb(0, 0, 0)));
    /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(230deg, rgba(53, 57, 74, 0) 0%, rgb(0, 0, 0) 100%);
    /* Chrome10+,Safari5.1+ */
    /* Opera 11.10+ */
    /* IE10+ */
    background: linear-gradient(230deg, rgba(53, 57, 74, 0) 0%, rgb(0, 0, 0) 100%);
    /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='rgba(53, 57, 74, 0)', endColorstr='rgb(0, 0, 0)',GradientType=1 );
    /* IE6-9 fallback on horizontal gradient */
    .login_title {
      color: #D3D7F7;
      height: 60px;
      font-size: 23px;
      text-align: center;
    }
    .el-form-item__label{
      color: #e5e6e6 !important;
    }
    .el-input__inner {
      background: rgba(57, 61, 82, 0);
      left: 0;
      color: #61BFFF !important;
      border-top: 2px solid rgba(57, 61, 82, 0);
      border-bottom: 2px solid rgba(57, 61, 82, 0);
      border-right: none;
      border-left: none;
      outline: none;
      font-family: 'Gudea', sans-serif;
      box-shadow: none;
      ::-webkit-input-placeholder { /* WebKit browsers */
        color: #afb1be;
      }
      ::-moz-placeholder { /* Mozilla Firefox 19+ */
        color: #afb1be;
      }
      :-ms-input-placeholder { /* Internet Explorer 10+ */
        color: #afb1be;
      }
    }
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-transition-delay: 99999s;
        -webkit-transition: color 99999s ease-out, background-color 99999s ease-out;
    }
    .loginBtn{
      border-radius: 50px;
      background: transparent;
      padding: 10px 30px;
      border: 2px solid #4FA1D9;
      color: #4FA1D9;
      text-transform: uppercase;
      -webkit-transition-property: background,color;
      transition-property: background,color;
      -webkit-transition-duration: .2s;
      transition-duration: .2s;
    }
    .loginResetBtn{
      float: right;
      border-radius: 50px;
      background: transparent;
      padding: 10px 20px;
      border: 2px solid #d9554f;
      color: #e5e6e6;
    }
  }
</style>