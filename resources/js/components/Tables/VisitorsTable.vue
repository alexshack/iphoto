<template>
    <div class="card">
        <div class="card-header border-0">
            <h4 class="card-title">Посетители</h4>
        </div>
        <div class="card-body pt-1">
            <div class="table-responsive">
                <table id="visitors" class="table table-vcenter text-nowrap table-bordered border-bottom">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Тип</th>
                            <th class="border-bottom-0">Кол-во</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(t, index) in types" :key="t.id">
                            <th>{{ t.type_name }}</th>
                            <th>
                                <input class="form-control"
                                       v-model="t.total"
                                       type="number" min="1" step="1">
                            </th>
                        </tr>
                    </tbody>
                </table>
                <button @click="submit" v-loading="loading" class="btn btn-success" type="button">Сохранить</button>
            </div>
        </div>

    </div>
</template>

<script>
    import { all, update } from '@/db/visitors.js';

    export default{
        name: 'VisitorsTable',
        data: () => {
            return {
                loading: false,
                types: [],
            };
        },
        methods: {
            async setupData() {
                this.types = await all();

            },
            async submit() {
                let visitors = [];
                this.loading = true;
                for (let p in this.types) {
                    visitors.push({
                        id: this.types[p].id,
                        total: this.types[p].total,
                    });
                }
                const response = await update({visitors});
                this.loading = false;
                if (response.errors.length === 0) {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Количество посетителей обнволено',
                            type: 'success',
                        }
                    }));
                }
            },
        },
        async mounted() {
            await this.setupData();
        }
    }
</script>

<style scoped>

</style>

