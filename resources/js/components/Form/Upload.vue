<template>
    <div>
        <Upload name="fileName"
                :store_url="storeUrl"
                :destroy_url="destroyUrl"
                :headers="headers"
                @complete="uploadComplete"
                />

    </div>
</template>

<script>
    import Upload from '@beaubus/single-file-upload-for-vue';

    export default{
        name: 'UploadComponent',
        components: {
            Upload,
        },
        computed: {
            headers() {
                let headers = {
                    'Accept': 'application/json',
                };
                const meta = document.querySelector('meta[name="csrf-token"]');
                if (typeof meta != 'undefined') {
                    headers['X-CSRF-TOKEN'] = meta.getAttribute('content');
                }
                return headers;
            },
        },
        data: () => {
            return {
                storeUrl: window.workshiftUrls.file.upload,
                destroyUrl: window.workshiftUrls.file.delete,
            };
        },
        methods: {
            uploadComplete(data) {
                this.$emit('fileUploaded', data);
            }
        }
    }
</script>

<style>
div > .single-file-upload-for-vue {
    min-height: 150px;
    font-size: .75em;
}
</style>

