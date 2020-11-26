import Vue from 'vue'
import VueI18n from 'vue-i18n'
import elementEnLocale from 'element-ui/lib/locale/lang/en' // element-ui lang
import elementZhLocale from 'element-ui/lib/locale/lang/zh-CN'// element-ui lang
import enLocale from './en'
import zhLocale from './zh_CN'
import avuezh from './avue/zh'
import avueen from './avue/en'

Vue.use(VueI18n)

const messages = {
  en: {
    ...avueen,
    ...enLocale,
    ...elementEnLocale
  },
  zh: {
    ...avuezh,
    ...zhLocale,
    ...elementZhLocale
  }
}


export default new VueI18n({
  locale: 'en',
  messages
})
