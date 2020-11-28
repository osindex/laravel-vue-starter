import localforage from 'localforage'

export function setCache(key, value) {
  return localforage.setItem(key, value)
}
export function getCache(key) {
  return localforage.getItem(key)
}
export function removeCache(key) {
  return localforage.removeItem(key)
}
export function clearCache() {
  return localforage.clear()
}
