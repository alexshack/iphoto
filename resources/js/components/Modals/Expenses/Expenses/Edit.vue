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
                            <Uploader :max="1"
                                 ref="uploaderComponent"
                                 :server="uploadURL"
                                 @add="addAttachment"
                                 @remove="removeAttachment"
                                 :media="media"/>
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
    import {update, types} from '@/db/expenses.js';
    import mime from 'mime';
    import { getModalID, prepareData, prepareFormData } from '@/helpers/form.js';
    import { toRaw } from 'vue';
    import Uploader from '@/components/Form/Uploader/Uploader.vue';

    export default{
        name: 'Edit',
        components: {
            Modal,
            Uploader,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('expense', this.entity.id);
                }
                return modalID;
            }
        },
        data: () => {
            return {
                attachments: [],
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
                media: [],
                uploadURL: '',
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
            addAttachment(attachment) {
                //console.log('addAttachment', attachment);
                this.attachments.push(toRaw(attachment));
            },
            removeAttachment(attachment) {
                this.attachments = this.attachments.filter(item => item.name !== attachment.name);
                this.media = {...this.attachments};
            },
            async initForm() {
                this.uploadURL = `${window.workshiftUrls.file.upload}?workshiftID=${window.workshiftData.id}`;
                if (typeof this.entity != 'undefined' && this.entity) {
                    const db = {
                        expenseTypes: this.expenseTypes,
                    };
                    const entity = prepareData(this.entity, db);
                    for (let p in entity) {
                        this.formData[p] = entity[p];
                    }
                    if (entity.check_file) {
                        this.media.push({
                            name: entity.check_file,
                            type: mime.getType(entity.check_file),
                        });
                    }
                }
            },
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
                console.log({
                    attachments: this.attachments,
                    media: this.media,
                });
                if (this.attachments.length > 0) {
                    formData.check_file = this.attachments[0].name;
                } else if (this.attachments.length === 0 && this.media.length === 0) {
                    formData.check_file = null;
                }
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
                            msg: 'Расход обновлен',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            }
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
