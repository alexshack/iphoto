<template>
    <div class="offer" :class="offerClass"><!--offer-danger если закрыта, offer-success если открыта-->
        <div class="card-header  border-0">
            <div class="card-title text" :class="titleClass" v-html="titleText"></div>
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
                                <h4 class="font-weight-semibold text-right mb-0">{{ store.agenda.withdrawal }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="w-50">Продажи, в том числе:</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ store.agenda.salesTotal }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Общие продажи</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ store.agenda.salesGeneral }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Индивидуальные продажи</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ store.agenda.salesIndividual }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="w-50">Касса, в том числе:</span></td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ store.agenda.cashBox.amount }}₽</h4>
                            </td>
                        </tr>
                        <tr v-for="(cashBoxItem, cashBoxItemIndex) in store.agenda.cashBox.children">
                            <td><span class="w-50 pl-3">{{ cashBoxItem.label }}</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ cashBoxItem.amount }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="w-50">Расходы из кассы, в том числе:</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ store.agenda.expensesTotal }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Расходы</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ store.agenda.expenses }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Перемещения</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ store.agenda.moves }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="w-50 pl-3">Выдача авансов</span></td>
                            <td>
                                <div class="font-weight-semibold text-right">{{ store.agenda.prepayments }}₽</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-5">
                                <span class="w-50 font-weight-semibold">Остаток наличных</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ store.agenda.cashBalance }}₽</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="w-50">Начисленная зарплата</span>
                            </td>
                            <td>
                                <h4 class="font-weight-semibold text-right mb-0">{{ store.agenda.payroll }}₽</h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="py-3">
                <a v-if="access.closable"
                   v-loading="loading"
                    @click="closeWorkshift()" href="#" class="btn btn-success btn-block font-weight-semibold">
                    ЗАКРЫТЬ СМЕНУ
                </a><!-- если смена открыта, видят только сотрудники и админ -->
                <a v-if="access.cancelable"
                   v-loading="loading"
                   @click="reopen()"
                    href="#" class="btn btn-danger btn-block font-weight-semibold" >ОТМЕНИТЬ ЗАКРЫТИЕ</a><!-- если смена закрыта, при этом следующая смена этой точки не закрыта. видят сотрудники и админ -->
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

<script setup>
    import { store } from '@/store/workshift.js';
</script>

<script>
    import { close, reopen } from '@/db/workshift.js';

    export default {
        name: 'WorkShiftAgenda',
        computed: {
            offerClass() {
                return {
                    'offer-success': store.agenda.status === 'open',
                    'offer-danger': store.agenda.status === 'closed',
                };
            },
            titleClass() {
                return {
                    'text-success': store.agenda.status === 'open',
                    'text-danger': store.agenda.status === 'closed',
                };
            },
            titleText() {
                return store.agenda.status === 'open' ? 'Смена открыта' : 'Смена закрыта';
            },
        },
        data: () => {
            return {
                loading: false,
            };
        },
        props: {
            access: {
                type: Object,
                default: {
                    closable: false,
                    cancelable: false,
                },
            },
            errors: {
                type: Array,
                default: [],
            }
        },
        methods: {
            async closeWorkshift() {
                if (this.loading) {
                    return;
                }
                this.loading = true;
                const response = await close();
                console.log({response})
                this.loading = false;
            },
            refreshData() {
            },
            async reopen() {
                if (this.loading) {
                    return;
                }
                this.loading = true;
                const response = await reopen();
                console.log({response})
                this.loading = false;
            }
        },
        mounted() {
            document.addEventListener('refreshAgenda', () => this.refreshData());
        },
    }
</script>
