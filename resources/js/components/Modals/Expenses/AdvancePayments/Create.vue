<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Выдача авансов</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сотрудник</label>
                            <select v-model="formData.user_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите сотрудника">
                                <option label="Выберите сотрудника"></option>
                                <!-- Все менеджеры -->
                                <option v-for="employee in employees" :key="employee.id" :value="employee.id">
                                    {{ getUserName(employee.personal_data) }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Расчетный месяц</label>
                            <VueDatePicker v-model="formData.month" month-picker locale="ru"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сумма</label>
                            <input v-model="formData.amount" class="form-control" placeholder="Укажите сумму аванса" type="number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Примечания:</label>
                            <input v-model="formData.note" class="form-control" placeholder="Укажите примечания" type="text">
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <button @click="submit" v-loading="loading"  class="btn btn-success">Сохранить</button>
            </template>
        </Modal>
    </div>
</template>

<script>
    import {getByCity} from '@/db/users.js';
    import {getUserName} from '@/helpers/employee.js';
    import Modal from '@/components/Modals/Modal.vue';
    import {store} from '@/db/pays.js';
    import VueDatePicker from '@vuepic/vue-datepicker';

    export default{
        name: 'Create',
        components: {
            Modal,
            VueDatePicker,
        },
        data: () => {
            return {
                employees: [],
                loading: false,
                formData: {
                    month: null,
                    user_id: null,
                    amount: null,
                    note: null,
                },
                modalID: 'createAdvancePayment',
            };
        },
        methods: {
            getUserName,
            async setEmployees() {
                this.employees = await getByCity();
            },
            async setupData() {
                this.setEmployees();
            },
            async submit() {
                this.loading = true;
                this.errors = [];
                const response = await store(this.formData);
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
                            msg: 'Аванс добавлен',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            },
        },
        async mounted() {
            await this.setupData();
        },
    }
</script>
