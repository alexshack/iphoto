<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Выдача авансов</h4>
            <div class="card-options">
                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#createAdvancePayment">Добавить аванс</a>
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
                            <td>{{ getUserName(payment.user.personal_data) }}</td>
                            <td :data-order="payment.amount" class="text-right">{{ payment.amount }}₽</td>
                            <td v-html="payment.note"></td>
                            <td>
                                <div class="d-flex">
                                    <EditButton entityName="advancePayment" :entity="payment" @submitted="getPayments"/>
                                    <DestroyButton entity="pays" :id="payment.id" @destroyed="getPayments"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Create @submitted="getPayments()"/>
    </div>
</template>

<script>
    import {all} from '@/db/pays.js';
    import Create from '@/components/Modals/Expenses/AdvancePayments/Create.vue';
    import EditButton from '@/components/Form/Edit.vue';
    import {getUserName} from '@/helpers/employee.js';

    export default{
        name: 'AdvancePaymentsTable',
        components: {
            Create,
            EditButton,
        },
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
