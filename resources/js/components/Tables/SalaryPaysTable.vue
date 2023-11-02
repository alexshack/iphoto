<template>
    <div class="card-header  border-0">
        <h4 class="card-title">Начисления ЗП по смене</h4>
    </div>
    <div class="card-body pt-1">
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="calcs">
                <thead>
                    <tr>
                        <th class="border-bottom-0">Сотрудник</th>
                        <th class="border-bottom-0">Вид начисления</th>
                        <th class="border-bottom-0">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="payment in payments" :key="payment.id">
                        <td>{{ getUserName(payment.user.personal_data) }}</td>
                        <td>{{ payment.calc_type.name }}</td>
                        <td :data-order="payment.amount" class="text-right">{{ payment.amount }}₽</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import {all} from '@/db/calcs.js';
    import {getUserName} from '@/helpers/employee.js';

    export default{
        name: 'SalaryPaysTable',
        data: () => {
            return {
                payments: [],
            };
        },
        methods: {
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
