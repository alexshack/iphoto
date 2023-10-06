<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Отработка</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Товар</label>
                            <select v-model="formData.good_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите отработку">
                                <option label="Выберите отработку"></option>
                                <!-- Товар при Товар.Тип = Отработка -->
                                <option v-for="good in goods" :key="good.id" :value="good.id">
                                    {{ good.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Количество</label>
                            <input v-model="formData.qty" class="form-control" placeholder="Укажите количество" type="number">
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
    import {store} from '@/db/sales.js';

    export default{
        name: 'Create',
        components: {
            Modal,
        },
        data: () => {
            return {
                errors: [],
                formData: {
                    good_id: null,
                    qty: null,
                },
                goods: [],
                goodsType: 'workingout',
                loading: false,
                modalID: 'createWasteMaterials',
            };
        },
        methods: {
            async getGoods() {
                this.goods = await all(this.goodsType);
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
                            msg: 'Отработка добавлена',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            },
        },
        async mounted() {
            this.getGoods();
        },
    }
</script>

<style scoped>

</style>

