<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Касса</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Вид продажи</label>
                            <select v-model="formData.sale_type_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите вид продажи">
                                <option label="Выберите вид продажи"></option>
                                <!-- Виды продаж, Статус = Активен -->
                                <option v-for="saleType in saleTypes" :key="saleType.id" :value="saleType.id">
                                    {{ saleType.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сумма</label>
                            <input v-model="formData.sum" class="form-control" placeholder="Укажите сумму" type="number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Примечания:</label>
                            <input v-model="formData.note" class="form-control" placeholder="Укажите примечания" type="text">
                        </div>
                        <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                            <span class="font-weight-semibold">Невозможно добавить итоговую кассу:</span>
                            <div v-for="err in errors">{{ err }}</div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <button @click="submit" v-loading="loading"  class="btn btn-success">Сохранить</button>
            </template>
        </Modal>
    </div>
</template>

<script>
    import {getSaleTypes} from '@/db/sales.js';
    import Modal from '@/components/Modals/Modal.vue';
    import {store} from '@/db/fcd.js';

    export default {
        name: 'Create',
        components: {
            Modal,
        },
        data: () => {
            return {
                errors: [],
                formData: {
                    sale_type_id: null,
                    sum: null,
                    note: null,
                },
                loading: false,
                modalID: 'createFCD',
                saleTypes: [],
            };
        },
        methods: {
            async setSaleTypes() {
                this.saleTypes = await getSaleTypes();
            },
            async submit() {
                this.loading = true;
                this.errors = [];
                const response = await store(this.formData);
                this.loading = false;
                if (response.errors.length > 0) {
                    this.errors = response.errors;
                } else {
                    for (let p in this.formData) {
                        this.formData[p] = null;
                    }
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Итоговая касса добавлена',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            }
        },
        async mounted() {
            await this.setSaleTypes();
        },
    };
</script>

