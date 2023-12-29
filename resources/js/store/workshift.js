import { reactive } from 'vue';

export const store = reactive({
    access: {
        closed: false,
        closable: false,
        cancelable: false,
    },
    agenda: {
        cashBalance: 0,
        cashBox: {
            amount: 0,
            children: [],
        },
        cashMoney: 0,
        cashTerminal: 0,
        cashTotal: 0,
        checkAverage: 0,
        expenses: 0,
        expensesTotal: 0,
        moves: 0,
        payroll: 0,
        prepayments: 0,
        salesGeneral: 0,
        salesIndividual: 0,
        salesTotal: 0,
        status: 'open',
        visitors: 0,
        withdrawal: 0,
    },
    errors: [],
    updateAgenda(obj) {
        if (typeof obj === 'undefined' || !obj) {
            return;
        }
        for (let p in obj) {
            this.agenda[p] = obj[p];
        }
    },
    updateAgendaAccess(obj) {
        if (typeof obj === 'undefined' || !obj) {
            return;
        }
        for (let p in obj) {
            this.access[p] = obj[p];
        }
    },
    updateAgendaErrors(arr) {
        if (typeof arr === 'undefined') {
            return;
        }
        this.errors = arr;
    },
});
