import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { createApp, ref } from 'vue';
import WorkShift from './components/WorkShift.vue';

document.addEventListener('DOMContentLoaded', () => {
    createApp(WorkShift).mount('#workshift');
});
