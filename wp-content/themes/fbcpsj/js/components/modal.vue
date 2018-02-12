<template>
    <div class="modal is-active" v-if="this.$parent.modalOpen != ''">
        <div class="modal-background" @click="toggleModal"></div>
        <div class="modal-content large">
            <image-modal v-if="this.$parent.modalOpen == 'imageViewer'" :imageUrl="this.modalContent" ><slot></slot></image-modal>
            <video-modal v-if="this.$parent.modalOpen == 'videoViewer'" :vimeoCode="this.modalContent"></video-modal>
            <embed-modal v-if="this.$parent.modalOpen == 'embedViewer'" :htmlContent="this.modalContent"></embed-modal>
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
                modalContent: []
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
                if(this.$parent.modalOpen !== ''){
                    this.$parent.modalOpen = ''
                }
            }
        },
        mounted() {
            //console.log('Component mounted.');

            this.$parent.$on('toggleModal', function (modal,content) {
                this.modalOpen = modal;
                this.$children[1].modalContent = content;
            });

        }

    }
</script>