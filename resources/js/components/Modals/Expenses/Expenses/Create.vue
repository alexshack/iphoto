<template>
    <div>
        <Modal :modalID="modalID">
            <tempalte v-slot:title>Расход</tempalte>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Вид расхода</label>
                            <v-select v-model="formData.expense_type_id" :options="expenseTypes" label="name"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сумма</label>
                            <input v-model="formData.amount" class="form-control" placeholder="Укажите сумму расхода" type="number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-label">Чек</div>
                            <Upload @fileUploaded="setFile"/>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Примечания:</label>
                            <input v-model="formData.note" class="form-control" placeholder="Укажите примечания" type="text">
                        </div>
                        <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                            <span class="font-weight-semibold">Невозможно добавить расход:</span>
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
    import Modal from '@/components/Modals/Modal.vue';
    import {store, types} from '@/db/expenses.js';
    import {prepareFormData} from '@/helpers/form.js';
    import Upload from '@/components/Form/Upload.vue';

    export default{
        name: 'Create',
        components: {
            Modal,
            Upload,
        },
        data: () => {
            return {
                errors: [],
                expenseTypes: [],
                formData: {
                    expense_type_id: null,
                    check_file: null,
                    type: null,
                    amount: 0,
                    note: null,
                },
                loading: false,
                modalID: 'createExpense',
            };
        },
        methods: {
            async setupData() {
                this.expenseTypes = await types();
            },
            setFile(data) {
                if (typeof data.path != 'undefined' && data.path) {
                    this.formData.check_file = data.path;
                }
            },
            async submit() {
                this.loading = true;
                this.errors = [];
                const formData = prepareFormData(this.formData);
                const response = await store(formData);
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
