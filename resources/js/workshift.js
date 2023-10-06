import axios from 'axios';


import { createApp, ref } from 'vue';
import {store} from './store/workshift.js';
import WorkShift from './components/WorkShift.vue';
import loadingDirective from '@/directives/loading.js';
import '@vuepic/vue-datepicker/dist/main.css';

const axiosInstance = axios;
axiosInstance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axiosInstance.interceptors.response.use((response) => {
    if (response.status === 401) {
        window.location.reload();
    }

    if (typeof response.data.agenda != 'udefined') {
        store.updateAgenda(response.data.agenda);
    }

    return response;
}, (err) => {});
axiosInstance.defaults.validateStatus = (status) => {
    return (status >= 200 && status < 300) || status === 422 || status === 401;
};

window.axios = axiosInstance;

window.addEventListener('notify', (event) => {
    notif(event.detail);
});


document.addEventListener('DOMContentLoaded', () => {
    const app = createApp(WorkShift);
    app.directive('loading', loadingDirective);
    app.mount('#workshift');
});
