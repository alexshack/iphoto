<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Выдача авансов</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сотрудник</label>
                            <v-select v-model="formData.user_id" :options="employees"/>
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
    import { getModalID, prepareData, prepareFormData } from '@/helpers/form.js';
    import {update} from '@/db/pays.js';
    import VueDatePicker from '@vuepic/vue-datepicker';

    export default{
        name: 'Create',
        components: {
            Modal,
            VueDatePicker,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('advancePayment', this.entity.id);
                }
                return modalID;
            }
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
            getUserName,
            async initForm() {
                if (typeof this.entity != 'undefined' && this.entity) {
                    const db = {
                        users: this.employees,
                    };
                    const entity = prepareData(this.entity, db);
                    for (let p in entity) {
                        this.formData[p] = entity[p];
                    }
                }
            },
            async setEmployees() {
                let employees = await getByCity();
                this.employees = employees.map(employee => {
                    return {
                        id: employee.id,
                        label: getUserName(employee.personal_data),
                    };
                });
            },
            async setupData() {
                this.setEmployees();
            },
            async submit() {
                this.loading = true;
                this.errors = [];
                const formData = prepareFormData(this.formData);
                const response = await update(formData);
                this.loading = false;
                if (response.errors.length > 0) {
                    this.errors = response.errors;
                } else {
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Аванс обновлен',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            },
        },
        async mounted() {
            await this.setupData();
            await this.initForm();
        },
        async updated() {
            if (typeof this.entity === 'undefined' || typeof this.entity.id === 'undefined') {
                await this.initForm();
            }
        },
    }
</script>
