import axios, { AxiosRequestConfig } from 'axios';
import { convertToFormData, getBearer } from '@/lib/utils';

axios.defaults.responseType = 'json';
axios.defaults.transformRequest = [(data: object | FormData) => convertToFormData(data)];
axios.interceptors.request.use(function(config) {
    if ((config.baseURL || '' + config.url)?.startsWith('/api')) {
        config.headers['Authorization'] = getBearer();
    }
    return config;
});
axios.interceptors.response.use(undefined, function(error) {
    if (error.response.status === 403) return window.location.href = '/login';
    return error;
});

axios.put = (url: string, data?: object, config?: AxiosRequestConfig) => {
    return axios.post(url, { ...data, _method: 'PUT' }, config);
};

axios.patch = (url: string, data?: object, config?: AxiosRequestConfig) => {
    return axios.post(url, { ...data, _method: 'PATCH' }, config);
};

axios.delete = (url: string, config?: AxiosRequestConfig) => {
    return axios.post(url, { ...config?.data, _method: 'DELETE' }, config);
};
