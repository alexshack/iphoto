<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Оборудование</h4>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="devices">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Оборудование</th>
                            <th class="border-bottom-0">Серийный номер</th>
                            <th class="border-bottom-0">Начало</th>
                            <th class="border-bottom-0">Конец</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="equipment in equipments" :key="equipment.id">
                            <td>{{ equipment.good.name }}</td>
                            <td>{{ equipment.good.serial_number }}</td>
                            <td>{{ equipment.on_start }}</td>
                            <td>{{ equipment.on_end }}</td>
                            <td>
                                <div class="d-flex">
                                    <EditButton entityName="equipment" :entity="equipment" @submitted="getEquipments"/>
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
    import {all} from '@/db/sales.js';
    import EditButton from '@/components/Form/Edit.vue';

    export default{
        name: 'EquipmentsTable',
        components: {
            EditButton,
        },
        data: () => {
            return {
                equipments: [],
            };
        },
        methods: {
            async getEquipments() {
                this.equipments = await all(null, 'tmc');
            },
        },
        async mounted() {
            this.getEquipments();
        },
    }
</script>

<style scoped>

</style>

