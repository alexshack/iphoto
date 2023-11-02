<template>
    <div>
        <div class="mu-container" :class="isInvalid?'mu-red-border':''">
            <Loader
                color="#0275d8"
                :active="isLoading"
                spinner="line-scale"
                background-color = 'rgba(255, 255, 255, .4)'
            />
            <div class="mu-elements-wraper">

                <!--UPLOAD BUTTON-->
                <div class="mu-plusbox-container">
                    <label for="mu-file-input" class="mu-plusbox">
                        <svg
                            class="mu-plus-icon"
                            xmlns="http://www.w3.org/2000/svg"
                            width="1em"
                            height="1em"
                            preserveAspectRatio="xMidYMid meet"
                            viewBox="0 0 24 24">
                                <g fill="none">
                                    <path
                                        d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11s11-4.925 11-11S18.075 1 12 1zm1 15a1 1 0 1 1-2 0v-3H8a1 1 0 1 1 0-2h3V8a1 1 0 1 1 2 0v3h3a1 1 0 1 1 0 2h-3v3z"
                                        fill="currentColor"/>
                                </g>
                        </svg>
                    </label>
                    <input @change="fileChange" id="mu-file-input" type="file" accept="image/*,application/pdf" multiple hidden>
                </div>

                <!--IMAGES PREVIEW-->

                <div v-for="(image, index) in savedMedia" :key="index" class="mu-image-container">
                    <img :src="image.name" alt=""  class="mu-images-preview" v-if="image.type.indexOf('image/') != -1">
                    <img class="mu-images-preview mu-pdf-preview" src="/assets/images/icons/pdf.png" alt="" v-if="image.type === 'application/pdf'">
                    <button @click="removeSavedMedia(index)" class="mu-close-btn" type="button">
                        <svg
                            class='mu-times-icon'
                            xmlns="http://www.w3.org/2000/svg"
                            width="0.65em"
                            height="0.65em"
                            preserveAspectRatio="xMidYMid meet"
                            viewBox="0 0 352 512">
                                <path
                                    d="m242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28L75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256L9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
                                    fill="currentColor"
                                />
                        </svg>
                    </button>
                    <button class="mu-preview-btn" type="button" v-if="image.type === 'application/pdf'" @click="previewPDF(image)">
                        <span class="feather feather-eye"></span>
                    </button>
                </div>
                <div v-for="(image, index) in addedMedia" :key="index" class="mu-image-container">
                    <img :src="image.url" alt=""  class="mu-images-preview" v-if="image.type.indexOf('image/') != -1">
                    <img class="mu-images-preview mu-pdf-preview" src="/assets/images/icons/pdf.png" alt="" v-if="image.type === 'application/pdf'">
                    <button @click="removeAddedMedia(index)" class="mu-close-btn" type="button">
                        <svg
                            class='mu-times-icon'
                            xmlns="http://www.w3.org/2000/svg"
                            width="0.65em"
                            height="0.65em"
                            preserveAspectRatio="xMidYMid meet"
                            viewBox="0 0 352 512">
                                <path
                                    d="m242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28L75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256L9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
                                    fill="currentColor"
                                />
                        </svg>
                    </button>
                    <button class="mu-preview-btn" type="button" v-if="image.type === 'application/pdf'" @click="previewPDF(image)">
                        <span class="feather feather-eye"></span>
                    </button>
                </div>
            </div>
        </div>
        <div>
            <div v-for="(image, index) in addedMedia" :key="index" class="mu-mt-1">
                <input type="text" name="added_media[]" :value="image.name" hidden>
            </div>
            <div v-for="(image, index) in removedMedia" :key="index" class="mu-mt-1">
                <input type="text" name="removed_media[]" :value="image.name" hidden>
            </div>
            <div v-if="allMedia.length" class="mu-mt-1">
                <input type="text" name="media" value="1" hidden>
            </div>
        </div>
        <div class="pdf-preview" :class="{active: pdfPreview}">
            <div class="pdf-preview-close" @click="previewPDFClose">
                <span class="feather feather-eye-off"></span>
            </div>
            <canvas id="pdfCanvas"></canvas>
        </div>
    </div>
</template>

<script>
    import Loader from './loader/index.vue';
    import axios from 'axios'

    export default {

        props:{
            server: {
                type: String,
                default: '/api/upload'
            },
            isInvalid: {
                type: Boolean,
                default: false
            },
            media:{
                type: Array,
                default: []
            },
            location:{
                type: String,
                default: ''
            },
            max:{
                type: Number,
                default: null
            },
            maxFilesize:{
                type: Number,
                default: 4
            },
            warnings:{
                type: Boolean,
                default: true
            }
        },
        mounted() {
            this.init()
        },
        data(){
            return{
                addedMedia:[],
                savedMedia:[],
                removedMedia:[],

                isLoading:true,

                pdfDoc: null,
                pdfPreview: null,
            }
        },
        methods:{
            init(){
                this.savedMedia = this.media

                this.savedMedia.forEach((image, index) => {
                    if(!this.savedMedia[index].url){
                        this.savedMedia[index].url = this.location + "/" + image.name
                    }
                });

                setTimeout(() => this.isLoading = false, 1000)

                this.$emit('init', this.allMedia)
            },
            async fileChange(event){
                this.isLoading = true
                let files = event.target.files

                for(var i=0; i < files.length; i++){
                        console.log(this.allMedia);
                    if(!this.max || this.allMedia.length < this.max){
                        if(files[i].size <= this.maxFilesize*1000000){
                            let formData = new FormData
                            let url = URL.createObjectURL(files[i])
                            formData.set('image', files[i])

                            const {data} = await axios.post(this.server, formData)
                            let addedImage = {url:url, name:data.name, size:files[i].size, type:files[i].type}
                            this.addedMedia.push(addedImage)

                            this.$emit('change', this.allMedia)
                            this.$emit('add', addedImage, this.addedMedia)
                        }else{
                            this.$emit('maxFilesize', files[i].size)
                            if(this.warnings){
                                alert('The file you are trying to upload is too big. \nMaximum Filesize: '+ this.maxFilesize +'MB')
                            }
                            break;
                        }
                    }else{
                        this.$emit('max')
                        if(this.warnings){
                            alert('You have reached the maximum number of files that you can upload. \nMaximum Files: '+ this.max)
                        }
                        break;
                    }
                }
                event.target.value = null
                this.isLoading = false
            },

            previewPDF(attachment) {
                this.pdfPreview = attachment;
                const name = attachment.name;
                let loadingTask = pdfjsLib.getDocument(name),
                    canvas = document.getElementById('pdfCanvas');
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
                });
            },
            previewPDFClose() {
                this.pdfPreview = null;
                this.pdfCanvas = null;
            },
            removeAddedMedia(index){
                let removedImage = this.addedMedia[index]
                this.addedMedia.splice(index,1)

                this.$emit('change', this.allMedia)
                this.$emit('remove', removedImage, this.removedMedia)
            },
            removeAllMedia() {
                this.addedMedia = [];
            },
            removeSavedMedia(index){
                let removedImage = this.savedMedia[index]
                this.removedMedia.push(removedImage)
                this.savedMedia.splice(index,1)

                this.$emit('change', this.allMedia)
                this.$emit('remove', removedImage, this.removedMedia)
            }

        },
        computed:{
            allMedia(){
                return [...this.savedMedia, ...this.addedMedia];
            }
        },
        emits: [
            'init',
            'change',
            'add',
            'remove',
            'max',
            'maxFilesize'
        ],
        components:{
            Loader
        }
    }

</script>

<style scoped>

.mu-container{
    background-color: #fbfbfb !important;
    border-radius: 5px !important;
    border-style: solid !important;
    border: 1px solid #9b9b9b !important;
    box-sizing: border-box !important;
    width: 100% !important;
    height: auto !important;
}

/* ----elements-wrapper--- */

.mu-elements-wraper {
  padding: 1rem !important;
  display: flex !important;
  flex-wrap: wrap !important;
}

/* ----plusbox--- */

.mu-plusbox-container{
    display: inline-flex !important;
    height: 90px !important;
    width: 140px !important;
    margin: 0.25rem !important;
}
.mu-plusbox {
    background-color: #ffffff !important;
    border: 1px dashed #818181 !important;
    border-radius: 5px !important;
    cursor: pointer !important;
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    width: 140px !important;
    height: 90px !important;
}
.mu-plusbox:hover{
    background-color: #f1f1f1 !important;
}
.mu-plusbox:hover > .mu-plus-icon{
    color: #028296 !important;
}
.mu-plus-icon{
    color: #00afca !important;
    font-size: 3rem !important;
    flex: 1;
}

/* ----media-preview---- */

.mu-image-container{
    width: 140px !important;
    height: 90px !important;
    margin: 0.25rem !important;

    position: relative;
}
.mu-images-preview {
    border-radius: 5px !important;
    border: 1px solid #818181 !important;
    width: 140px !important;
    height: 90px !important;
    transition: filter 0.1s linear;
    object-fit: cover;
    object-position: center;
}

.mu-images-preview.mu-pdf-preview {
    object-fit: contain;
}

.mu-images-preview:hover{
    filter: brightness(90%);
}

.mu-close-btn{
    background: none !important;
	color:white !important;
	border: none !important;
	padding: 0px !important;
    margin:0px !important;
	cursor: pointer !important;

    position: absolute !important;
    top: 0px;
    right: 0px;
}

.mu-preview-btn{
    background: none !important;
	color:white !important;
	border: none !important;
	padding: 0px !important;
    margin:0px !important;
	cursor: pointer !important;

    position: absolute !important;
    top: 5px;
    left: 5px;
    font-size: 24px;
    line-height: 24px;
    filter: drop-shadow(0px 0px 1px black);
}

.mu-times-icon{
    font-size: 3rem !important;
    filter: drop-shadow(0px 0px 1px black);
}
.mu-close-btn:hover{
    color: red !important;
}

/* -------------------- */

.mu-red-border {
    border: 1px solid #dc3545 !important;
}

.mu-mt-1 {
  margin-top: 0.25rem !important;
}

/* -------------------- */

img {
  -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
}

.pdf-preview {
    position: relative;
}

.pdf-preview .pdf-preview-close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    line-height: 24px;
    filter: drop-shadow(0px 0px 1px black);
}

.pdf-preview:not(.active) {
    display: none;
}

.pdf-preview.active{
    width: 100%;
    min-height: 30vh;
}
</style>
