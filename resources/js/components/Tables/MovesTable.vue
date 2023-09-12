<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Перемещения денег</h4>
            <div class="card-options">
                <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#move">Добавить перемещение</a>
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
                                    <a @click="$emit('editMove', move)" href="#" class="action-btns1"  data-toggle="modal" data-target="#move"><i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i></a>
                                    <a @click="confirmDeleteMove(move)" href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="feather feather-trash-2 text-danger"></i></a>
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
    import * as movesApi from '@/db/moves.js';
    import {getUserName} from '@/helpers/employee.js';

    export default{
        name: 'MovesTable',
        data: () => {
            return {
                moves: [],
            }
        },
        methods: {
            confirmDeleteMove(move) {},
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

