<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Индивидуальная продажа</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Товар</label>
                            <v-select v-model="formData.good_id" :options="goods" label="name"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сотрудник</label>
                            <v-select v-model="formData.employee_id" :options="employees"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Количество:</label>
                            <input v-model="formData.qty" class="form-control" placeholder="Укажите количество" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Цена:</label>
                            <input v-model="formData.price" class="form-control" placeholder="Укажите цену" type="number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                            <span class="font-weight-semibold">Невозможно обновить продажу:</span>
                            <div v-for="err in errors">{{ err }}</div>
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
    import Modal from '@/components/Modals/Modal.vue';
    import { update } from '@/db/sales.js';
    import { getUserName } from '@/helpers/employee.js';
    import * as employeeApi from '@/db/employee.js';
    import * as goodsList from '@/db/goods.js';
    import { getModalID, prepareData, prepareFormData } from '@/helpers/form.js';

    export default{
        name: 'EditGeneralSale',
        components: {
            Modal,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('saleIndividual', this.entity.id);
                }
                return modalID;
            }
        },
        data: () => {
            return {
                goodsType: 'individual',
                goods: [],
                employees: [],
                errors: [],
                formData: {
                    good_id: null,
                    qty: null,
                    price: null,
                    employees: [],
                    type: null,
                },
                loading: false,
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
            async setupData() {
                this.formData.type = this.goodsType;
                let employees = await employeeApi.all();
                this.employees = employees.map(employee => {
                    return {
                        id: employee.id,
                        label: getUserName(employee.user.personal_data, 'F I'),
                    };
                });
                this.goods = await goodsList.all(this.goodsType);
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
                    for (let p in this.formData) {
                        this.formData[p] = null;
                    }
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Общая продажа обновлена',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            },
            async initForm() {
                if (typeof this.entity != 'undefined' && this.entity) {
                    const db = {
                        goods: this.goods,
                        employees: this.employees,
                    };
                    const entity = prepareData(this.entity, db);
                    for (let p in entity) {
                        this.formData[p] = entity[p];
                    }
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
