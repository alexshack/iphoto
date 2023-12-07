<template>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Данные смены</h4>
            <div class="card-options">
                <button class="btn btn-success btn-sm" type="button">Сохранить</button>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group mt-3 mb-3">
                <li class="list-group-item" v-for="(field, index) in variables" :key="index">
                    <div class="row">
                        <div class="col-md-6">{{ field.label }}</div>
                        <div class="col-md-6">
                            <input class="form-control" :type="field.fieldData.type" v-model="field.value">
                        </div>
                    </div>
                </li>
            </ul>
            <button v-loading="loading" @click="submit" class="btn btn-success" type="button">Сохранить</button>
        </div>

    </div>
</template>

<script>
    import { fields, updateField } from '@/db/workshift.js';

    export default{
        name: 'WorkshiftVariables',
        data: () => {
            return {
                variables: [],
            };
        },
        methods: {
            async getFields() {
                this.variables = await fields();
            },
            async submit() {
                let fields = {};
                for (let p in this.variables) {
                    fields[this.variables[p].field] = this.variables[p].value;
                }
                this.loading = true;
                const response = await updateField({fields});
                this.loading = false;
                if (response.errors.length === 0) {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Значения обновлены',
                            type: 'success',
                        }
                    }));
                }
            },
        },
        async mounted() {
            await this.getFields();
        },
    }
</script>

<style scoped>

</style>

