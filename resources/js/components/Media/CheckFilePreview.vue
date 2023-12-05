<template>
    <div class="check-file-preview">
        <div @click="openPopup" ref="popupToggler">
            <img class="preview-image" :src="url" alt="" v-if="fileType === 'image'">
            <img class="preview-image" src="/assets/images/icons/pdf.png" alt="" v-if="fileType === 'pdf'">
        </div>
        <div v-if="showPopup">
            <div class="preview-popup-wrapper">
                <div class="preview-popup" ref="popup">
                    <img :src="url" alt="" v-if="fileType === 'image'">
                    <div class="pdf-preview" v-if="fileType === 'pdf'">
                        <span v-loading="loading"></span>
                        <canvas :id="pdfCanvasID"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {waitForSelector} from '@/helpers/html.js';

    export default{
        name: 'CheckFilePreview',
        computed: {
            pdfCanvasID() {
                const randomInt = Math.floor(Math.random() * 100);
                return `pdfCanvas${randomInt}`;
            },
            fileType() {
                let fileType = 'image';
                if (this.url.indexOf('.pdf') != -1) {
                    fileType = 'pdf';
                }
                return fileType;
            },
        },
        data: () => {
            return {
                pdfPreview: null,
                showPopup: false,
                loading: true,
            };
        },
        props: {
            url: {
                type: String,
                required: true,
            },
        },
        methods: {
            handleClickOutside(event) {
                if (!this.$refs.popup || !this.$refs.popupToggler) {
                    return;
                }

                if (!this.$refs.popup.contains(event.target) && !this.$refs.popupToggler.contains(event.target)) {
                    this.showPopup = false;
                }
            },
            async openPopup() {
                this.showPopup = true;
                this.loading = true;
                if (this.fileType === 'pdf') {
                    await waitForSelector(`#${this.pdfCanvasID}`);
                    await this.previewPDF();
                }
            },
            async previewPDF() {
                let url = this.url;

                if (url.indexOf('http://') === -1 || url.indexOf('https://') === -1) {
                    url = `${window.location.origin}${url}`
                }

                const attachment = {
                    name: url,
                };

                this.pdfPreview = attachment;
                const name = attachment.name;
                let loadingTask = pdfjsLib.getDocument(name),
                    canvas = document.getElementById(this.pdfCanvasID);
                let ctx = canvas.getContext('2d'),
                    pdfDoc = null,
                    scale = .75,
                    numPage = 1;
                function generatePDF(numPage) {
                    pdfDoc.getPage(numPage).then(page => {
                        let viewport = page.getViewport({ scale });
                        const parentWidth = canvas.parentNode.clientWidth;
                        canvas.height = viewport.height;
                        canvas.width = parentWidth;
                        let renderContext = {canvasContext : ctx, viewport:  viewport}
                        page.render(renderContext);
                    })
                }

                loadingTask.promise.then(pdfDoc_ => {
                    pdfDoc = pdfDoc_;
                    generatePDF(numPage)
                    this.loading = false;
                });
            },
            previewPDFClose() {
                this.pdfPreview = null;
                this.pdfCanvas = null;
            },
        },

        mounted() {
            document.addEventListener('click', this.handleClickOutside);
        },

        unmounted() {
            document.removeEventListener('click', this.handleClickOutside);
        }
    }
</script>

<style scoped>
img.preview-image {
    width: auto;
    cursor: pointer;
    max-height: 50px;
}

.preview-popup-wrapper {
    position: fixed;
    z-index: 1000;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.5);
}

.preview-popup {
  background-color: white;
  border-radius: 0.5em;
  padding: 2em;
  margin: auto;
  min-width: 50vw;
  display: flex;
  justify-content: center;
}

.preview-popup img {
    max-width: 90%;
    margin: 0 auto;
    height: auto;
    max-height: 90vh;
}

</style>

