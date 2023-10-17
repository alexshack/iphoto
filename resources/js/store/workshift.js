import { reactive } from 'vue';

export const store = reactive({
    agenda: {
        cashBalance: 10,
        cashBox: {
            amount: 0,
            children: [],
        },
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
    updateAgenda(obj) {
        if (typeof obj === 'undefined' || !obj) {
            return;
        }
        for (let p in obj) {
            this.agenda[p] = obj[p];
        }
    },
});
