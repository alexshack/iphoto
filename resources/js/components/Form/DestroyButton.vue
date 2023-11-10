<template>
    <span v-if="store.agenda.status === 'open'">
        <a v-loading="loading" @click="confirmDelete" href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Удалить">
            <i class="feather feather-trash-2 text-danger"></i>
        </a>
    </span>
</template>

<script setup>
    import { store } from '@/store/workshift.js';
</script>

<script>
    import db from '@/db/index.js';

    export default{
        name: 'DestroyButton',
        data: () => {
            return {
                loading: false,
            };
        },
        computed: {
            available() {
                return !window.agenda.access.closed;
            }
        },
        props: {
            entity: {
                type: String,
                required: true,
            },
            id: {
                type: Number,
                required: true,
            },
            successMessage: {
                type: String,
                default: 'Удалено',
            },
        },
        methods: {
            async confirmDelete() {
                console.log('confirmDelete')
                swal({
                    title: 'Удалить?',
                    text: "Действие невозможно отменить!",
                    icon: 'warning',
                    buttons: {
                        cancel: {
                            text: 'Отмена',
                            value: null,
                            closeModal: true,
                            visible: true,
                        },
                        confirm: {
                            text: 'Удалить',
                            value: true,
                            closeModal: true,
                        },
                    },
                }).then(async (result) => {
                    if (result) {
                        await this.destroy();
                    }
                })
            },
            async destroy() {
                this.loading = true;
                if (typeof db[this.entity] != 'undefined' && typeof db[this.entity].destroy === 'function') {
                    await db[this.entity].destroy(this.id);
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            msg: this.successMessage,
                            type: 'info',
                        }
                    }));
                    this.$emit('destroyed');
                } else {
                    console.log(db[this.entity])
                }
                this.loading = false;
            },
        },
    }
</script>

<style scoped>

</style>

