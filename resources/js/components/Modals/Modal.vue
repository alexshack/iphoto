<template>
    <div class="modal fade" :id="modalID">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <slot name="title"></slot>
                    </h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Закрыть</button>
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        name: 'Modal',
        data: () => {
            return {
                modal: null,
            };
        },
        props: {
            modalID: {
                type: String,
                default: 'modal',
            },
        },
        methods: {
            setupModal() {
                const selector = `#${this.modalID}`;
                window.addEventListener(`showModal.${this.modalID}`, () => $(selector).modal('show'));
                window.addEventListener(`hideModal.${this.modalID}`, () => $(selector).modal('hide'));
            },
        },
        mounted() {
            this.setupModal();
        },
    };
</script>

<style scoped>

</style>

