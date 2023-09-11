<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Общие продажи</h4>
            <div class="card-options">
                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#all-good">Добавить товар</a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="all-goods">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 text-center">Товар</th>
                            <th class="border-bottom-0">Цена</th>
                            <th class="border-bottom-0">Количество</th>
                            <th class="border-bottom-0">Сумма</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sale in sales" :key="sale.id">
                            <td>{{ sale.good.name }}</td>
                            <td data-order="200" class="text-right">{{ sale.price }}₽</td>
                            <td class="text-right">{{ sale.qty }}</td>
                            <td data-order="4000" class="text-right  text-bold">{{ sale.price * sale.qty }}₽</td>
                            <td>
                                <div class="d-flex">
                                    <a @click="$emit('editGeneralSale', sale)" href="#" class="action-btns1"  data-toggle="modal" data-target="#all-good"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
                                    <a @click="confirmDeleteSale(sale)" href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import * as salesApi from '@/db/sales.js';

    export default{
        name: 'GeneralSales',
        data: () => {
            return {
                sales: [],
            };
        },
        methods: {
            confirmDeleteSale(sale) {
            },
            async getSales() {
                this.sales = await salesApi.all();
            },
        },
        async mounted() {
            await this.getSales();
        }
    }
</script>

<style scoped>

</style>

