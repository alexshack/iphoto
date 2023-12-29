<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Оборудование</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Оборудование</label>
                            <input class="form-control" :value="equipmentName" type="text" disabled><!-- Наименование товара, серийный номер -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">На начало смены</label>
                            <input class="form-control" v-model="formData.on_start" placeholder="Укажите показания" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">На конец смены</label>
                            <input class="form-control" v-model="formData.on_end" placeholder="Укажите показания" type="number">
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
            equipmentName() {
                const name = this.formData.good ? this.formData.good.name : '';
                const serialNumber = this.formData.good ? this.formData.good.serial_number : '';
                return [name, serialNumber].join(', ');
            },
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('equipment', this.entity.id);
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
                goodsType: 'equipment',
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
                            msg: 'Оборудование обновлено',
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

