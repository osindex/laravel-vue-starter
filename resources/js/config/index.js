export default {
  admin: {
    loginRouteName: 'adminLogin',

    dashboardName: 'adminDashboard',

    dashboardFullPath: '/admin/dashboard',

    appName: {
      fullName: process.env.MIX_APP_NAME || 'admin dashboard',
      abbrName: process.env.MIX_APP_ABBR_NAME || 'admin'
    },

    locale: 'zh'
  },
  guardNames: [
    {
      label: 'admin',
      value: 'admin',
      default: true
    }
  ],
  stateList: [
    {
      label: '禁用',
      value: 0,
    },
    {
      label: '可用',
      value: 1,
    }
  ],
  showAuthorGitHubUrl: true,
}