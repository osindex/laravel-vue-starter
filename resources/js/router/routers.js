import Admin from '../views/admin/main/index'
import adminUser from '../views/admin/admin-user/routes'
import proxy from './proxy'

import role from '../views/admin/role/routes'
import permission from '../views/admin/permission/routes'
import permissionGroup from '../views/admin/permission-group/routes'
import menu from '../views/admin/menu/routes'
import adminDashboard from '../views/admin/dashboard/routes'
import msgBox from '../views/admin/proxy/msgBox/routes'
import slider_group from '../views/admin/content/slider_group/routes'
import slider from '../views/admin/content/slider_group/slider/routes'
import deptUser from '../views/admin/dept/user/routes'
import dept from '../views/admin/dept/index/routes'
import article from '../views/admin/content/article/routes'
import category from '../views/admin/content/category/routes'
import user from '../views/admin/user/routes'
import test from '../views/admin/test/routes'
import adminLogin from '../views/admin/login/routes'
import setting from '../views/admin/setting/routes'
// 虽然意义不大
import pageDesign from '../views/admin/page-design/routes'

export default [
  {
    name: 'adminMain',
    path: '/admin',
    redirect: '/admin/dashboard',
    meta: {
      provider: 'admin',
      title: 'home',
    },
    component: Admin,
    children: [
      proxy,
      ...adminDashboard, ...adminUser, ...role, ...permission, ...permissionGroup, ...menu, ...setting, ...pageDesign, ...test, ...user, ...category, ...article, ...dept, ...deptUser, ...slider_group, ...slider, ...msgBox
    ]
  },
  ...adminLogin,
]