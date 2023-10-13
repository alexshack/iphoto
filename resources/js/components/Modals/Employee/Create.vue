<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Добавить сотрудника</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Сотрудник:</label>
                            <v-select v-model="formData.user_id" :options="users"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Статус:</label>
                            <v-select v-model="formData.status_id" :options="statuses" label="name"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Должность на смене:</label>
                            <v-select v-model="formData.position_id" :options="positions" label="name"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Время прихода:</label>
                            <VueDatePicker v-model="formData.start_time" time-picker locale="ru">
                            <template #input-icon>
                                <div class="picker-icon">
                                    <span class="feather feather-clock"></span>
                                </div>
                            </template>
                            </VueDatePicker>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Время ухода:</label>
                            <VueDatePicker v-model="formData.end_time" time-picker locale="ru">
                            <template #input-icon>
                                <div class="picker-icon">
                                    <span class="feather feather-clock"></span>
                                </div>
                            </template>
                            </VueDatePicker>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                    <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                    <span class="font-weight-semibold">Невозможно добавить сотрудника:</span>
                    <div v-for="err in errors">{{ err }}</div>
                </div>
            </template>
            <template v-slot:footer>
                <button @click="submit" v-loading="loading"  class="btn btn-success">Сохранить</button>
            </template>
        </Modal>
    </div>
</template>

<script>
    import Modal from '@/components/Modals/Modal.vue';
    import { getByCity } from '@/db/users.js';
    import { getPositions, getStatuses, store } from '@/db/employee.js';
    import {prepareFormData} from '@/helpers/form.js';
    import VueDatePicker from '@vuepic/vue-datepicker';

    export default{
        name: 'Create',
        components: {
            Modal,
            VueDatePicker,
        },
        data: () => {
            return {
                errors: [],
                formData: {
                    end_time: null,
                    position_id: null,
                    status_id: null,
                    start_time: null,
                    user_id: null,
                },
                loading: false,
                modalID: 'createEmployee',
                positions: [],
                statuses: [],
                users: [],
            };
        },
        methods: {
            async submit() {
                this.errors = [];
                this.loading = true;
                const formData = prepareFormData(this.formData);
                const response = await store(formData);
                this.loading = false;
                if (response.errors.length > 0) {
                    this.errors = response.errors;
                } else {
                    for (let p in this.formData) {
                        this.formData[p] = null;
                    }
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Сотрудник добавлен',
                            type: 'success',
                        }
                    }));
                    window.dispatchEvent(new Event('workDataEmployeeUpdate'));
                }
            },
            async getAvailableUsers() {
                let users = await getByCity();
                this.users = users.map(user => {
                    return {
                        id: user.id,
                        label: this.getUserName(user.personal_data),
                    };
                });
            },
            async getPositions() {
                this.positions = await getPositions();
            },
            async getStatuses() {
                this.statuses = await getStatuses();
            },
            getUserName(personalData) {
                return `${personalData.last_name} ${personalData.first_name} ${personalData.middle_name}`;
            },
        },
        mounted() {
            this.getAvailableUsers();
            this.getPositions();
            this.getStatuses();
        }
    }
</script>
