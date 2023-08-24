<template>
    <div  v-if="employeeID > 0">
        <Modal :modalID="modalID">
            <template v-slot:title>Редактировать сотрудника</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Сотрудник:</label>
                            <select v-model="formData.user_id" class="form-control custom-select select2-show-search "  data-placeholder="Выберите сотрудника" disabled>
                                <option label="Выберите сотрудника"></option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ getUserName(user.personal_data) }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Статус:</label>
                            <select v-model="formData.status_id" class="form-control custom-select select2"  data-placeholder="Выберите статус">
                                <option label="Выберите статус"></option>
                                <option v-for="status in statuses" :key="status.id" :value="status.id">
                                {{ status.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Должность на смене:</label>
                            <select name="" v-model="formData.position_id"  class="form-control custom-select select2" data-placeholder="Выберите должность">
                                <option label="Выберите должность"></option>
                                <option v-for="position in positions" :key="position.id" :value="position.id">
                                {{ position.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Время прихода:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="feather feather-clock"></span>
                                    </div>
                                </div><!-- input-group-prepend -->
                                <input v-model="formData.start_time" class="form-control ui-timepicker-input" id="tpStartTime" placeholder="Укажите время" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Время ухода:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="feather feather-clock"></span>
                                    </div>
                                </div><!-- input-group-prepend -->
                                <input v-model="formData.end_time" class="form-control ui-timepicker-input" id="tpEndTime" placeholder="Укажите время" type="text" autocomplete="off">
                            </div>
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
                <button @click="submit"  class="btn btn-success">Сохранить</button>
            </template>
        </Modal>
    </div>
</template>

<script>
    import Modal from '@/components/Modals/Modal.vue';
    import { getByCity } from '@/db/users.js';
    import { getPositions, getStatuses, updateEmployee, getEmployee } from '@/db/employee.js';

    export default{
        name: 'Edit',
        components: {
            Modal,
        },
        computed: {
            modalID() {
                return `editEmployee${this.employeeID}`;
            },
        },
        data: () => {
            return {
                errors: [],
                formData: {
                    id: null,
                    endTime: null,
                    position_id: null,
                    status_id: null,
                    start_time: null,
                    user_id: null,
                    workshift_id: null,
                },
                positions: [],
                statuses: [],
                users: [],
            };
        },
        props: {
            employeeID: {
                type: Number,
                required: true,
            },
        },
        methods: {
            async submit() {
                const response = await updateEmployee(this.formData);
                if (response.errors.length > 0) {
                    this.errors = response.errors;
                } else {
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
                this.users = await getByCity();
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
        },
        watch: {
            async employeeID(newValue) {
                let employeeData = await getEmployee(newValue);
                console.log(employeeData);
                for (let p in this.formData) {
                    if (typeof employeeData[p] != 'undefined') {
                        this.formData[p] = employeeData[p];
                    }
                }
                window.dispatchEvent(new Event(`showModal.${this.modalID}`));
            }
        }
    }
</script>
