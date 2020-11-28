import qs from 'qs'
import http from '@/libs/http'

export const index = (uri, params) => {
    return http.get(uri, {
        params
    })
}
export const tree = (uri, params) => {
    return http.get(uri+'/tree', {
        params
    })
}
export const add = (uri, data) => {
    if (data.hasOwnProperty('created_at')) {
        delete data.created_at
    }
    if (data.hasOwnProperty('updated_at')) {
        delete data.updated_at
    }
    return http.post(uri, data)
}

export const batch = (uri, data) => {
    return http.post(`${uri}/batch`, qs.stringify(data))
}

export const edit = (uri, id, data) => {
    if (data.hasOwnProperty('updated_at')) {
        delete data.updated_at
    }
    return http.patch(`${uri}/${id}`, qs.stringify(data))
}

export const del = (uri, id) => {
    return http.delete(`${uri}/${id}`)
}

export const option = (uri, params) => {
    return http.get(`${uri}/option`, {
        params
    })
}

export const one = (uri, id, params = '') => {
    return http.get(`${uri}/${id}?${params}`)
}
