<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Общие продажи</h4>
            <div class="card-options">
                <a href="#"
                   v-if="createAvailable"
                   class="btn btn-primary btn-sm mr-2"
                   data-toggle="modal"
                   data-target="#createGeneralSale">
                    Добавить товар
                </a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="all-goods">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 text-center">Товар</th>
                            <th class="border-bottom-0">Продавец</th>
                            <th class="border-bottom-0">Цена</th>
                            <th class="border-bottom-0">Количество</th>
                            <th class="border-bottom-0">Сумма</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sale in sales" :key="sale.id">
                            <td>{{ sale.good.name }}</td>
                            <td>
                                {{ getSellerNames(sale) }}
                            </td>
                            <td data-order="200" class="text-right">{{ sale.price }}₽</td>
                            <td class="text-right">{{ sale.qty }}</td>
                            <td data-order="4000" class="text-right  text-bold">{{ sale.price * sale.qty }}₽</td>
                            <td>
                                <div class="d-flex">
                                    <EditButton entityName="saleGeneral" :entity="sale" @submitted="getSales"/>
                                    <DestroyButton entity="sales" :id="sale.id" @destroyed="getSales"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Create @submitted="getSales"/>
    </div>
</template>

<script setup>
    import { store } from '@/store/workshift.js';
</script>

<script>
    import * as salesApi from '@/db/sales.js';
    import Create from '@/components/Modals/Sales/General/Create.vue';
    import EditButton from '@/components/Form/Edit.vue';
    import {getUserName} from '@/helpers/employee.js';
    import { getData } from '@/helpers/proxy.js';

    export default{
        name: 'GeneralSales',
        components: {
            Create,
            EditButton,
        },
        computed: {
            createAvailable() {
                return store.agenda.status === 'open';
            },
        },
        data: () => {
            return {
                sales: [],
            };
        },
        methods: {
            async getSales() {
                this.sales = await salesApi.all();
            },
            getSellerNames(sale) {
                sale = getData(sale);
                let sellerNames = [];
                if (typeof sale.employees !== 'undefined' && sale.employees && sale.employees.length > 0) {
                    sale.employees.forEach((employee) => {
                        if (employee.employee) {
                            sellerNames.push(getUserName(employee.employee.user.personal_data, 'F I'));
                        }
                    });
                }
                return sellerNames.join(', ');
            },
        },
        async mounted() {
            await this.getSales();
        }
    }
</script>

