<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Расходы</h4>
            <div class="card-options">
                <a href="#"
                   v-if="createAvailable"
                   class="btn btn-primary btn-sm mr-2"
                   data-toggle="modal"
                   data-target="#createExpense">
                    Добавить расход
                </a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="expences">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Расход</th>
                            <th class="border-bottom-0">Сумма</th>
                            <th class="border-bottom">Чек</th>
                            <th class="border-bottom-0">Примечания</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="expense in expenses" :key="expense.id">
                            <td>{{ expenseType(expense) }}</td>
                            <td data-order="500" class="text-right">{{ expense.amount }}₽</td>
                            <td>
                                <CheckFilePreview :url="expense.check_file"/>
                            </td>
                            <td v-html="expense.note"></td>
                            <td>
                                <div class="d-flex">
                                    <EditButton entityName="expense" :entity="expense" @submitted="getExpenses"/>
                                    <DestroyButton entity="expenses" :id="expense.id" @destroyed="getExpenses"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Create @submitted="getExpenses()"/>
    </div>
</template>

<script setup>
    import { store } from '@/store/workshift.js';
</script>

<script>
    import * as expensesApi from '@/db/expenses.js';
    import CheckFilePreview from '@/components/Media/CheckFilePreview.vue';
    import Create from '@/components/Modals/Expenses/Expenses/Create.vue';
    import EditButton from '@/components/Form/Edit.vue';

    export default {
        name: 'Expenses',
        components: {
            CheckFilePreview,
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
                expenses: [],
            };
        },
        methods: {
            expenseType(expense) {
                if (typeof expense.expense_type != 'undefined' && expense.expense_type) {
                    return expense.expense_type.name;
                }
                return '-';
            },
            async getExpenses() {
                this.expenses = await expensesApi.all();
            },
        },
        async mounted() {
            await this.getExpenses();
        },
    }
</script>

<style scoped>

</style>

