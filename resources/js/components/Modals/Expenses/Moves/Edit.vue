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
                            <v-select v-model="formData.recipient_id" :options="places" label="name"/>
                        </div>

                    </div>
                    <div class="tab-pane show" id="move-tab-2">
                        <div class="form-group">
                            <label class="form-label">Менеджер</label>
                            <v-select v-model="formData.recipient_id" :options="managers"/>
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
    import { cityPlaces } from '@/db/places.js';
    import { getActiveManagers } from '@/db/users.js';
    import { getUserName } from '@/helpers/employee.js';
    import { update } from '@/db/moves.js';
    import { getModalID, prepareData, prepareFormData } from '@/helpers/form.js';

    export default{
        name: 'EditMove',
        components: {
            Modal,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('move', this.entity.id);
                }
                return modalID;
            }
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
                places: [],
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
            async initForm() {
                if (typeof this.entity != 'undefined' && this.entity) {
                    const db = {
                        places: this.places,
                        managers: this.managers,
                    };
                    const entity = prepareData(this.entity, db);
                    for (let p in entity) {
                        this.formData[p] = entity[p];
                    }
                }
            },
            async setManagers() {
                let managers = await getActiveManagers();
                this.managers = managers.map((manager) => {
                    return {
                        id: manager.id,
                        label: getUserName(manager.personal_data),
                    };
                });
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
                const formData = prepareFormData(this.formData);
                const response = await update(formData);
                this.loading = false;
                if (response.errors.length > 0) {
                    this.errors = response.errors;
                } else {
                    window.dispatchEvent(new Event(`hideModal.${this.modalID}`));
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: 'Перемещение обновлено',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            },
        },
        async mounted() {
            await this.setupData();
            await this.initForm();
        },
        async updated() {
            if (typeof this.entity === 'undefined' || typeof this.entity.id === 'undefined') {
                await this.initForm();
            }
        },
    }
</script>
