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
                        <WorkShiftData v-if="activeTab === 'workShiftData'"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import WorkShiftData from '@/components/tabs/WorkShiftData.vue';
    export default{
        name: 'WorkShiftTabs',
        components: {
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
                    pays: {
                        //<!-- Отображается только если статус смены Закрыт -->
                        label: 'Начисления ЗП',
                        display: true,
                    },
                };
                return tabs;
            },
        },
        data: () => {
            return {
                activeTab: 'workShiftData',

            };
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

