import axios from 'axios';

import { createApp, ref } from 'vue';
import DestroyButton from '@/components/Form/DestroyButton.vue';
import loadingDirective from '@/directives/loading.js';
import {store} from '@/store/workshift.js';
import vSelect from 'vue-select';
import VueEasyLightBox from 'vue-easy-lightbox';
import WorkShift from '@/components/WorkShift.vue';
import emitter from '@/helpers/emitter.js';

import '@vuepic/vue-datepicker/dist/main.css';
import 'vue-select/dist/vue-select.css';
import 'vue-easy-lightbox/external-css/vue-easy-lightbox.css'
import './scss/workshift.scss';

const axiosInstance = axios;
axiosInstance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axiosInstance.interceptors.response.use((response) => {
    if (response.status === 401) {
        window.location.reload();
    }

    if (typeof response.data.agenda != 'undefined') {
        store.updateAgenda(response.data.agenda);
        if (typeof response.data.errors != 'undefined') {
            store.updateAgendaErrors(response.data.errors);
        }

        if (typeof response.data.access != 'undefined') {
            store.updateAgendaAccess(response.data.access);
        }
    }

    return response;
}, (err) => {});

axiosInstance.defaults.validateStatus = (status) => {
    return (status >= 200 && status < 300) || status === 422 || status === 401;
};

window.axios = axiosInstance;
window.emitter = emitter;

window.addEventListener('notify', (event) => {
    notif(event.detail);
});

document.addEventListener('DOMContentLoaded', () => {
    const app = createApp(WorkShift);
    app.use(VueEasyLightBox);
    app.directive('loading', loadingDirective);
    app.component('v-select', vSelect);
    app.component('DestroyButton', DestroyButton);
    app.mount('#workshift');
});
