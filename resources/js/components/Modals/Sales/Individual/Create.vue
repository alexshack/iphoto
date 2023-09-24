<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Индивидуальная продажа</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Товар</label>
                            <select v-model="formData.good_id" name=""  class="form-control custom-select select2-show-search "  data-placeholder="Выберите товар">
                                <option label="Выберите товар"></option>
                                <option v-for="good in goods" :value="good.id" :key="good.id">
                                    {{ good.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сотрудник</label>
                            <!-- вариант селекта, если у выбранного товара опция Больше одного человека = НЕТ. В списке Сотрудники, указанные в Сотрудниках смены -->
                            <select v-model="formData.employee_id" name=""  class="form-control custom-select select2-show-search " data-placeholder="Выберите сотрудника" >
                                <option label="Выберите сотрудника"></option>
                                <option v-for="employee in employees" :value="employee.user_id" :key="employee.user_id">
                                    {{ getUserName(employee.user.personal_data, 'F I') }}
                                </option>
                            </select>
                            <!-- вариант селекта, если у выбранного товара опция Больше одного человека = ДА. В списке Сотрудники, указанные в Сотрудниках смены
                            <select name=""  class="form-control select-good-person" data-placeholder="Выберите сотрудника" multiple="multiple" >
                                <option value="1">Иванов Сергей</option>
                                <option value="2">Сергеев Иван</option>
                                <option value="3">Сотрудников Сотрудник</option>
                            </select>-->
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
    import {store} from '@/db/sales.js';
    import {getUserName} from '@/helpers/employee.js';
    import * as employeeApi from '@/db/employee.js';
    import * as goodsList from '@/db/goods.js';

    export default{
        name: 'Create',
        components: {
            Modal,
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
                    employee_id: null,
                    type: null,
                },
                loading: false,
                modalID: 'createIndividualSale',
            };
        },
        methods: {
            getUserName,
            async setupData() {
                this.formData.type = this.goodsType;
                this.employees = await employeeApi.all();
                this.goods = await goodsList.all(this.goodsType);
            },
            async submit() {
                this.loading = true;
                this.errors = [];
                const response = await store(this.formData);
                this.loading = false;
                if (response.errors.legnth > 0) {
                    this.errors = response.errors;
                } else {
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Индивидуальная продажа добавлена',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            },
        },
        async mounted() {
            await this.setupData();
        }
    }
</script>
