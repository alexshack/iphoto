<template>
    <div>
        <ExpensesTable/>
        <MovesTable/>
        <AdvancePaymentsTable/>
    </div>
</template>

<script>
    import AdvancePaymentsTable from '@/components/Tables/AdvancePaymentsTable.vue';
    import ExpensesTable from '@/components/Tables/Expenses.vue';
    import MovesTable from '@/components/Tables/MovesTable.vue';

    export default{
        name: 'Expenses',
        components: {
            AdvancePaymentsTable,
            ExpensesTable,
            MovesTable,
        },
    }
</script>

<style scoped>

</style>

