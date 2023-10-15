<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Данные кассы</h4>
            <div class="card-options">
                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#createFCD">Добавить кассу</a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="sales">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Вид продажи</th>
                            <th class="border-bottom-0">Сумма</th>
                            <th class="border-bottom-0">Примечания</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fcd in fcds" :key="fcd.id">
                            <td>{{ fcd.sale_type.name }}</td>
                            <td :data-order="fcd.sum" class="text-right">{{ fcd.sum }}₽</td>
                            <td v-html="fcd.note"></td>
                            <td>
                                <div class="d-flex">
                                    <a @click="$emit('editFCD', fcd)" href="#" class="action-btns1"  data-toggle="modal" data-target="#sale"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
                                    <DestroyButton entity="fcd" :id="fcd.id" @destroyed="getFCDs"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Create @submitted="getFCDs"/>
    </div>
</template>

<script>
    import {all} from '@/db/fcd.js';
    import Create from '@/components/Modals/FCD/Create.vue';

    export default{
        name: 'FinalCashDrawTable',
        components: {
            Create,
        },
        data: () => {
            return {
                fcds: [],
            }
        },
        methods: {
            confirmDeleteFCD(fcd) {},
            async getFCDs() {
                this.fcds = await all();
            },
        },
        async mounted() {
            await this.getFCDs();
        }
    }
</script>

<style scoped>

</style>

