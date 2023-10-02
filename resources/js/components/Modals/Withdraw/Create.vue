<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Снятие кассы</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Время снятия:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="feather feather-clock"></span>
                                    </div>
                                </div><!-- input-group-prepend -->
                                <input v-model="formData.time"
                                    class="form-control ui-timepicker-input" id="tpTimeTime" placeholder="Укажите время" type="text" autocomplete="off">
                            </div>
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
                    <span class="font-weight-semibold">Невозможно добавить сотрудника:</span>
                    <div v-for="err in errors">{{ err }}</div>
                </div>
            </template>
            <template v-slot:footer>
                <button @click="submit"  class="btn btn-success">Сохранить</button>
            </template>
        </Modal>
    </div>
</template>

<script>
    import Modal from '@/components/Modals/Modal.vue';
    import {store} from '@/db/withdraw.js';

    export default{
        name: 'Create',
        components: {
            Modal,
        },
        data: () => {
            return {
                errors: [],
                formData: {
                    sum: null,
                    time: null,
                },
                modalID: 'createWithdraw',
            };
        },
        methods: {
            async submit() {
                this.errors = [];
                const response = await store(this.formData);
                if (response.errors.length > 0) {
                    this.errors = response.errors;
                } else {
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Снятие кассы добавлено',
                            type: 'success',
                        }
                    }));
                    window.dispatchEvent(new Event('withDrawUpdate'));
                }
            }
        },
    }
</script>

<style scoped>

</style>

