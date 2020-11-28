import Admin from '../views/admin/main/index'
import adminUser from '../views/admin/user/routes'
import proxy from './proxy'

import role from '../views/admin/role/routes'
import permission from '../views/admin/permission/routes'
import permissionGroup from '../views/admin/permission-group/routes'
import menu from '../views/admin/menu/routes'
import adminDashboard from '../views/admin/dashboard/routes'
import article from '../views/admin/content/article/routes'
import category from '../views/admin/content/category/routes'
import test from '../views/admin/test/routes'
import adminLogin from '../views/admin/login/routes'
import setting from '../views/admin/setting/routes'

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
      ...adminDashboard, ...adminUser, ...role, ...permission, ...permissionGroup, ...menu, ...setting, ...test, ...category, ...article
    ]
  },
  ...adminLogin,
]