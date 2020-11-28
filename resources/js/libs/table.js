import routers from '../router/routers'
import store from '../store'

export function parseFilter(argumentX, stringify = false, dontSearch = [], clone = true) {
  const argument = clone ? _.clone(argumentX) : argumentX
  // console.log(argument,'xxxx1')
  // 转为拷贝 避免错误
  for (var i in argument) {
    // console.log(dontSearch.findIndex(e=>e===i),dontSearch,i,'dt')
    // && dontSearch.findIndex(i) > -1
    if (argument[i] && dontSearch.findIndex(e => e === i)) {
      // console.log(argument[i],'xxxx')
      if ((_.isObjectLike(argument[i]) && !_.size(argument[i])) || argument === undefined) {
        delete argument[i]
        break
      }
      if (argument[i] === 'null') {
        argument[i] = { isNull: true }
        break
      }
      for (var j in argument[i]) {
        if (argument[i][j]) {
          if (['notin', 'in', 'jsoncontains'].indexOf(j) > -1) {
            argument[i] = { operation: j, value: argument[i][j].replace(new RegExp('，', 'g'), ',').split(',') }
          } else if (j === 'json') {
            for (var json in argument[i][j]) {
              // 目前只支持一级
              if (argument[i][j][json]) {
                argument[i + '->' + json] = argument[i][j][json]
              }
            }
            delete argument[i]
          } else if (j === 'like') {
            argument[i] = { operation: j, value: argument[i][j] }
          }
        } else {
          delete argument[i][j]
        }
      }
    } else {
      delete argument[i]
    }
  }
  // console.log(argument)
  return stringify ? JSON.stringify(argument) : argument
}
export function parseFilterExtend(argument) {
  const conditions = {}
  // symbol: "="
  // text: "amount"
  // value: 0
  argument.forEach(e => {
    let operation = e.symbol
    let value = e.value
    switch (operation) {
      case '=':
        value = typeof value !== 'string' ? "'" + value.join(',') + "'" : value
        break
      case '∈':
        operation = 'in'
        break
      case '≠':
        operation = '!='
        break
      case '≥':
        operation = '>='
        break
      case '≤':
        operation = '<='
        break
    }
    // Object.assign(conditions, {[e.text]:{ operation: operation, value: e.value }})
    conditions[e.text] = { operation: operation, value: value }
  })
  return conditions
}

export function pageFormat(meta, th) {
  // console.log(meta)
  if (meta) {
    th.pagination = {
      currentPage: meta.current_page,
      pageSize: meta.per_page,
      total: meta.total,
      from: meta.from,
      lastPage: meta.last_page,
      to: meta.to
    }
  }
}

export function dateChange(date, option = 'created_at', th) {
  const keys = ['from', 'to']
  var dateArray = date.split(',')
  if (dateArray.length > 1) {
    dateArray[1] = dateArray[1] + ' 23:59:59'
    // 确保日期正常
  }
  var dateObject = _.zipObject(keys, dateArray)
  th.queryParams[option] = dateObject
}
export function importUnpkg(url) {
  const oScript = document.createElement('script')
  oScript.type = 'text/javascript'
  oScript.src = url
  document.body.appendChild(oScript)
}

export function findObject(argument, id, filed = 'id') {
  return argument.find((e) => { return e[filed] === id })
}

export function selectIdTrans(array, ignoreId = '') {
  return array.filter(e => e.id !== ignoreId).map(e => { e.id = e.id.toString(); return e })
}
export function onlyAmount(amount) {
  return amount.replace(/[^\d.]/g, '')
}
export function courseStateType(state) {
  return state === 10 ? 'success':(state === 1 ? 'warning' : (state < 0 ? 'danger' : 'primary'))
}

export function teacherName(teacher) {
  return teacher ? (teacher.displayname || teacher.realname) + `(${teacher.name})` : '暂无信息'
}

export const userInfo = (key = '') => {
  if (key) {
    return store.getters.admin[key] || ''
  }
  return store.getters.admin || []
}

export function checkQuery(e, keyword) {
  if (e.length > 0) {
    if (keyword && e.find(e => e.label === keyword)) {
      return false
    }
  }
  return true
}
export function getLabel(arg,value) {
  const r1 = arg.find(e=>e.value === value)
  
  return r1?r1.label:''
}
export const openWindow = (url, title, w, h) => {
    // Fixes dual-screen position                            Most browsers       Firefox
    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height

    const left = ((width / 2) - (w / 2)) + dualScreenLeft
    const top = ((height / 2) - (h / 2)) + dualScreenTop
    const newWindow = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left)

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus()
    }
}
