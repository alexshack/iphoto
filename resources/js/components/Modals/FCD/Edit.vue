<template>
    <div>
        <Modal :modalID="modalID">
            <template v-slot:title>Касса</template>
            <template v-slot:body>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Вид продажи</label>
                            <v-select v-model="formData.sale_type_id" :options="saleTypes" label="name"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Сумма</label>
                            <input v-model="formData.sum" class="form-control" placeholder="Укажите сумму" type="number">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-label">Чек</div>
                            <Uploader :max="1"
                                 :disabled="preview"
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
                            <span class="font-weight-semibold">Невозможно обновить итоговую кассу:</span>
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
    import {getSaleTypes} from '@/db/sales.js';
    import mime from 'mime';
    import Modal from '@/components/Modals/Modal.vue';
    import {update} from '@/db/fcd.js';
    import { getModalID, prepareData, prepareFormData } from '@/helpers/form.js';
    import { toRaw } from 'vue';
    import Uploader from '@/components/Form/Uploader/Uploader.vue';

    export default {
        name: 'Create',
        components: {
            Modal,
            Uploader,
        },
        computed: {
            modalID() {
                let modalID;
                if (typeof this.entity != 'undefined' && typeof this.entity.id !== 'undefined') {
                    modalID = getModalID('fcd', this.entity.id);
                }
                return modalID;
            }
        },
        data: () => {
            return {
                attachments: [],
                errors: [],
                formData: {
                    check_file: null,
                    sale_type_id: null,
                    sum: null,
                    note: null,
                },
                loading: false,
                saleTypes: [],
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
                        saleTypes: this.saleTypes,
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
            setFile(data) {
                if (typeof data.path != 'undefined' && data.path) {
                    this.formData.check_file = data.path;
                }
            },
            async setSaleTypes() {
                this.saleTypes = await getSaleTypes();
            },
            async submit() {
                this.loading = true;
                this.errors = [];
                const formData = prepareFormData(this.formData);
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
                            msg: 'Итоговая касса обновлена',
                            type: 'success',
                        }
                    }));
                    this.$emit('submitted')
                }
            }
        },
        async mounted() {
            await this.setSaleTypes();
            await this.initForm();
        },
        async updated() {
            if (typeof this.entity === 'undefined' || typeof this.entity.id === 'undefined') {
                await this.initForm();
            }
        },
    };
</script>

