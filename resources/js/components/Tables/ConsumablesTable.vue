<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Расходные материалы</h4>
            <div class="card-options">
                <a href="#"
                   v-if="createAvailable"
                   class="btn btn-primary btn-sm mr-2"
                   data-toggle="modal"
                   data-target="#createConsumable">
                    Добавить расходник
                </a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="loses">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Товар</th>
                            <th class="border-bottom-0">Количество</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="material in materials" :key="material.id">
                            <td>{{ material.good.name }}</td>
                            <td>{{ material.qty }}</td>
                            <td>
                                <div class="d-flex">
                                    <EditButton entityName="consumables" :entity="material" @submitted="getMaterials"/>
                                    <DestroyButton entity="sales" :id="material.id" @destroyed="getMaterials"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Create @submitted="getMaterials"/>
    </div>
</template>

<script setup>
    import { store } from '@/store/workshift.js';
</script>

<script>
    import {all} from '@/db/sales.js';
    import Create from '@/components/Modals/Consumbales/Create.vue';
    import EditButton from '@/components/Form/Edit.vue';

    export default{
        name: 'ConsumablesTable',
        components: {
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
                materials: [],
            };
        },
        methods: {
            async getMaterials() {
                this.materials = await all(null, 'consumables');
            },
        },
        async mounted() {
            await this.getMaterials();
        }
    }
</script>

<style scoped>

</style>

