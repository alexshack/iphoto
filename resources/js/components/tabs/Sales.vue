<template>
    <div>
        <GeneralSales/>
        <IndividualSales/>
    </div>
</template>

<script>
    import GeneralSales from '@/components/Tables/GeneralSales.vue';
    import IndividualSales from '@/components/Tables/IndividualSales.vue';
    export default{
        name: 'Sales',
        components: {
            GeneralSales,
            IndividualSales,
        },
    }
</script>

<style scoped>

</style>

