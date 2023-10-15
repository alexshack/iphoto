<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Расходы</h4>
            <div class="card-options">
                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#createExpense">Добавить расход</a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="expences">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Расход</th>
                            <th class="border-bottom-0">Сумма</th>
                            <th class="border-bottom-0">Примечания</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="expense in expenses" :key="expense.id">
                            <td>{{ expenseType(expense) }}</td>
                            <td data-order="500" class="text-right">{{ expense.amount }}₽</td>
                            <td v-html="expense.note"></td>
                            <td>
                                <div class="d-flex">
                                    <a @click="$emit('editExpense', expense)" href="#" class="action-btns1"  data-toggle="modal" data-target="#expence"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
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

<script>
    import * as expensesApi from '@/db/expenses.js';
    import Create from '@/components/Modals/Expenses/Expenses/Create.vue';

    export default{
        name: 'Expenses',
        components: {
            Create,
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
        }
    }
</script>

<style scoped>

</style>

