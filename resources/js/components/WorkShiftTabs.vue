<template>
    <div>
        <div class="tab-menu-heading p-0 ">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                    <li v-for="(tab, slug) in tabs" :key="slug" @click="setTab(slug)">
                        <a href="#tab" :class="{active: activeTab === slug}" data-toggle="tab">{{ tab.label }}</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body tabs-menu-body hremp-tabs1 p-0">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <Consumables v-if="activeTab === 'consumables'"/>
                        <Equipment v-if="activeTab === 'equipment'"/>
                        <Expenses v-if="activeTab === 'expenses'"/>
                        <Finals v-if="activeTab === 'finals'"/>
                        <Pays v-if="activeTab === 'pays'"/>
                        <Sales v-if="activeTab === 'sales'"/>
                        <WorkShiftData v-if="activeTab === 'workShiftData'"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Consumables from '@/components/tabs/Consumables.vue';
    import Equipment from '@/components/tabs/Equipment.vue';
    import Expenses from '@/components/tabs/Expenses.vue';
    import Finals from '@/components/tabs/Finals.vue';
    import Pays from '@/components/tabs/Pays.vue';
    import Sales from '@/components/tabs/Sales.vue';
    import WorkShiftData from '@/components/tabs/WorkShiftData.vue';
    export default{
        name: 'WorkShiftTabs',
        components: {
            Consumables,
            Equipment,
            Expenses,
            Finals,
            Pays,
            Sales,
            WorkShiftData,
        },
        computed: {
            tabs() {
                let tabs = {
                    workShiftData: {
                        label: 'Смена',
                        display: true,
                    },
                    sales: {
                        label: 'Продажи',
                        display: true,
                    },
                    expenses: {
                        label: 'Расходы из кассы',
                        display: true,
                    },
                    finals: {
                        label: 'Итоговая касса',
                        display: true,
                    },
                    equipment: {
                        label: 'Учет оборудования',
                        display: true,
                    },
                    consumables: {
                        label: 'Расходники',
                        display: true,
                    },
                };
                if (this.workShift && this.workShift.is_closed) {
                    tabs.pays = {
                        //<!-- Отображается только если статус смены Закрыт -->
                        label: 'Начисления ЗП',
                    };
                }
                return tabs;
            },
        },
        data: () => {
            return {
                activeTab: 'workShiftData',
            };
        },
        props: {
            workShift: {
                type: Object,
                default: {},
                required: true,
            },
        },
        methods: {
            setTab(slug) {
                if (typeof this.tabs[slug] != 'undefined') {
                    this.activeTab = slug;
                }
            },
        },
    }
</script>

<style scoped>

</style>

