<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Расходник</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Товар</label>
                            <v-select v-model="formData.good_id" :options="goods" label="name"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Количество</label>
                            <input v-model="formData.qty" class="form-control" placeholder="Укажите количество" type="number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                            <span class="font-weight-semibold">Невозможно изменить расходник:</span>
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
    import {all} from '@/db/goods.js';
    import {update} from '@/db/sales.js';
    import { getModalID, prepareData, prepareFormData } from '@/helpers/form.js';

    export default{
        name: 'Create',
        components: {
            Modal,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('consumables', this.entity.id);
                }
                return modalID;
            }
        },
        data: () => {
            return {
                errors: [],
                formData: {
                    good_id: null,
                    qty: null,
                },
                goods: [],
                goodsType: 'consumables',
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
            async getGoods() {
                this.goods = await all(this.goodsType);
            },
            async initForm() {
                if (typeof this.entity != 'undefined' && this.entity) {
                    const db = {
                        goods: this.goods,
                    };
                    const entity = prepareData(this.entity, db);
                    for (let p in entity) {
                        this.formData[p] = entity[p];
                    }
                }
            },
            async submit() {
                this.loading = true;
                this.errors = [];
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
                            msg: 'Расходник обновлен',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            },
        },
        async mounted() {
            await this.getGoods();
            await this.initForm();
        },
    }
</script>

<style scoped>

</style>

