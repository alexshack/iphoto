<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Перемещение</template>
            <template v-slot:body>
                <div class="card-pay">

                    <label class="form-label">Выберите тип получателя</label>
                    <ul class="tabs-menu nav">
                        <li class="w-50">
                            <a @click="setRecipientType('place')" href="#move-tab-1" class="active" data-toggle="tab">
                                Точка
                            </a>
                        </li>
                        <li class="w-50">
                            <a @click="setRecipientType('manager')" href="#move-tab-2" data-toggle="tab">
                                Менеджер
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active show" id="move-tab-1">
                        <div class="form-group">
                            <label class="form-label  col-md-3">Точка</label>
                            <select v-model="formData.recipient_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите точку">
                                <option label="Выберите точку"></option>
                                <!--все точки с Точка.Город = Смена.Точка.Город -->
                                <option v-for="place in places" :key="place.id" :value="place.id">{{ place.name }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="tab-pane show" id="move-tab-2">
                        <div class="form-group">
                            <label class="form-label">Менеджер</label>
                            <select v-model="formData.recipient_id" class="form-control select2-show-search custom-select" data-placeholder="Выберите менеджера">
                                <option label="Выберите менеджера"></option>
                                <!-- Все менеджеры -->
                                <option v-for="manager in managers" :key="manager.id" :value="manager.id">
                                    {{ getUserName(manager.personal_data) }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сумма</label>
                            <input v-model="formData.amount" class="form-control" placeholder="Укажите сумму перемещения" type="number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Примечания:</label>
                            <input v-model="formData.note" class="form-control" placeholder="Укажите примечания" type="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert" v-if="errors.length > 0">
                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i>
                            <span class="font-weight-semibold">Невозможно добавить перемещение:</span>
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
    import {cityPlaces} from '@/db/places.js';
    import {getActiveManagers} from '@/db/users.js';
    import {getUserName} from '@/helpers/employee.js';
    import {store} from '@/db/moves.js';
    export default{
        name: 'Create',
        components: {
            Modal,
        },
        data: () => {
            return {
                errors: [],
                formData: {
                    recipient_type: 'place',
                    recipient_id: null,
                    amount: null,
                    note: null,
                },
                loading: false,
                managers: [],
                modalID: 'createMove',
                places: [],
            };
        },
        methods: {
            getUserName,
            async setManagers() {
                this.managers = await getActiveManagers();
            },
            async setPlaces() {
                this.places = await cityPlaces();
            },
            async setRecipientType(type) {
                this.formData.recipient_type = type;
                this.formData.recipient_id = null;
            },
            async setupData() {
                await this.setPlaces();
                await this.setManagers();
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
                        if (p === 'recipient_type') {
                            this.formData[p] = 'place';
                        }
                        this.formData[p] = null;
                    }
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Перемещение добавлено',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            },
        },
        async mounted() {
            await this.setupData();
        },
    }
</script>
