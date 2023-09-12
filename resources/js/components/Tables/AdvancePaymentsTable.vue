<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Выдача авансов</h4>
            <div class="card-options">
                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#pay">Добавить аванс</a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="pays">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Получатель</th>
                            <th class="border-bottom-0">Сумма</th>
                            <th class="border-bottom-0">Примечания</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="payment in payments" :key="payment.id">
                            <td>{{ getUserName(payment.user) }}</td>
                            <td :data-order="payment.amount" class="text-right">{{ payment.amount }}₽</td>
                            <td v-html="payment.note"></td>
                            <td>
                                <div class="d-flex">
                                    <a @click="$emit('editPayment', payment)" href="#" class="action-btns1"  data-toggle="modal" data-target="#pay"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
                                    <a @click="confirmDeletePayment(payment)" href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
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
    import {all} from '@/db/pays.js';
    import {getUserName} from '@/helpers/employee.js';

    export default{
        name: 'AdvancePaymentsTable',
        data: () => {
            return {
                payments: [],
            };
        },
        methods: {
            confirmDeletePayment(payment) {
            },
            async getPayments() {
                this.payments = await all();
            },
            getUserName,
        },
        async mounted() {
            await this.getPayments();
        },
    }
</script>
