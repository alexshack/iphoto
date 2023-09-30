<template>
    <div>
        <Modal :modalID="modalID">
            <tempalte v-slot:title>Расход</tempalte>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Вид расхода</label>
                            <select v-model="formData.expense_type_id" name=""  class="form-control custom-select select2-show-search "  data-placeholder="Выберите вид расхода">
                                <option label="Выберите вид расхода"></option>
                                <!-- виды расходов, с правом создания Сотрудник и статусом Активен -->
                                <option v-for="expenseType in expenseTypes" :value="1" :key="expenseType.id">{{ expenseType.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сумма</label>
                            <input v-model="formData.anount" class="form-control" placeholder="Укажите сумму расхода" type="number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-label">Чек</div>
                            <input type="file" data-height="180"  />
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Примечания:</label>
                            <input v-model="formData.notes" class="form-control" placeholder="Укажите примечания" type="text">
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
    import Modal from '@/components/Modals/Modal.vue';
    import {store, types} from '@/db/expenses.js';
    export default{
        name: 'Create',
        components: {
            Modal,
        },
        data: () => {
            return {
                errors: [],
                expenseTypes: [],
                formData: {
                    expense_type_id: null,
                    type: null,
                },
                loading: false,
                modaleID: 'createExpense',
            };
        },
        methods: {
            async setupData() {
                this.expenseTypes = await types();
            },
            async submit() {
                this.loading = true;
                this.errors = [];
                const response = await store(this.formData);
                this.loading = false;
                if (response.errors.legnth > 0) {
                    this.errors = response.errors;
                } else {
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Расход добавлен',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            }
        },
        async mounted() {
            await this.setupData();
        }
    }
</script>
