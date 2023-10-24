<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Отработка</h4>
            <div class="card-options">
                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#createWasteMaterials">Добавить отработку</a>
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
                                    <EditButton entityName="wasteMaterials" :entity="material" @submitted="getMaterials"/>
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

<script>
    import {all} from '@/db/sales.js';
    import Create from '@/components/Modals/WasteMaterials/Create.vue';
    import EditButton from '@/components/Form/Edit.vue';

    export default{
        name: 'WasteMaterialsTable',
        components: {
            Create,
            EditButton,
        },
        data: () => {
            return {
                materials: [],
            };
        },
        methods: {
            confirmDeleteMaterial(material) {},
            async getMaterials() {
                this.materials = await all(null, 'workingout');
            },
        },
        async mounted() {
            await this.getMaterials();
        }
    }
</script>

<style scoped>

</style>

