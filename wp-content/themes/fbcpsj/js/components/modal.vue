<template>
    <div class="modal is-active" v-if="this.modalOpen != ''">
        <div class="modal-background" @click="toggleModal"></div>
        <div class="modal-content large">
            <image-modal v-if="this.modalOpen == 'imageViewer'" :imageUrl="this.modalContent" :aspectRatio="this.aspectRatio"><slot></slot></image-modal>
            <video-modal v-if="this.modalOpen == 'videoViewer'" :vimeoCode="this.modalContent" :aspectRatio="this.aspectRatio"></video-modal>
            <embed-modal v-if="this.modalOpen == 'embedViewer'" :htmlContent="this.modalContent" :aspectRatio="this.aspectRatio"></embed-modal>
        </div>
        <button class="modal-close is-large" @click="toggleModal"></button>
    </div>
</template>

<script>
    import ImageModal from './ImageModal.vue';
    import VideoModal from './VideoModal.vue';
    import EmbedModal from './EmbedModal.vue';

    export default {
        data() {
            return {
                showModal: false,
                modalContent: [],
                aspectRatio: '',
                modalOpen: false
            }
        },
        components: {
            'video-modal' : VideoModal,
            'image-modal': ImageModal,
            'embed-modal': EmbedModal
        },
        methods: {
            toggleModal(){
                this.showModal = !this.showModal;
                if(this.modalOpen !== ''){
                    this.modalOpen = ''
                }
            }
        },
        mounted() {
            let vm = this;
            this.$parent.$on('toggleModal', function (modal,content,aspect) {
                vm.modalOpen = modal;
                vm.modalContent = content;
                vm.aspectRatio = aspect;
            });

        }

    }
</script>