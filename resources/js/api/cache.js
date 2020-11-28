import http from '@/libs/http'
import { setCache, getCache, removeCache } from '@/libs/storage'
var time = []
export const query = async(url, params) => {
  const timeKey = url + JSON.stringify(params)
  const res = await getCache(timeKey)
  time.hasOwnProperty(timeKey) ? time[timeKey]++ : time[timeKey] = 0
  // 无论如何 都删除
  sleep(10000, removeCache, timeKey)
  // 10s后自动删除
  if (res) {
    return res
  } else {
    // console.log(timeKey,time[timeKey])
    // 内存泄漏 同请求 多次点击 数据被移除后 time[timeKey] 应设为空
    // 目前最大同次请求为4 减小数字能减少循环次数
    if (time[timeKey]) {
      time[timeKey] > 3 || delete time[timeKey]
      return await sleep(300, query, url, params)
    } else {
      const data = await http({
        url: url,
        method: 'get',
        params
      })
      // console.log(timeKey, data)
      setCache(timeKey, data)
      return data
    }
  }
}

function sleep(ms, fn, ...par) {
  return new Promise((resolve) => {
    setTimeout(() => resolve(fn(...par)), ms)
  })
}
