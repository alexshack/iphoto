<template>
    <div class="offer" :class="offerClass"><!--offer-danger если закрыта, offer-success если открыта-->
        <div class="card-header  border-0">
            <div class="card-title text" :class="titleClass">Смена открыта</div><!--text-danger если закрыта, text-success если открыта-->
        </div>
        <div class="card-body pt-2 pl-3 pr-3">
            <div class="table-responsive">
                <table class="table paddings-small">
                    <tbody>
                        <tr>
                            <td>
                                <span class="w-50">Снятие кассы</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ agenda.withdrawal }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="w-50">Продажи, в том числе:</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ agenda.salesTotal }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Общие продажи</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ agenda.salesGeneral }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Индивидуальные продажи</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ agenda.salesIndividual }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="w-50">Касса, в том числе:</span></td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ agenda.cashTotal }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Наличные</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ agenda.cashMoney }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Терминал</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ agenda.cashTerminal }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="w-50">Расходы из кассы, в том числе:</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ agenda.expensesTotal }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Расходы</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ agenda.expenses }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Перемещения</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ agenda.moves }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Выдача авансов</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ agenda.prepayments }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-5">
                                <span class="w-50 font-weight-semibold">Остаток наличных</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ agenda.cashBalance }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="w-50">Начисленная зарплата</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ agenda.payroll }}₽</h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="py-3">
                <a @click="closeWorkshift()" href="#" class="btn btn-success btn-block font-weight-semibold">
                    ЗАКРЫТЬ СМЕНУ
                </a><!-- если смена открыта, видят только сотрудники и админ -->
                <a v-if="agenda.status === 'close'" href="#" class="btn btn-danger btn-block font-weight-semibold" >ОТМЕНИТЬ ЗАКРЫТИЕ</a><!-- если смена закрыта, при этом следующая смена этой точки не закрыта. видят сотрудники и админ -->
            </div>
            <!-- Алерт отображается удалением класса d-none -->
            <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                <span class="font-weight-semibold">Невозможно закрыть смену:</span>
                <div v-for="err in errors">{{ err }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        name: 'WorkShiftAgenda',
        computed: {
            offerClass() {
                return {'offer-success': true};
            },
            titleClass() {
                return {'text-success': true};
            }
        },
        data: () => {
            return {
                errors: [],

                agenda: {
                    cashBalance: 0,
                    cashMoney: 0,
                    cashTerminal: 0,
                    cashTotal: 0,
                    expenses: 0,
                    expensesTotal: 0,
                    moves: 0,
                    payroll: 0,
                    prepayments: 0,
                    salesGeneral: 0,
                    salesIndividual: 0,
                    salesTotal: 0,
                    status: 'open',
                    withdrawal: 0,
                },
            };
        },
        methods: {
            closeWorkshift() {},
            getWorkShiftAgendaData() {},
        }
    }
</script>
