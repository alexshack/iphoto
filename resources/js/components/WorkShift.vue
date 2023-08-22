<template>
    <div>
        <!--Page header-->
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <h4 class="page-title">Смена 24.06.2023 - Белгород - Аквапарк  <a href="#" class="font-weight-normal text-muted ml-2">Смены</a></h4>
                <p>{{ title }}</p>
            </div>
        </div>
        <!--End Page header-->

        <div class="row">
            <div class="col-xl-3 col-md-12 col-lg-12">
                <WorkShiftAgenda/>
            </div>
            <div class="col-xl-9 col-md-12 col-lg-12">
                <WorkShiftTabs/>
            </div>
        </div>
    </div>
</template>

<script>
    import WorkShiftAgenda from '@/components/WorkShiftAgenda.vue';
    import WorkShiftTabs from '@/components/WorkShiftTabs.vue';
    export default{
        name: 'WorkShift',
        components: {
            WorkShiftAgenda,
            WorkShiftTabs,
        },
        data: () => {
            return {
            };
        },
    }
</script>

<style scoped>

</style>

