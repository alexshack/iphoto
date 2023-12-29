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
    import { getPositions, getStatuses, update } from '@/db/employee.js';
    import { getModalID, prepareData, prepareFormData } from '@/helpers/form.js';
    import VueDatePicker from '@vuepic/vue-datepicker';

    export default{
        name: 'EditEmployee',
        components: {
            Modal,
            VueDatePicker,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('employee', this.entity.id);
                }
                return modalID;
            }
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
                initializing: true,
                loading: false,
                positions: [],
                statuses: [],
                users: [],
            };
        },
        props: {
            delta: {
                type: Number,
                default: 1,
            },
            entity: {
                type: Object,
                required: true,
            },
        },
        methods: {
            async submit() {
                this.errors = [];
                this.loading = true;
                const formData = prepareFormData(this.formData);
                const response = await update(formData);
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
                            msg: 'Сотрудник обновлен',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted');
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
            initForm() {
                if (typeof this.entity != 'undefined' && this.entity) {
                    const entity = prepareData(this.entity, {
                        positions: this.positions,
                        statuses: this.statuses,
                        users: this.users,
                    });
                    for (let p in entity) {
                        this.formData[p] = entity[p];
                    }
                }
            },
        },
        async mounted() {
            await this.getAvailableUsers();
            await this.getPositions();
            await this.getStatuses();
            this.initForm();
        },
        updated() {
            if (typeof this.entity === 'undefined' || typeof this.entity.id === 'undefined') {
                this.initForm();
            }
        },
    }
</script>
