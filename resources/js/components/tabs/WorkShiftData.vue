<template>
    <div>
        <div class="card-header  border-0">
            <h4 class="card-title">Сотрудники</h4>
            <div class="card-options">
                <a v-if="createAvailable" href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#createEmployee">
                    Добавить сотрудника
                </a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="employees">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 text-center">Сотрудник</th>
                            <th class="border-bottom-0">Приход</th>
                            <th class="border-bottom-0">Уход</th>
                            <th class="border-bottom-0">Время</th>
                            <th class="border-bottom-0">Статус</th>
                            <th class="border-bottom-0">Роль</th>
                            <th class="border-bottom-0">Зарплата</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="employee in employees" :key="employee.id">
                            <td data-order="employee.name">
                                <div class="d-flex">
                                    <span v-if="employee.photo"
                                          class="avatar avatar brround mr-3"
                                          :style="{'background-image': `url(${employee.user.photo})`}"></span>
                                    <div class="mr-3 mt-0 mt-sm-2 d-block">
                                        <h6 class="mb-1 fs-14">{{ getUserName(employee.user.personal_data, 'F I') }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td data-order="">{{ employee.start_time }}</td>
                            <td data-order="">{{ employee.end_time }}</td>
                            <td data-order="">{{ toHoursAndMinutes(employee.work_time) }}</td>
                            <td>{{ employee.status.name }}</td>
                            <td>{{ employee.position.name }}</td>
                            <td :data-order="employee.salary">{{ employee.salary }}₽</td>
                            <td>
                                <div class="d-flex">
                                    <EditButton entityName="employee" :entity="employee" @submitted="getEmployees"/>
                                    <DestroyButton entity="employee" :id="employee.id" @destroyed="getEmployees"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-header  border-0">
            <h4 class="card-title">Снятие кассы</h4>
            <div class="card-options">
                <a v-if="createAvailable" href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#createWithdraw">
                    Добавить снятие
                </a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="times">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 text-center">Время</th>
                            <th class="border-bottom-0">Сумма</th>
                            <th class="border-bottom-0">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="withdrawal in withdrawals">
                            <td data-order="">{{ withdrawal.time }}</td>
                            <td :data-order="withdrawal.sum">{{ withdrawal.sum }}₽</td>
                            <td>
                                <div class="d-flex">
                                    <EditButton entityName="withdraw" :entity="withdrawal" @submitted="getWithdraw"/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <VisitorsTable/>

        <CreateEmployee v-if="createAvailable" @submitted="getEmployees"/>
        <CreateWithdraw v-if="createAvailable" @submitted="getWithdraw"/>
    </div>
</template>

<script setup>
    import { store } from '@/store/workshift.js';
</script>

<script>
    import * as employeeApi from '@/db/employee.js';
    import * as withdrawApi from '@/db/withdraw.js';
    import CreateEmployee from '@/components/Modals/Employee/Create.vue';
    import CreateWithdraw from '@/components/Modals/Withdraw/Create.vue';
    import EditButton from '@/components/Form/Edit.vue';
    import {getUserName} from '@/helpers/employee.js';
    import {toHoursAndMinutes} from '@/helpers/dateTime.js';
    import VisitorsTable from '@/components/Tables/VisitorsTable.vue';

    export default{
        name: 'WorkShiftData',
        components: {
            CreateEmployee,
            CreateWithdraw,
            EditButton,
            VisitorsTable,
        },
        data: () => {
            return {
                currentEmployee: -1,
                employees: [],
                loading: true,
                withdrawals: [],
            };
        },
        computed: {
            createAvailable() {
                return store.agenda.status === 'open';
            },
        },
        methods: {
            async deleteEmployee(ID) {
                await employeeApi.deleteEmployee(ID);
                window.dispatchEvent(new CustomEvent('notify', {
                    type: 'success',
                    msg: 'Сотрудник удален',
                }));
                await this.getEmployees();
            },
            async getEmployees() {
                this.employees = await employeeApi.all();
            },
            async getWithdraw() {
                this.withdrawals = await withdrawApi.all();
            },
            getUserName,
            async onPreview(e) {
                console.log(e);
                await this.getEmployees();
            },
            setCurrentEmployee(ID) {
                this.currentEmployee = ID;
            },
            async setupData() {
                window.addEventListener('workDataEmployeeUpdate', await this.getEmployees);
                window.addEventListener('withDrawUpdate', await this.getWithdraw);
            },
            toHoursAndMinutes,
        },
        async created() {
            window.emitter.on('updateEmployees', async (e) => {
                console.log('updateEmployees');
                await this.getEmployees()
            });
        },
        async mounted() {
            await this.getEmployees();
            await this.getWithdraw();
        },
    }
</script>
