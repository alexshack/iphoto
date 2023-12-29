<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Снятие кассы</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Время снятия:</label>
                            <VueDatePicker v-model="formData.time" time-picker locale="ru">
                            <template #input-icon>
                                <div class="picker-icon">
                                    <span class="feather feather-clock"></span>
                                </div>
                            </template>
                            </VueDatePicker>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Сумма:</label>
                            <input v-model="formData.sum" class="form-control" placeholder="Укажите сумму" type="number">
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                    <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                    <span class="font-weight-semibold">Невозможно добавить снятие:</span>
                    <div v-for="err in errors">{{ err }}</div>
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
    import { getModalID, prepareData, prepareFormData } from '@/helpers/form.js';
    import { update } from '@/db/withdraw.js';
    import VueDatePicker from '@vuepic/vue-datepicker';

    export default{
        name: 'Create',
        components: {
            Modal,
            VueDatePicker,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('withdraw', this.entity.id);
                }
                return modalID;
            }
        },
        data: () => {
            return {
                errors: [],
                formData: {
                    sum: null,
                    time: null,
                },
                loading: false,
            };
        },
        props: {
            delta: {
                type: Number,
                default: 1,
            },
            entity: {
                type: Object,
                required: true,
            },
        },
        methods: {
            initForm() {
                if (typeof this.entity != 'undefined' && this.entity) {
                    const entity = prepareData(this.entity);
                    for (let p in entity) {
                        this.formData[p] = entity[p];
                    }
                }
            },
            async submit() {
                this.errors = [];
                this.loading = true;
                const formData = prepareFormData(this.formData);
                const response = await update(formData);
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
                            msg: 'Снятие кассы обновлено',
                            type: 'success',
                        }
                    }));
                    window.dispatchEvent(new Event('withDrawUpdate'));
                    this.$emit('submitted')
                }
            }
        },
        mounted() {
            this.initForm();
        },
        updated() {
            if (typeof this.formData.id === 'undefined') {
                this.initForm();
            }
        }
    }
</script>

<style scoped>

</style>

