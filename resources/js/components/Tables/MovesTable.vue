<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Перемещения денег</h4>
            <div class="card-options">
                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#createMove">Добавить перемещение</a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="moves">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Получатель</th>
                            <th class="border-bottom-0">Сумма</th>
                            <th class="border-bottom-0">Примечания</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="move in moves" :key="move.id">
                            <td>{{ recipient(move) }}</td>
                            <td :data-order="move.amount" class="text-right">{{ move.amount }}₽</td>
                            <td v-html="move.note"></td>
                            <td>
                                <div class="d-flex">
                                    <EditButton entityName="move" :entity="move" @submitted="getMoves"/>
                                    <DestroyButton entity="moves" :id="move.id" @destroyed="getMoves"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Create @submitted="getMoves()"/>
    </div>
</template>

<script>
    import * as movesApi from '@/db/moves.js';
    import Create from '@/components/Modals/Expenses/Moves/Create.vue';
    import EditButton from '@/components/Form/Edit.vue';
    import {getUserName} from '@/helpers/employee.js';

    export default{
        name: 'MovesTable',
        components: {
            Create,
            EditButton,
        },
        data: () => {
            return {
                moves: [],
            }
        },
        methods: {
            async getMoves() {
                this.moves = await movesApi.all();
            },
            recipient(move) {
                if (typeof move[`recipient_${move.recipient_type}`] != 'undefined') {
                    if (move.recipient_type === 'manager') {
                        return getUserName(move.recipient_manager.personal_data);
                    } else {
                        return move.recipient_place.name;
                    }
                }
            },
        },
        async mounted() {
            await this.getMoves();
        }
    }
</script>

<style scoped>

</style>

