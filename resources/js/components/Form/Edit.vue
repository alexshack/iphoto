<template>
    <div class="edit-button">
        <a href="#" @click="setCurrentEditable" class="action-btns1" v-loading="loading">
            <i class="feather feather-edit-2  text-success" data-toggle="tooltip" data-placement="top" title="Изменить"></i>
        </a>
        <div v-if="active">
            <AdvancePayment v-if="entityName === 'advancePayment'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <Consumables v-if="entityName === 'consumables'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <Employee v-if="entityName === 'employee'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <Equipment v-if="entityName === 'equipment'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <Expense v-if="entityName === 'expense'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <FCD v-if="entityName === 'fcd'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <Move v-if="entityName === 'move'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <SaleGeneral v-if="entityName === 'saleGeneral'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <SaleIndividual v-if="entityName === 'saleIndividual'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <WasteMaterials v-if="entityName === 'wasteMaterials'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
            <Withdraw v-if="entityName === 'withdraw'" :entity="getData(entity)" :delta="delta" @submitted="submitted"/>
        </div>
    </div>
</template>

<script>
    import AdvancePayment from '@/components/Modals/Expenses/AdvancePayments/Edit.vue';
    import Consumables from '@/components/Modals/Consumbales/Edit.vue';
    import Employee from '@/components/Modals/Employee/Edit.vue';
    import Equipment from '@/components/Modals/Equipments/Edit.vue';
    import Expense from '@/components/Modals/Expenses/Expenses/Edit.vue';
    import FCD from '@/components/Modals/FCD/Edit.vue';
    import Move from '@/components/Modals/Expenses/Moves/Edit.vue';
    import SaleGeneral from '@/components/Modals/Sales/General/Edit.vue';
    import SaleIndividual from '@/components/Modals/Sales/Individual/Edit.vue';
    import WasteMaterials from '@/components/Modals/WasteMaterials/Edit.vue';
    import Withdraw from '@/components/Modals/Withdraw/Edit.vue';
    import { getModalID } from '@/helpers/form.js';
    import { waitForSelector } from '@/helpers/html.js';
    import { isProxy, toRaw } from 'vue';

    export default{
        name: 'EditButton',
        data: () => {
            return {
                active: false,
                loading: false,
                delta: 1,
            };
        },
        components: {
            AdvancePayment,
            Consumables,
            Employee,
            Equipment,
            Expense,
            FCD,
            Move,
            SaleGeneral,
            SaleIndividual,
            WasteMaterials,
            Withdraw,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity.id !== 'undefined') {
                    modalID = getModalID(this.entityName, this.entity.id);
                }
                return modalID;
            }
        },
        props: {
            entityName: {
                type: String,
                required: true,
            },
            entity: {
                type: Object,
                required: true,
            },
        },
        methods: {
            getData(data) {
                if (isProxy(data)) {
                    return toRaw(data);
                }
                return data;
            },
            async setCurrentEditable(event) {
                event.preventDefault();
                if (this.loading) {
                    return;
                }
                this.loading = true;

                this.active = true;
                await waitForSelector(`#${this.modalID}`);
                this.delta = this.delta + 1;
                window.addEventListener('closeModal', () => this.active = false);
                window.dispatchEvent(new Event(`showModal.${this.modalID}`));
                this.loading = false;
            },
            submitted() {
                this.$emit('submitted');
            },
        },
    }
</script>

<style>
.edit-button {
    white-space: normal !important;
}

</style>

