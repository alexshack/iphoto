<template>
    <div>
        <!--Page header-->
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <h4 class="page-title">{{ title }}  <a href="#" class="font-weight-normal text-muted ml-2">Смены</a></h4>
            </div>
        </div>
        <!--End Page header-->

        <div class="row">
            <div class="col-xl-3 col-md-12 col-lg-12">
                <WorkShiftAgenda
                 :access="access"
                 :errors="errors" />
            </div>
            <div class="col-xl-9 col-md-12 col-lg-12">
                <WorkShiftTabs :workShift="workShift"/>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { store } from '@/store/workshift.js';
</script>

<script>
    import {ping} from '@/db/ping.js';
    import WorkShiftAgenda from '@/components/WorkShiftAgenda.vue';
    import WorkShiftTabs from '@/components/WorkShiftTabs.vue';
    export default{
        name: 'WorkShift',
        components: {
            WorkShiftAgenda,
            WorkShiftTabs,
        },
        data: () => {
            return {
                access: {},
                errors: [],
                title: '',
                workshift: {},
            };
        },
        methods: {
            pingServer() {
                ping();
            },
            setupData() {
                if (typeof window.workshiftData != 'undefined') {
                    this.workshift = window.workshiftData;
                }

                if (typeof window.agenda != 'undefined') {
                    this.errors = window.agenda.errors;
                    this.access = window.agenda.access;
                    store.updateAgenda(window.agenda.agenda);
                }

                if (typeof window.workshiftTitle != 'undefined') {
                    this.title = window.workshiftTitle;
                }

                document.addEventListener('workshiftUpdate', this.updateData)
                document.addEventListener('ping', () => this.pingServer());
            },
            updateData(data = {}) {
                axios({
                    method: 'PUT',
                    url: window.workshiftUrls.update,
                    data,
                }).then((response) => {
                    if (typeof response.data.access != 'undefined') {
                        this.access = response.data.access;
                    }

                    if (typeof response.data.agenda != 'undefined') {
                        this.agenda = response.data.agenda;
                    }

                    if (typeof response.data.errors != 'undefined') {
                        this.errors = response.data.errors;
                    }
                });
            }
        },
        mounted() {
            this.setupData();
        }
    }
</script>
