<template>
    <div>
        <WasteMaterialsTable/>
        <ConsumablesTable/>
    </div>
</template>

<script>
    import ConsumablesTable from '@/components/Tables/ConsumablesTable.vue';
    import WasteMaterialsTable from '@/components/Tables/WasteMaterialsTable.vue';

    export default{
        name: 'Consumables',
        components: {
            ConsumablesTable,
            WasteMaterialsTable,
        },
    }
</script>
