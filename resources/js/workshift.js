import axios from 'axios';
window.axios = axios;


import { createApp, ref } from 'vue';
import {store} from './store/workshift.js';
import WorkShift from './components/WorkShift.vue';
import loadingDirective from '@/directives/loading.js';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.interceptors.response.use((response) => {
    if (typeof response.data.agenda != 'udefined') {
        store.updateAgenda(response.data.agenda);
    }
    return response;
}, (err) => {});

window.addEventListener('notify', (event) => {
    notif(event.detail);
});


document.addEventListener('DOMContentLoaded', () => {
    DataTable.use(DataTablesCore);
    const app = createApp(WorkShift);
    app.use(DataTable);
    app.directive('loading', loadingDirective);
    app.mount('#workshift');
});
